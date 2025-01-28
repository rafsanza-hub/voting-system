<?php

namespace App\Controllers;

use App\Models\GradeModel;
use App\Models\ProgramModel;
use App\Models\VoterModel;
use App\Models\UserModel;
use \Myth\Auth\Entities\User;
use \Myth\Auth\Authorization\GroupModel;
use \Myth\Auth\Config\Auth as AuthConfig;
use Myth\Auth\Config\Services;
use Myth\Auth\Password;

class Voter extends BaseController
{

    protected $voterModel;
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
        $this->voterModel = new VoterModel();
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $data = [
            'title' => 'List of voter',
            'voters' => $this->voterModel->getVoter(),
        ];
        return view('voters/index', $data);
    }

    public function create()
    {
        $gradeModel = new GradeModel();

        $data = [
            'title' => 'Add voter',
            'grades' =>  $gradeModel->findAll(),
        ];
        return view('voters/create', $data);
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
            'grade_id' => [
                'label' => 'grade_id',
                'rules' => 'required',
                'errors' => [
                    'required' => 'Kelas harus diisi.',
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

        // Menjalankan validasi
        if (!$validation->withRequest($this->request)->run()) {
            // Jika validasi gagal, kembali dengan pesan error
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $this->db->transStart();
        $email = mt_rand(10000, 1000000) . '@gmail.com';
        $saveUser = $this->userModel->withGroup('voter')->save([
            'username' => $this->request->getVar('username'),
            'password_hash' => Password::hash($this->request->getVar('password')),
            'email' => $email,
            'active' => 1,
        ]);

        $savevoter = $this->voterModel->save([
            'user_id' => $this->userModel->getInsertID(),
            'grade_id' => $this->request->getPost('grade_id'),
            'fullname' => $this->request->getPost('fullname'),
        ]);
        $this->db->transComplete();

        if ($this->db->transStatus() === false) {
            return redirect()->back()->withInput()->with('errors', 'Data gagal disimpan.');
        }
        return redirect()->to('voter')->with('message', 'Data berhasil disimpan.');
    }

    public function editProfile()
    {
        $gradeModel = new GradeModel();
        $voter = $this->voterModel->where('user_id', user_id())->first();
        $gradeName = $gradeModel->where('id', $voter['grade_id'])->first()['name'];
        $voter['grade_name'] = $gradeName;

        $data = [
            'title' => 'Profile',
            'voter' => $this->voterModel->getvoter($voter['id']),
        ];

        return view('voters/profile', $data);
    }

    public function edit($id)
    {

        $gradeModel = new GradeModel();
        $data = [
            'title' => 'Edit voter',
            'voter' => $this->voterModel->getVoter($id),
            'grades' =>  $gradeModel->findAll(),
        ];
        return view('voters/edit', $data);
    }

    public function update($voterId)
    {
        // return dd( $this->request->getPost());
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
        $saveUser = $this->userModel->save([
            'id' => $this->request->getPost('user_id'),
            'username' => $this->request->getPost('username'),
        ]);

        $savevoter = $this->voterModel->save([
            'id' => $voterId,
            'image' => $this->request->getPost('image'),
            'fullname' => $this->request->getPost('fullname'),
            'grade_id' => $this->request->getPost('grade_id'),
        ]);
        $this->db->transComplete();


        if ($this->db->transStatus() === false) {
            return redirect()->back()->withInput()->with('error', 'Data gagal disimpan.');
        }
        if(in_groups('voter')){
            return redirect()->back()->with('message', 'Data berhasil disimpan.');
        }
        return redirect()->to('voter')->with('message', 'Data berhasil disimpan.');
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

    public function updatePassword($voterId)
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

        $voter = $this->voterModel->find($voterId);

        $this->userModel->update($voter['user_id'], [
            'password_hash' => Password::hash($this->request->getPost('password')),
            'force_pass_reset' => 0,
        ]);

        return redirect()->to('voter')->with('message', 'Password berhasil diubah.');
}

    public function export_excel()
    {

        $voters = $this->voterModel->getVoter();


        // $user = $this->userModel->('candidate')->findAll();

        

        if (!$voters) {
            return redirect()->back()->with('error', 'Data tidak ditemukan!');
        }

        // Load library PhpSpreadsheet
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Header kolom
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Username');
        $sheet->setCellValue('C1', 'Nama');
        $sheet->setCellValue('D1', 'Kelas');

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
        foreach ($voters as $index => $voter) {
            $sheet->setCellValue('A' . $rowNumber, $index + 1);
            $sheet->setCellValueExplicit('B' . $rowNumber, $voter['username'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            $sheet->setCellValue('C' . $rowNumber, $voter['fullname']);
            $sheet->setCellValue('D' . $rowNumber, $voter['grade']);
            // Set 'username' as text to preserve original formatting
            
            $rowNumber++;
        }

        // Apply styling to data rows
        $sheet->getStyle('A2:D1' . ($rowNumber - 1))->applyFromArray($dataStyle);

        // Set predefined column widths
        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->getColumnDimension('B')->setWidth(25);
        $sheet->getColumnDimension('C')->setWidth(25);
        $sheet->getColumnDimension('D')->setWidth(15);

        // Nama file
        $filename = 'All_Pemilih_' . date('Y-m-d_H-i-s') . '.xlsx';

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

    $gradeModel = new GradeModel();
    $grades = $gradeModel->findAll();
    
    $gradeNameToId = [];
    foreach ($grades as $grade) {
        $gradeNameToId[strtolower($grade['name'])] = $grade['id'];
    }

    $reader = ($extension == 'xls') 
        ? new \PhpOffice\PhpSpreadsheet\Reader\Xls()
        : new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();

    $spreadsheet = $reader->load($file);
    $voters = $spreadsheet->getActiveSheet()->toArray();

    for ($i = 1; $i < count($voters); $i++) {
        $row = $voters[$i];
        
        if (empty(array_filter($row))) {
            continue;
        }

        $email = mt_rand(10000, 1000000) . '@gmail.com';
        
        $nis = trim($row[1] ?? ''); // c
        $fullname = trim($row[2] ?? ''); // d
        $gradeName = trim(strtolower($row[3] ?? '')); // e

        // ambil pw
        $firstName = ucfirst(strtolower(explode(' ', $fullname)[0])); // Ambil nama depan dan capitalize
        $lastTwoDigits = substr($nis, -2); // Ambil 2 digit terakhir NIS
        $password = $firstName . '@' . $lastTwoDigits;

        // nis/ username
        if (empty($nis)) {
            $this->db->transRollback();
            session()->setFlashdata('error', 'NIS tidak boleh kosong pada baris ' . ($i + 1));
            return redirect()->back()->withInput();
        }

        // fullname
        if (empty($fullname)) {
            $this->db->transRollback();
            session()->setFlashdata('error', 'Nama Lengkap tidak boleh kosong pada baris ' . ($i + 1));
            return redirect()->back()->withInput();
        }

        // kelas
        if (empty($gradeName)) {
            $this->db->transRollback();
            session()->setFlashdata('error', 'Kelas tidak boleh kosong pada baris ' . ($i + 1));
            return redirect()->back()->withInput();
        }

        // kelas
        if (!isset($gradeNameToId[$gradeName])) {
            $this->db->transRollback();
            session()->setFlashdata('error', 'Kelas "' . $row[3] . '" tidak ditemukan pada baris ' . ($i + 1));
            return redirect()->back()->withInput();
        }

        $userData = [
            'username' => $nis, 
            'email' => $email,
            'password_hash' => Password::hash($password),
            'active' => 1
        ];

        if ($this->userModel->where('username', $userData['username'])->first()) {
            $this->db->transRollback();
            session()->setFlashdata('error', 'NIS ' . $userData['username'] . ' sudah terdaftar pada baris ' . ($i + 1));
            return redirect()->back()->withInput();
        }

        $this->userModel->withGroup('voter')->save($userData);
        $userId = $this->userModel->getInsertID();

        $voterData = [
            'user_id' => $userId,
            'fullname' => $fullname,
            'grade_id' => $gradeNameToId[$gradeName]
        ];

        $this->voterModel->save($voterData);
    }

    $this->db->transComplete();

    if ($this->db->transStatus() === false) {
        session()->setFlashdata('error', 'Gagal menyimpan data ke database');
        return redirect()->back()->withInput();
    }

    session()->setFlashdata('message', 'Data pemilih berhasil diimport');
    return redirect()->to('/voter');
}

public function template()
    {
        // Load library PhpSpreadsheet
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
    
        // Header kolom
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Username');
        $sheet->setCellValue('C1', 'Nama Lengkap');
        $sheet->setCellValue('D1', 'Kelas');
    
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
        $sheet->getColumnDimension('B')->setWidth(25);
        $sheet->getColumnDimension('C')->setWidth(25);
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
        $sheet->getStyle('A2:D23')->applyFromArray($dataStyle);
    
        // Nama file template
        $filename = 'Template_Pemilih_' . date('Y-m-d_H-i-s') . '.xlsx';
    
        // Download file
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
    
        $writer->save('php://output');
        exit;
    }

}
