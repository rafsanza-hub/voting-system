<?php

namespace App\Controllers;

use App\Models\CandidateModel;
use App\Models\VoterModel;

class Vote extends BaseController
{
    protected $candidateModel;
    protected $voterModel;
    protected $voteModel;
    protected $db;
    
    public function __construct()
    {
        $this->candidateModel = new CandidateModel();
        $this->voterModel = new VoterModel();
        $this->voteModel = new \App\Models\VoteModel();
        $this->db = \Config\Database::connect();
    }

    public function index(){
        $data = [
            'candidates' => $this->candidateModel->findAll()
        ];
        return view('votes/index', $data);
    }

    public function voting(){

        $periodModel = new \App\Models\PeriodModel();
        $votingStatus = $periodModel->findColumn('status')[0];
        $data = [
            'candidates' => $this->candidateModel->findAll(),
            'voting_status' => $votingStatus
        ];
        return view('votes/voting', $data);
    }

    public function saveVote()
    {
        $authorize = $auth = service('authorization');
        try {
            $group = $authorize->inGroup('voter', user_id());
            if ($group == false) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Anda tidak memiliki hak memilih'
                ]);
            }

            // cek jika user sudah vote
            $voter = $this->voterModel->where('user_id', user_id())->first();

            $existingVote = $this->voteModel->where('voter_id', $voter["id"])->first();
            if ($existingVote) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Anda sudah melakukan vote'
                ]);
            }
      
            // Save vote
            $this->voteModel->save([
                'candidate_id' => $this->request->getPost('candidate_id'),
                'voter_id' => $voter["id"],
            ]);


            return $this->response->setJSON([
                'success' => true,
                'message' => 'Vote berhasil disimpan'
            ]);

        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Terjadi kesalahan '.user_id()
            ]);
        }
    }
}