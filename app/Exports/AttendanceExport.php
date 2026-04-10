<?php

namespace App\Exports;

use App\Models\AttendanceRecord;
use Maatwebsite\Excel\Concerns\FromCollection;

class AttendanceExport implements FromCollection
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return $this->data->map(function ($a) {
            return [
                'Employee' => $a->staff->name ?? '',
                'Department' => $a->department->name ?? '',
                'Date' => $a->attendance_date,
                'Check In' => $a->check_in,
                'Check Out' => $a->check_out,
                'Status' => $a->status,
                'Late Minutes' => $a->late_minutes,
                'Overtime Minutes' => $a->overtime_minutes,
            ];
        });
    }
}