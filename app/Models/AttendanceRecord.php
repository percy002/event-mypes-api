<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendanceRecord extends Model
{
    use HasFactory;
    protected $table = 'attendance_records';
    protected $fillable = [
        'company_event_id',
        'employee_id',
        'check_in',
        'check_out',
    ];
    public function companyEvent()
    {
        return $this->belongsTo(CompanyEvent::class);
    }
}
