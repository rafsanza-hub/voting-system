<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use App\Models\CandidateModel;
use App\Models\UserModel;
use CodeIgniter\API\ResponseTrait;
use Exception;

class CandidateApi extends ResourceController
{
    use ResponseTrait;

    protected $candidateModel;
    protected $userModel;
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->candidateModel = new CandidateModel();
        $this->userModel = new UserModel();
    }

    /**
     * Get all candidates
     * 
     * @return \CodeIgniter\HTTP\Response
     */
    public function index()
    {
        try {
            $candidates = $this->candidateModel->getCandidate();
            
            if (!$candidates) {
                return $this->respond([
                    'status' => false,
                    'message' => 'No candidates found',
                    'data' => []
                ], 404);
            }

            return $this->respond([
                'status' => true,
                'message' => 'Candidates retrieved successfully',
                'data' => $candidates
            ], 200);
        } catch (Exception $e) {
            return $this->respond([
                'status' => false,
                'message' => 'Failed to retrieve candidates: ' . $e->getMessage(),
                'data' => []
            ], 500);
        }
    }

    /**
     * Get single candidate by ID
     * 
     * @param int $id
     * @return \CodeIgniter\HTTP\Response
     */
    public function show($id = null)
    {
        try {
            $candidate = $this->candidateModel->getCandidate($id);

            if (!$candidate) {
                return $this->respond([
                    'status' => false,
                    'message' => 'Candidate not found',
                    'data' => null
                ], 404);
            }

            return $this->respond([
                'status' => true,
                'message' => 'Candidate retrieved successfully',
                'data' => $candidate
            ], 200);
        } catch (Exception $e) {
            return $this->respond([
                'status' => false,
                'message' => 'Failed to retrieve candidate: ' . $e->getMessage(),
                'data' => null
            ], 500);
        }
    }

    /**
     * Create new candidate
     * 
     * @return \CodeIgniter\HTTP\Response
     */
    public function create()
    {
        try {
            $rules = [
                'fullname' => 'required',
                'username' => 'required|is_unique[users.username]',
                'password' => 'required',
                'grade_id' => 'required|numeric',
                'vision' => 'required',
                'mission' => 'required'
            ];

            if (!$this->validate($rules)) {
                return $this->respond([
                    'status' => false,
                    'message' => 'Validation failed',
                    'errors' => $this->validator->getErrors()
                ], 400);
            }

            $this->db->transStart();

            // Create user account
            $email = mt_rand(10000, 1000000) . '@gmail.com';
            $userData = [
                'username' => $this->request->getPost('username'),
                'password_hash' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
                'email' => $email,
                'active' => 1
            ];
            
            $this->userModel->withGroup('candidate')->save($userData);
            $userId = $this->userModel->getInsertID();

            // Create candidate profile
            $candidateData = [
                'user_id' => $userId,
                'grade_id' => $this->request->getPost('grade_id'),
                'fullname' => $this->request->getPost('fullname'),
                'vision' => $this->request->getPost('vision'),
                'mission' => $this->request->getPost('mission'),
                'image' => 'default.png'
            ];

            $this->candidateModel->save($candidateData);
            
            $this->db->transComplete();

            if ($this->db->transStatus() === false) {
                return $this->respond([
                    'status' => false,
                    'message' => 'Failed to create candidate',
                    'data' => null
                ], 500);
            }

            return $this->respond([
                'status' => true,
                'message' => 'Candidate created successfully',
                'data' => array_merge($userData, $candidateData)
            ], 201);

        } catch (Exception $e) {
            return $this->respond([
                'status' => false,
                'message' => 'Failed to create candidate: ' . $e->getMessage(),
                'data' => null
            ], 500);
        }
    }

    /**
     * Update candidate
     * 
     * @param int $id
     * @return \CodeIgniter\HTTP\Response
     */
    public function update($id = null)
    {
        try {
            $candidate = $this->candidateModel->find($id);
            
            if (!$candidate) {
                return $this->respond([
                    'status' => false,
                    'message' => 'Candidate not found',
                    'data' => null
                ], 404);
            }

            $rules = [
                'fullname' => 'required',
                'grade_id' => 'required|numeric',
                'vision' => 'required',
                'mission' => 'required'
            ];

            if (!$this->validate($rules)) {
                return $this->respond([
                    'status' => false,
                    'message' => 'Validation failed',
                    'errors' => $this->validator->getErrors()
                ], 400);
            }

            $this->db->transStart();

            $updateData = [
                'id' => $id,
                'grade_id' => $this->request->getPost('grade_id'),
                'fullname' => $this->request->getPost('fullname'),
                'vision' => $this->request->getPost('vision'),
                'mission' => $this->request->getPost('mission')
            ];

            $this->candidateModel->save($updateData);
            
            $this->db->transComplete();

            if ($this->db->transStatus() === false) {
                return $this->respond([
                    'status' => false,
                    'message' => 'Failed to update candidate',
                    'data' => null
                ], 500);
            }

            return $this->respond([
                'status' => true,
                'message' => 'Candidate updated successfully',
                'data' => $updateData
            ], 200);

        } catch (Exception $e) {
            return $this->respond([
                'status' => false,
                'message' => 'Failed to update candidate: ' . $e->getMessage(),
                'data' => null
            ], 500);
        }
    }

    /**
     * Delete candidate
     * 
     * @param int $id
     * @return \CodeIgniter\HTTP\Response
     */
    public function delete($id = null)
    {
        try {
            $candidate = $this->candidateModel->find($id);
            
            if (!$candidate) {
                return $this->respond([
                    'status' => false,
                    'message' => 'Candidate not found',
                    'data' => null
                ], 404);
            }

            // Delete image if not default
            if ($candidate['image'] != 'default.png' && file_exists('img/' . $candidate['image'])) {
                unlink('img/' . $candidate['image']);
            }

            $this->candidateModel->delete($id);

            return $this->respond([
                'status' => true,
                'message' => 'Candidate deleted successfully',
                'data' => null
            ], 200);

        } catch (Exception $e) {
            return $this->respond([
                'status' => false,
                'message' => 'Failed to delete candidate: ' . $e->getMessage(),
                'data' => null
            ], 500);
        }
    }
}