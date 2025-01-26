<?php

namespace App\Controllers;

use App\Models\CandidateModel;
use App\Models\GradeModel;
use App\Models\PeriodModel;
use App\Models\VoteModel;

class Home extends BaseController
{

    protected $db;
    protected $voteModel;

    public function __construct()
    {
        $this->voteModel = new VoteModel();
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        $data = [
            'title' => 'Home',
        ];
        return view('home/index', $data);
    }
    public function result()
    {
        $candidateModel = new CandidateModel();
        $periodModel = new PeriodModel();
        $votingStatus = $periodModel->findColumn('status')[0];
        $data = [
            'title' => 'Home',
            'candidates' => $candidateModel->getCandidate(),
            'voting_status' => $votingStatus
        ];
        return view('home/result', $data);
    }
}
