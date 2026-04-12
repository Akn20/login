<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;


class LeaveReportExport implements FromCollection
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return $this->data->map(function ($l) {

            return [
                'Employee ID' => $l->staff->employee_id ?? '',
                'Name' => $l->staff->name ?? '',
                'Department' => $l->staff->department->name ?? '',
                'Leave Type' => $l->leaveType->display_name ?? '',
                'From Date' => $l->from_date,
                'To Date' => $l->to_date,
                'Leave Days' => $l->leave_days,
                'Status' => $l->status,
                'Approved By' => optional($l->approvals->last())->approver->name ?? '',
                'Balance' => $l->remaining_balance ?? 0,
            ];
        });
    }
}