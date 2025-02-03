<?php

namespace App\Models;

use CodeIgniter\Model;

class VoterModel extends Model
{
    protected $table = 'voters';
    protected $allowedFields = ['nis', 'fullname', 'grade_id', 'program_id', 'user_id', 'image'];

    public function getVoter($id = null)
    {
        if ($id) {
            return $this->select('voters.*, users.username, users.email, users.active, grades.name as grade,')
                ->join('users', 'voters.user_id = users.id')
                ->join('grades', 'voters.grade_id = grades.id')
                ->where('voters.id', $id)
                ->first();
        } else {
            return $this->select('voters.*, users.username, users.email, users.active, grades.name as grade,')
                ->join('users', 'voters.user_id = users.id')
                ->join('grades', 'voters.grade_id = grades.id')
                ->findAll();
        }
    }

    public function getGradesWithStatistics()
    {
        return $this->db->table('grades')
            ->select('grades.id, grades.name, 
                      COUNT(voters.id) as total_voters, 
                      COUNT(votes.id) as voted_count')
            ->join('voters', 'voters.grade_id = grades.id', 'left')
            ->join('votes', 'votes.voter_id = voters.id', 'left')
            ->groupBy('grades.id')
            ->get()
            ->getResultArray();
    }

    // Ambil daftar voter beserta status voting per kelas
    public function getVotersWithVoteStatus($gradeId)
    {
        // Mengambil data pemilih dan status apakah sudah vote atau belum
        return $this->db->table('voters')
            ->select("voters.id, voters.fullname, 
                      CASE WHEN votes.id IS NOT NULL THEN 1 ELSE 0 END as has_voted", false)
            ->join('votes', 'votes.voter_id = voters.id', 'left')
            ->where('voters.grade_id', $gradeId)
            ->get()
            ->getResultArray(); // Mengembalikan hasil dalam bentuk array
    }
    
    
    
    
    
    
}
