<?php

namespace App\Controllers;

use App\Models\AdminModel;
use App\Models\UserModel;
use \Myth\Auth\Entities\User;
use \Myth\Auth\Authorization\GroupModel;
use \Myth\Auth\Config\Auth as AuthConfig;
use Myth\Auth\Config\Services;
use Myth\Auth\Password;

class Admin extends BaseController
{

    protected $adminModel;
    protected $userModel;
    protected $auth;
    /**
     * @var AuthConfig
     */
    protected $config;
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->config = config('Auth');
        $this->auth   = service('authentication');
        $this->adminModel = new AdminModel();
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $data = [
            'title' => 'List of admin',
            'admins' => $this->adminModel->getadmin(),
        ];
        return view('admins/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Add admin',
        ];
        return view('admins/create', $data);
    }

    public function save()
    {

        $validation = \Config\Services::validation();

        // Menentukan aturan validasi
        $validation->setRules([
            'fullname' => [
                'label' => 'fullname',
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama lengkap harus diisi.',
                ],
            ],
            'username' => [
                'label' => 'Username',
                'rules' => 'required|is_unique[users.username]',
                'errors' => [
                    'required' => 'Username harus diisi.',
                    'is_unique' => 'Username sudah terdaftar.'
                ]
            ],
            'password' => [
                'label' => 'Password',
                'rules' => 'required',
                'errors' => [
                    'required' => 'Password harus diisi.',
                ]
            ],
            'pass_confirm' => [
                'label' => 'pass_confirm',
                'rules' => 'required|matches[password]',
                'errors' => [
                    'required' => 'Password harus diisi.',
                    'matches' => 'Password harus sama.'
                ]
            ],
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            // Jika validasi gagal, kembali dengan pesan error
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $this->db->transStart();
        $email = mt_rand(10000, 1000000) . '@gmail.com';
        $this->userModel->withGroup('admin')->save([
            'username' => $this->request->getVar('username'),
            'password_hash' => Password::hash($this->request->getVar('password')),
            'email' => $email,
            'active' => 1,
        ]);

        $this->adminModel->save([
            'user_id' => $this->userModel->getInsertID(),
            'fullname' => $this->request->getPost('fullname'),
        ]);
        $this->db->transComplete();

        if ($this->db->transStatus() === false) {
            return redirect()->back()->withInput()->with('errors', 'Data gagal disimpan.');
        }
        return redirect()->to('admin')->with('message', 'Data berhasil disimpan.');
    }

    public function editProfile()
    {
        $admin = $this->adminModel->where('user_id', user_id())->first();

        $data = [
            'title' => 'Profile',
            'admin' => $this->adminModel->getAdmin($admin['id']),
        ];

        return view('admins/profile', $data);
    }


    public function edit($id)
    {
        $data = [
            'title' => 'Edit admin',
            'admin' => $this->adminModel->getadmin($id),
        ];
        return view('admins/edit', $data);
    }

    public function update($adminId)
    {
        $validation = \Config\Services::validation();

        // Menentukan aturan validasi
        $validation->setRules([
            'fullname' => [
                'label' => 'fullname',
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama lengkap harus diisi.',
                ],
            ],

            // 'username' => [
            //     'label' => 'Username',
            //     'rules' => "required|is_unique[users.username,users.id,{id}]",
            //     'errors' => [
            //         'required' => 'Username harus diisi.',
            //         'is_unique' => 'Username sudah terdaftar.'
            //     ]
            // ],
            // 'email' => [
            //     'label' => 'email',
            //     'rules' => "required|is_unique[users.email,users.id,{id}]",
            //     'errors' => [
            //         'required' => 'email harus diisi.',
            //         'is_unique' => 'email sudah terdaftar.'
            //     ]
            // ],
        ]);

        // Menjalankan validasi
        if (!$validation->withRequest($this->request)->run()) {
            // Jika validasi gagal, kembali dengan pesan error
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $this->db->transStart();
        $this->userModel->save([
            'id' => $this->request->getPost('user_id'),
            'username' => $this->request->getPost('username'),
        ]);

        $this->adminModel->save([
            'id' => $adminId,
            'image' => $this->request->getPost('image'),
            'fullname' => $this->request->getPost('fullname'),
        ]);
        $this->db->transComplete();


        if ($this->db->transStatus() === false) {
            return redirect()->back()->withInput()->with('errors', 'Data gagal disimpan.');
        }

        if(previous_url() == base_url('admin/profile')) {
            return redirect()->back()->with('message', 'Data berhasil disimpan.');;
        }
        return redirect()->to('admin')->with('message', 'Data berhasil disimpan.');
    }


    public function delete($userId)
    {
        // CASCADE
        $this->userModel->delete($userId, true);
        $response = [
            'success' => true,
            'message' => 'Data berhasil dihapus'
        ];
        return $this->response->setJSON($response);
    }


    public function updatePassword($adminId)
    {
        $validation = \Config\Services::validation();

        $validation->setRules([
            'password' => [
                'label' => 'Password',
                'rules' => 'required|min_length[8]',
                'errors' => [
                    'required' => 'Password baru harus diisi.',
                    'min_length' => 'Password minimal 8 karakter.'
                ]
            ],
            'password_confirm' => [
                'label' => 'Konfirmasi Password',
                'rules' => 'required|matches[password]',
                'errors' => [
                    'required' => 'Konfirmasi password harus diisi.',
                    'matches' => 'Konfirmasi password tidak cocok.'
                ]
            ],
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $admin = $this->adminModel->find($adminId);

        $this->userModel->update($admin['user_id'], [
            'password_hash' => Password::hash($this->request->getPost('password')),
            'force_pass_reset' => 0,
        ]);

        return redirect()->to('admin')->with('message', 'Password berhasil diubah.');
    }

    public function export_excel()
    {

        $admins = $this->adminModel->getAdmin();


        // $user = $this->userModel->('admin')->findAll();



        if (!$admins) {
            return redirect()->back()->with('error', 'Data tidak ditemukan!');
        }

        // Load library PhpSpreadsheet
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Header kolom
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Nama');
        $sheet->setCellValue('C1', 'Username');

        // Styling header
        $headerStyle = [
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF']
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => '4CAF50']
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => '000000']
                ]
            ]
        ];

        $sheet->getStyle('A1:C1')->applyFromArray($headerStyle);

        // Styling data
        $dataStyle = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => '000000']
                ]
            ]
        ];

        // Isi data kandidat
        $rowNumber = 2; // Dimulai dari baris kedua
        foreach ($admins as $index => $admin) {
            $sheet->setCellValue('A' . $rowNumber, $index + 1);
            $sheet->setCellValue('B' . $rowNumber, $admin['fullname']);

            // Set 'username' as text to preserve original formatting
            $sheet->setCellValueExplicit('C' . $rowNumber, $admin['username'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            $rowNumber++;
        }

        // Apply styling to data rows
        $sheet->getStyle('A2:C1' . ($rowNumber - 1))->applyFromArray($dataStyle);

        // Set predefined column widths
        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->getColumnDimension('B')->setWidth(25);
        $sheet->getColumnDimension('C')->setWidth(25);

        // Nama file
        $filename = 'All_Admin_' . date('Y-m-d_H-i-s') . '.xlsx';

        // Download file
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    }

    public function import_excel()
    {
        $rules = [
            'file_excel' => [
                'label' => 'File Excel',
                'rules' => 'uploaded[file_excel]|max_size[file_excel,10240]|mime_in[file_excel,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet]',
                'errors' => [
                    'uploaded' => 'Harus upload {field} *',
                    'max_size' => 'File maksimal 10MB *',
                    'mime_in' => 'Harus berupa file Excel (xls atau xlsx) *',
                ],
            ],
        ];

        if (!$this->validate($rules)) {
            session()->setFlashdata('warning', 'Periksa kembali, terdapat beberapa kesalahan yang perlu diperbaiki.');
            session()->setFlashdata('modal_id', 'importExcelModal');
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $file = $this->request->getFile('file_excel');
        $extension = $file->getClientExtension();

        $this->db->transStart();


        $reader = ($extension == 'xls')
            ? new \PhpOffice\PhpSpreadsheet\Reader\Xls()
            : new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();

        $spreadsheet = $reader->load($file);
        $admins = $spreadsheet->getActiveSheet()->toArray();

        for ($i = 1; $i < count($admins); $i++) {
            $row = $admins[$i];

            if (empty(array_filter($row))) {
                continue;
            }

            $email = mt_rand(10000, 1000000) . '@gmail.com';

            $name = trim($row[1] ?? ''); // d
            $username = trim(strtolower($row[2] ?? '')); // e
            $password = $row[3] ?? '';

            // nis/ username
            if (empty($name)) {
                $this->db->transRollback();
                session()->setFlashdata('error', 'Nama tidak boleh kosong pada baris ' . ($i + 1));
                return redirect()->back()->withInput();
            }

            // fullname
            if (empty($username)) {
                $this->db->transRollback();
                session()->setFlashdata('error', 'Usernama Lengkap tidak boleh kosong pada baris ' . ($i + 1));
                return redirect()->back()->withInput();
            }


            // password
            if (empty($password)) {
                $this->db->transRollback();
                session()->setFlashdata('error', 'Password tidak boleh kosong pada baris ' . ($i + 1));
                return redirect()->back()->withInput();
            }

            $userData = [
                'username' => $username,
                'email' => $email,
                'password_hash' => Password::hash($password),
                'active' => 1
            ];

            if ($this->userModel->where('username', $userData['username'])->first()) {
                $this->db->transRollback();
                session()->setFlashdata('error', 'username' . $userData['username'] . ' sudah terdaftar pada baris ' . ($i + 1));
                return redirect()->back()->withInput();
            }

            $this->userModel->withGroup('admin')->save($userData);
            $userId = $this->userModel->getInsertID();

            $adminData = [
                'user_id' => $userId,
                'fullname' => $name,
                'username' => $username,
            ];

            $this->adminModel->save($adminData);
        }

        $this->db->transComplete();

        if ($this->db->transStatus() === false) {
            session()->setFlashdata('error', 'Gagal menyimpan data ke database');
            return redirect()->back()->withInput();
        }

        session()->setFlashdata('message', 'Data Admin berhasil diimport');
        return redirect()->to('/admin');
    }

    public function template()
    {
        // Load library PhpSpreadsheet
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Header kolom
        $sheet->setCellValue('A1', 'NO');
        $sheet->setCellValue('B1', 'Nama');
        $sheet->setCellValue('C1', 'Username');
        $sheet->setCellValue('D1', 'Password');

        // Styling header
        $headerStyle = [
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF']
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => '4CAF50']
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => '000000']
                ]
            ]
        ];

        $sheet->getStyle('A1:D1')->applyFromArray($headerStyle);

        // Set predefined column widths
        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->getColumnDimension('B')->setWidth(15);
        $sheet->getColumnDimension('C')->setWidth(15);
        $sheet->getColumnDimension('D')->setWidth(15);

        // Align the numbers in column A to the center
        $sheet->getStyle('A2:A23')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        // Styling data (empty rows for template)
        $dataStyle = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => '000000']
                ]
            ]
        ];

        // Apply styling to data rows (2 empty rows as template)
        $sheet->getStyle('A2:D15')->applyFromArray($dataStyle);

        // Nama file template
        $filename = 'Template_Admin_' . date('Y-m-d_H-i-s') . '.xlsx';

        // Download file
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    }
}
