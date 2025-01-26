<?php

namespace App\Models;

use CodeIgniter\Model;

class AdminModel extends Model
{
    protected $table = 'admins';
    protected $allowedFields = ['fullname', 'user_id', 'image'];

    public function getAdmin($id = null)
    {
        if ($id) {
            return $this->select('admins.*, users.username, users.email, users.active')
                ->join('users', 'admins.user_id = users.id')
                ->where('admins.id', $id)
                ->first();
        } else {
            return $this->select('admins.*, users.username, users.email, users.active')
                ->join('users', 'admins.user_id = users.id')
                ->findAll();
        }
    }
}
