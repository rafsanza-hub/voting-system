<?php

namespace App\Controllers;

use App\Models\CandidateModel;
use App\Models\GradeModel;
use App\Models\PeriodModel;
use App\Models\VoteModel;
use App\Models\VoterModel;

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
        $candidateModel = new CandidateModel();
        $voterModel = new VoterModel();
        $periodModel = new PeriodModel();
        $timeUntilStart = $periodModel->getTimeUntilStart();
        $timeUntilEnd = $periodModel->getTimeUntilEnd();

        $currentPeriod = $periodModel->getCurrentPeriod();
        $now = time();
        $isVotingStarted = ($currentPeriod && strtotime($currentPeriod['start_date']) <= $now);
        $data = [
            'timeUntilStart' => $timeUntilStart,
            'timeUntilEnd' => $timeUntilEnd,
            'isVotingStarted' => $isVotingStarted,
            "count_candidate" => $candidateModel->countAll(),
            "count_voter" => $voterModel->countAll(),
        ];
        return view('/home/index', $data);
    }

    public function result()
    {
        $voteModel = new VoteModel();

        $votingStatistics = $voteModel->getVotingStatistics();

        $candidates = $voteModel->getVoteCountByCandidate();

        $totalVotes = $votingStatistics['voted'];
        foreach ($candidates as &$candidate) {
            $candidate['vote_percentage'] = ($totalVotes > 0) ? ($candidate['vote_count'] / $totalVotes) * 100 : 0;
        }
        $candidateModel = new CandidateModel();
        $periodModel = new PeriodModel();
        $votingStatus = $periodModel->findColumn('status')[0] ?? 'pending';
        $data = [
            'title' => 'Result',
            'total_registered_voters' => $votingStatistics['total_users'],
            'total_votes' => $votingStatistics['voted'],
            'participation_percentage' => $votingStatistics['voted_percentage'],
            'candidates' => $candidates,
            'voting_status' => $votingStatus
        ];
        return view('home/result', $data);
    }
}
