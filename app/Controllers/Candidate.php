<?php

namespace App\Controllers;

use App\Models\CandidateModel;
use App\Models\GradeModel;
use App\Models\ProgramModel;
use App\Models\UserModel;
use Exception;
use \Myth\Auth\Config\Auth as AuthConfig;
use Myth\Auth\Password;
use PHPUnit\Framework\Constraint\ExceptionMessageIsOrContains;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


class Candidate extends BaseController
{
    protected $candidateModel;
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
        $this->candidateModel = new CandidateModel();
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $data = [
            'title' => 'List of Candidates',
            'candidates' => $this->candidateModel->getCandidate(),
        ];
        return view('candidates/index', $data);
    }

    public function create()
    {
        $gradeModel = new GradeModel();
        $used_numbers = $this->candidateModel->getUsedOrderNumbers();
        // dd($used_numbers);
        $used_numbers = array_map(function ($item) {
            return str_pad($item['candidate_order'], 2, '0', STR_PAD_LEFT);
        }, $used_numbers);

        $data = [
            'title' => 'Add Candidate',
            'grades' =>  $gradeModel->findAll(),
            'used_numbers' => $used_numbers,
        ];
        return view('candidates/create', $data);
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
            'candidate_order' => [
                'label' => 'candidate_order',
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nomor urut harus di isi',
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
            'vision' => [
                'label' => 'vision',
                'rules' => 'required',
                'errors' => [
                    'required' => 'Visi harus di isi',
                ]
            ],
            'mission' => [
                'label' => 'mission',
                'rules' => 'required',
                'errors' => [
                    'required' => 'Misi harus di isi',
                ]
            ],
            'image' => [
                'label' => 'image',
                'rules' => 'uploaded[image]|max_size[image,5108]|is_image[image]|mime_in[image,image/png,image/jpg,image/jpeg]',
                'errors' => [
                    'uploaded' => '{field} harus diisi.',
                    'max_size' => 'Ukuran {field} terlalu besar, max 5MB.',
                    'is_image' => '{field} harus berupa gambar',
                    'mime_in' =>  '{field} harus berformat png, jpg, atau jpeg.'
                ]
            ],
        ]);
        $tes = $this->request->getFile('image');
        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $this->db->transStart();
        $image = $this->request->getFile('image');
        if ($image->isValid()) {
            $filename = $image->getRandomName();
            $image->move('img/', $filename);
        }


        $email = mt_rand(10000, 1000000) . '@gmail.com';
        $this->userModel->withGroup('candidate')->save([
            'username' => $this->request->getPost('username'),
            'password_hash' => Password::hash($this->request->getPost('password')),
            'email' => $email,
            'active' => 1,
        ]);

        $this->candidateModel->save([
            'user_id' => $this->userModel->getInsertID(),
            'grade_id' => $this->request->getPost('grade_id'),
            'candidate_order' => $this->request->getPost('candidate_order'),
            'fullname' => $this->request->getPost('fullname'),
            'vision' => $this->request->getPost('vision'),
            'mission' => $this->request->getPost('mission'),
            'image' => $filename,
        ]);
        $this->db->transComplete();

        if ($this->db->transStatus() === false) {
            return redirect()->back()->withInput()->with('errors', 'Data gagal disimpan.');
        }
        return redirect()->to('candidate')->with('message', 'Data berhasil disimpan.');
    }



    public function edit($id)
    {
        $gradeModel = new GradeModel();

        $used_numbers = $this->candidateModel->getUsedOrderNumbers();
        // dd($used_numbers);
        $used_numbers = array_map(function ($item) {
            return str_pad($item['candidate_order'], 2, '0', STR_PAD_LEFT);
        }, $used_numbers);


        $data = [
            'title' => 'Add Candidate',
            'candidate' => $this->candidateModel->getCandidate($id),
            'grades' =>  $gradeModel->findAll(),
            'used_numbers' => $used_numbers,
        ];

        return view('candidates/edit', $data);
    }
    public function editProfile()
    {
        $candidate = $this->candidateModel->where('user_id', user_id())->first();

        $gradeModel = new GradeModel();
        $data = [
            'title' => 'Add Candidate',
            'candidate' => $this->candidateModel->getCandidate($candidate['id']),
            'grades' =>  $gradeModel->findAll(),
        ];

        return view('candidates/profile', $data);
    }

    public function update($id)
    {
        $validation = \Config\Services::validation();

        // return dd([$this->request->getFile('image'), $this->request->getPost()]);
        $data = [
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
            'vision' => [
                'label' => 'vision',
                'rules' => 'required',
                'errors' => [
                    'required' => 'Visi harus di isi',
                ]
            ],
            'mission' => [
                'label' => 'mission',
                'rules' => 'required',
                'errors' => [
                    'required' => 'Misi harus di isi',
                ]
            ],
        ];
        if (!in_groups('candidate')) {
            $data['candidate_order'] = [
                    'label' => 'candidate_order',
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Nomor urut harus di isi',
                    ]
            ];
        }
        if (!$this->request->getPost('image') && $this->request->getFile('image')):
            $data['image'] = [
                'label' => 'image',
                'rules' => 'uploaded[image]|max_size[image,5108]|is_image[image]|mime_in[image,image/png,image/jpg,image/jpeg]',
                'errors' => [
                    'uploaded' => '{field} harus diisi.',
                    'max_size' => 'Ukuran {field} terlalu besar, max 5MB.',
                    'is_image' => '{field} harus berupa gambar',
                    'mime_in' =>  '{field} harus berformat png, jpg, atau jpeg.'
                ]
            ];
        endif;
        // Menentukan aturan validasi
        $validation->setRules($data);

        // Menjalankan validasi
        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $oldImage = $this->request->getPost('oldImage');
        $image = $this->request->getFile('image');
        // return dd($image); 
        if ($image && $image->isValid()):
            $this->db->transStart();
            if (!$image->hasMoved()) {
                $filename = $image->getRandomName();
                $image->move('img/', $filename);
            }

            if (!empty($oldImage) && file_exists('img/' . $oldImage) && $oldImage != 'default.png') {
                unlink('img/' . $oldImage);
            }

            $this->userModel->save([
                'id' => $this->request->getPost('user_id'),
                'username' => $this->request->getPost('username'),
            ]);

            $this->candidateModel->save([
                'id' => $id,
                'grade_id' => $this->request->getPost('grade_id'),
                'fullname' => $this->request->getPost('fullname'),
                'vision' => $this->request->getPost('vision'),
                'mission' => $this->request->getPost('mission'),
                'image' => $filename,
            ]);
            $this->db->transComplete();
        else:
            $this->db->transStart();
            $this->userModel->save([
                'id' => $this->request->getPost('user_id'),
                'username' => $this->request->getPost('username'),
            ]);

            $this->candidateModel->save([
                'id' => $id,
                'grade_id' => $this->request->getPost('grade_id'),
                'candidate_order' => $this->request->getPost('candidate_order'),
                'fullname' => $this->request->getPost('fullname'),
                'vision' => $this->request->getPost('vision'),
                'mission' => $this->request->getPost('mission'),
            ]);
            $this->db->transComplete();
        endif;

        if ($this->db->transStatus() === false) {
            return redirect()->back()->withInput()->with('error', 'Data gagal disimpan.');
        }
        if (in_groups('candidate')) {
            return redirect()->back()->with('message', 'Data berhasil disimpan.');
        }
        return redirect()->to('candidate')->with('message', 'Data berhasil disimpan.');
    }

    public function delete($id)
    {
        $this->db->transStart();
        $candidate = $this->candidateModel->find($id);
        if ($candidate['image'] != 'default.png') {
            unlink('img/' . $candidate['image']);
        }
        $this->userModel->delete($candidate['user_id'],true);
        $this->db->transComplete();
        if ($this->db->transStatus() === false) {
            return redirect()->back()->with('error', 'Data gagal di hapus.');
        }
        $response = [
            'success' => true,
            'message' => 'Data berhasil dihapus'
        ];
        return $this->response->setJSON($response);
    }

    public function updatePassword($candidateId)
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

        $candidate = $this->candidateModel->find($candidateId);

        $this->userModel->update($candidate['user_id'], [
            'password_hash' => Password::hash($this->request->getPost('password')),
            'force_pass_reset' => 0,
        ]);

        return redirect()->to('candidate')->with('message', 'Password berhasil diubah.');
    }

    public function export_excel()
    {
        $candidates = $this->candidateModel->getCandidate();

        if (!$candidates) {
            return redirect()->back()->with('error', 'Data tidak ditemukan!');
        }

        // Load library PhpSpreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Header kolom
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Nama');
        $sheet->setCellValue('C1', 'Username');
        $sheet->setCellValue('D1', 'Visi');
        $sheet->setCellValue('E1', 'Misi');

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

        $sheet->getStyle('A1:E1')->applyFromArray($headerStyle);

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
        foreach ($candidates as $index => $candidate) {
            $sheet->setCellValue('A' . $rowNumber, $index + 1);
            $sheet->setCellValue('B' . $rowNumber, $candidate['fullname']);

            // Set 'username' as text to preserve original formatting
            $sheet->setCellValueExplicit('C' . $rowNumber, $candidate['username'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);

            $sheet->setCellValue('D' . $rowNumber, $candidate['vision']);
            $sheet->setCellValue('E' . $rowNumber, $candidate['mission']);
            $rowNumber++;
        }

        // Apply styling to data rows
        $sheet->getStyle('A2:E' . ($rowNumber - 1))->applyFromArray($dataStyle);

        // Auto-size columns
        foreach (range('A', 'E') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        // Nama file
        $filename = 'All_Candidates_' . date('Y-m-d_H-i-s') . '.xlsx';

        // Download file
        $writer = new Xlsx($spreadsheet);
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
        $candidates = $spreadsheet->getActiveSheet()->toArray();

        for ($i = 1; $i < count($candidates); $i++) {
            $row = $candidates[$i];

            if (empty(array_filter($row))) {
                continue;
            }

            $email = mt_rand(10000, 1000000) . '@gmail.com';

            // Get data from Excel
            $nis = trim($row[1] ?? ''); // nis/username
            $fullname = trim($row[2] ?? ''); // nama lengkap
            $gradeName = trim(strtolower($row[3] ?? '')); // kelas

            $firstName = ucfirst(strtolower(explode(' ', $fullname)[0]));
            $lastNis = substr($nis, -2);
            $password = $firstName . '@' . $lastNis;

            // username/ nis
            if (empty($nis)) {
                $this->db->transRollback();
                session()->setFlashdata('error', 'username tidak boleh kosong pada baris ' . ($i + 1));
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

            $this->userModel->withGroup('candidate')->save($userData);
            $userId = $this->userModel->getInsertID();

            $candidateData = [
                'user_id' => $userId,
                'fullname' => $fullname,
                'vision' => $row[4] ?? '', // f
                'mission' => $row[5] ?? '', // g
                'image' => 'default.png',
                'grade_id' => $gradeNameToId[$gradeName]
            ];
            // return dd([$candidateData, $userData]);

            $this->candidateModel->save($candidateData);
        }

        $this->db->transComplete();

        if ($this->db->transStatus() === false) {
            session()->setFlashdata('error', 'Gagal menyimpan data ke database');
            return redirect()->back()->withInput();
        }

        session()->setFlashdata('message', 'Data kandidat berhasil diimport');
        return redirect()->to('/candidate');
    }

    public function template()
    {
        // Load library PhpSpreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Header kolom
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Username');
        $sheet->setCellValue('C1', 'Nama Lengkap');
        $sheet->setCellValue('D1', 'Kelas');
        $sheet->setCellValue('E1', 'Visi');
        $sheet->setCellValue('F1', 'Misi');

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

        $sheet->getStyle('A1:F1')->applyFromArray($headerStyle);

        // Set predefined column widths
        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->getColumnDimension('B')->setWidth(25);
        $sheet->getColumnDimension('C')->setWidth(25);
        $sheet->getColumnDimension('D')->setWidth(15);
        $sheet->getColumnDimension('E')->setWidth(40);
        $sheet->getColumnDimension('F')->setWidth(40);

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
        $sheet->getStyle('A2:F23')->applyFromArray($dataStyle);

        // Nama file template
        $filename = 'Template_Candidates_' . date('Y-m-d_H-i-s') . '.xlsx';

        // Download file
        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    }
}
