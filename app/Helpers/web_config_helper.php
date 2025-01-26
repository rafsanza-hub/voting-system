<?php

use App\Models\AdminModel;
use App\Models\CandidateModel;
use App\Models\ConfigurationModel;
use App\Models\VoterModel;

if (!function_exists('get_config')) {
    function get_config($key = null)
    {
        $configModel = new ConfigurationModel();

        $config = $configModel->first();

        if ($key === null) {
            return $config;
        }

        return isset($config[$key]) ? $config[$key] : null;
    }
}


if (!function_exists('get_image')) {
    function get_image()
    {
        if (in_groups('admin')) {
            $adminModel = new AdminModel();
            $admin = $adminModel->where('user_id', user_id())->first();
            return $admin['image'];
        }
        if (in_groups('voter')) {
            $voterModel = new VoterModel();
            $voter = $voterModel->where('user_id', user_id())->first();
            return $voter['image'];
        }
        if (in_groups('candidate')) {
            $candidateModel = new CandidateModel();
            $candidate = $candidateModel->where('user_id', user_id())->first();
            return $candidate['image'];
        }
        return null;
    }
}

function get_role()
{
    if (in_groups('admin')) {
        return "Admin";
    } elseif (in_groups('candidate')) {
        return 'Kandidat';
    } elseif (in_groups('voter')) {
        return 'Pemilih';
    } else {
        return 'User';
    }
}
