<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyEvent extends Model
{
    use HasFactory;
    protected $table = 'company_events';
    protected $fillable = [
        'company_id',
        'event_id',
        'qr_code',
        'number_of_people',
        'check_in',
    ];
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
    public function event()
    {
        return $this->belongsTo(Event::class);
    }
    public function attendanceRecords()
    {
        return $this->hasMany(AttendanceRecord::class);
    }
}
