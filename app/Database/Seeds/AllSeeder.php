<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Exception;
use Myth\Auth\Password;

class AllSeeder extends Seeder
{
    public function run()
    {
        $this->db->transStart();

        try {
            // 1. Groups
            $groups = [
                [
                    'name' => 'admin',
                    'description' => 'Group for admin'
                ],
                [
                    'name' => 'candidate',
                    'description' => 'Group for candidate'
                ],
                [
                    'name' => 'voter',
                    'description' => 'Group for voter'
                ],
            ];

            echo "Inserting groups...\n";
            $groupResult = $this->db->table('auth_groups')->insertBatch($groups);
            if (!$groupResult) {
                throw new Exception('Failed to insert groups: ' . json_encode($this->db->error()));
            }

            // 2. Permissions
            echo "Creating permissions...\n";
            $permissions = [
                [
                    'name' => 'manageUsers',
                    'description' => 'Mengelola pengguna dalam sistem'
                ],
                [
                    'name' => 'manageCandidates',
                    'description' => 'Mengelola data kandidat'
                ],
                [
                    'name' => 'manageVotes',
                    'description' => 'Mengelola dan melihat hasil pemungutan suara'
                ],
                [
                    'name' => 'viewReports',
                    'description' => 'Melihat laporan pemungutan suara'
                ],
                [
                    'name' => 'vote',
                    'description' => 'Memberikan suara kepada kandidat'
                ],
                [
                    'name' => 'viewCandidates',
                    'description' => 'Melihat daftar kandidat yang tersedia'
                ],
                [
                    'name' => 'viewVoteStatus',
                    'description' => 'Melihat status pemungutan suara'
                ]
            ];
            
            $permResult = $this->db->table('auth_permissions')->insertBatch($permissions);
            if (!$permResult) {
                throw new Exception('Failed to insert permissions: ' . json_encode($this->db->error()));
            }

            // 3. Group Permissions
            echo "Assigning permissions to groups...\n";
            $groupPermissions = [
                // Admin permissions
                ['group_id' => 1, 'permission_id' => 1], // manageUsers
                ['group_id' => 1, 'permission_id' => 2], // manageCandidates
                ['group_id' => 1, 'permission_id' => 3], // manageVotes
                ['group_id' => 1, 'permission_id' => 4], // viewReports
                
                // Voter permissions
                ['group_id' => 3, 'permission_id' => 5], // vote
                ['group_id' => 3, 'permission_id' => 6], // viewCandidates
                ['group_id' => 3, 'permission_id' => 7], // viewVoteStatus
            ];
            
            $groupPermResult = $this->db->table('auth_groups_permissions')->insertBatch($groupPermissions);
            if (!$groupPermResult) {
                throw new Exception('Failed to insert group permissions: ' . json_encode($this->db->error()));
            }

            // 4. Configuration
            echo "Creating configuration...\n";
            $configData = [
                'name'       => 'E-Voting',
                'logo'       => 'default-logo.png',
                'address'    => 'Jl. Example Street No. 123',
                'email'      => 'smkn2kng@gmail.com',
                'phone'      => '62895804217653',
                'website'    => 'https://smkn2-kng.sch.id/'
            ];
            
            $configResult = $this->db->table('configurations')->insert($configData);
            if (!$configResult) {
                throw new Exception('Failed to insert configuration: ' . json_encode($this->db->error()));
            }

            $periodData = [
                'name'       => 'Pemilihan Ketua OSIS 2025',
                'status'   => 'completed',
                'start_date' => '2025-09-01',
                'end_date'   => '2025-09-30'
            ];
            
            $periodResult = $this->db->table('periods')->insert($periodData);
            if (!$periodResult) {
                throw new Exception('Failed to insert period: ' . json_encode($this->db->error()));
            }

            // 5. Admin User
            echo "Creating admin user...\n";
            $userData = [
                'username'      => 'admin',
                'password_hash' => Password::hash('admin123'),
                'active'        => 1
            ];
            
            $userResult = $this->db->table('users')->insert($userData);
            if (!$userResult) {
                throw new Exception('Failed to insert user: ' . json_encode($this->db->error()));
            }
            $userId = $this->db->insertID();

            // 6. Admin Profile
            echo "Creating admin profile...\n";
            $adminData = [
                'user_id'    => $userId, // Menggunakan $userId 
                'fullname'   => 'Administrator'
            ];
            
            $adminResult = $this->db->table('admins')->insert($adminData);
            if (!$adminResult) {
                throw new Exception('Failed to insert admin: ' . json_encode($this->db->error()));
            }

            // 7. User Group Assignment
            echo "Assigning admin to group...\n";
            $userGroupData = [
                'user_id'    => $userId, // Menggunakan $userId
                'group_id'   => 1
            ];
            
            $groupAssignResult = $this->db->table('auth_groups_users')->insert($userGroupData);
            if (!$groupAssignResult) {
                throw new Exception('Failed to assign user to group: ' . json_encode($this->db->error()));
            }

            if ($this->db->transStatus() === false) {
                throw new Exception('Transaction failed: ' . json_encode($this->db->error()));
            }

            $this->db->transCommit();
            echo "Seeder berhasil dijalankan!\n";
            
        } catch (Exception $e) {
            $this->db->transRollback();
            
            // Tampilkan error yang lebih detail
            $error = $e->getMessage();
            $lastQuery = $this->db->getLastQuery();
            die("Error: $error\nLast Query: $lastQuery\n");
        }
    }
}