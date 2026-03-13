<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AttendanceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [

            'id' => $this->id,

            'employee_name' => $this->staff->name ?? null,

            'department' => $this->staff->department->department_name ?? null,

            'designation' => $this->staff->designation->designation_name ?? null,

            'shift' => $this->shift->shift_name ?? null,

            'shift_start' => $this->shift->start_time ?? null,

            'shift_end' => $this->shift->end_time ?? null,

            'attendance_date' => $this->attendance_date,

            'check_in' => $this->check_in,

            'check_out' => $this->check_out,

            'status' => $this->status,

            'late_minutes' => $this->late_minutes,

            'overtime_minutes' => $this->overtime_minutes,

            'created_at' => $this->created_at

        ];
    }
}