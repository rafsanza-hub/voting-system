<?php

namespace App\Controllers;

use App\Models\PeriodModel;
use App\Models\UserModel;
use \Myth\Auth\Entities\User;
use \Myth\Auth\Authorization\GroupModel;
use \Myth\Auth\Config\Auth as AuthConfig;
use Myth\Auth\Config\Services;
use Myth\Auth\Password;

class period extends BaseController
{

    protected $periodModel;
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->periodModel = new PeriodModel();
    }

    public function index()
    {
        $periods = $this->periodModel->findAll();
        $dataExists = !empty($periods);
        // foreach ($periods as &$period) {
        //     $period["status"] = $this->checkPeriodStatus($period);
        // }
        $data = [
            'title' => 'List of period',
            'periods' => $periods,
            'dataExists' => $dataExists
        ];
        return view('periods/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Add period',
        ];
        return view('periods/create', $data);
    }

    // public function checkPeriodStatus($period)
    // {
    //     $currentDate = date('Y-m-d H:i:s');

    //     if ($currentDate < $period["start_date"]) {
    //         return 'Menunggu';
    //     } elseif ($currentDate >= $period["start_date"] && $currentDate <= $period["end_date"]) {
    //         return 'Sedang Berlangsung';
    //     } else {
    //         return 'Berakhir';
    //     }
    // }

    public function save()
    {

        $validation = \Config\Services::validation();

        // Menentukan aturan validasi
        $validation->setRules([
            'name' => [
                'label' => 'name',
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama harus diisi.',
                ],
            ],
            'start_date' => [
                'label' => 'start_date',
                'rules' => 'required',
                'errors' => [
                    'required' => 'start_date harus diisi.',
                ],
            ],
            'end_date' => [
                'label' => 'end_date',
                'rules' => 'required',
                'errors' => [
                    'required' => 'end_date harus diisi.',
                ],
            ],
        ]);

        // Menjalankan validasi
        if (!$validation->withRequest($this->request)->run()) {
            // Jika validasi gagal, kembali dengan pesan error
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }
        $existingData = $this->periodModel->first();

        if ($existingData) {
            $this->periodModel->save([
                'id' => $existingData['id'],
                'name' => $this->request->getPost('name'),
                'start_date' => $this->request->getPost('start_date'),
                'end_date' => $this->request->getPost('end_date'),
            ]);
        } else {
            // belum ada
            $this->periodModel->save([
                'name' => $this->request->getPost('name'),
                'start_date' => $this->request->getPost('start_date'),
                'end_date' => $this->request->getPost('end_date'),
            ]);
        }

        return redirect()->to('period')->with('message', 'Data berhasil disimpan.');
    }


    public function edit($id)
    {
        $data = [
            'title' => 'Edit period',
            'period' => $this->periodModel->getperiod($id),
        ];
        return view('periods/edit', $data);
    }

    public function update($periodId)
    {
        $validation = \Config\Services::validation();

        // Menentukan aturan validasi
        $validation->setRules([
            'name' => [
                'label' => 'name',
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama harus diisi.',
                ],
            ],
            'start_date' => [
                'label' => 'start_date',
                'rules' => 'required',
                'errors' => [
                    'required' => 'start_date harus diisi.',
                ],
            ],
            'end_date' => [
                'label' => 'end_date',
                'rules' => 'required',
                'errors' => [
                    'required' => 'end_date harus diisi.',
                ],
            ],
        ]);

        // Menjalankan validasi
        if (!$validation->withRequest($this->request)->run()) {
            // Jika validasi gagal, kembali dengan pesan error
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }




        $this->periodModel->save([
            'id' => $this->request->getPost('id'),
            'name' => $this->request->getPost('name'),
            'start_date' => $this->request->getPost('start_date'),
            'end_date' => $this->request->getPost('end_date'),
        ]);

        return redirect()->to('period')->with('message', 'Data berhasil disimpan.');
    }

    public function updateStatus()
    {
        // return dd($this->request->getPost());

        // Ambil data dari form
        $periodId = $this->request->getPost('periodId');
        $newStatus = $this->request->getPost('status');

        // Validasi data
        if (empty($periodId) || empty($newStatus)) {
            return redirect()->back()->with('error', 'Data tidak valid.');
        }

        // Update status
        $this->periodModel->save([
            'id' => $periodId, 
            'status' => $newStatus]);

        // Redirect dengan pesan sukses
        return redirect()->to('/period')->with('message', 'Status voting berhasil diperbarui.');
    }


    public function delete($id)
    {

        $this->periodModel->delete($id, true);
        return redirect()->to('period');
    }
}
