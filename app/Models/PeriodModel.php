<?php

namespace App\Models;

use CodeIgniter\Model;

class PeriodModel extends Model
{
    protected $table = 'periods';
    protected $allowedFields = ['name', 'start_date', 'end_date', 'status'];

    public function getTimeUntilStart()
    {
        $period = $this->getCurrentPeriod();
        if (!$period) return null;

        $now = time();
        $startDate = strtotime($period['start_date']);

        return max(0, $startDate - $now);
    }

    /**
     * Menghitung sisa waktu sebelum voting berakhir.
     */
    public function getTimeUntilEnd()
    {
        $period = $this->getCurrentPeriod();
        if (!$period) return null;

        $now = time();
        $endDate = strtotime($period['end_date']);

        return max(0, $endDate - $now);
    }
    
        public function getCurrentPeriod()
    {
        $period = $this->where('status', 'active')->orderBy('start_date', 'DESC')->first();
        if (!$period) {
            $period = $this->orderBy('start_date', 'DESC')->first();
        }
        return $period;
    }
}