<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Complaint extends BaseController
{
    // Menampilkan form pengaduan
    public function index()
    {
        return view('complaint/index'); // Sesuaikan dengan nama view Anda
    }

    // Menangani submit form pengaduan
    public function submit()
    {
        $data = [
            'nis' => $this->request->getPost('nis'),
            'full_name' => $this->request->getPost('full_name'),
            'class' => $this->request->getPost('class'),
            'complaint' => $this->request->getPost('complaint')
        ];

       

        return redirect()->to('/complaint/index')->with('message', 'Pengaduan berhasil dikirim.');
    }
}