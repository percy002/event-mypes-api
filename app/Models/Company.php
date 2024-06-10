<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;
    protected $fillable = [
        'category',
        'business_name',
        'trade_name',
        'ruc',
        'address',
        'company_email',
        'legal_representative_first_name',
        'legal_representative_last_name',
    ];
    public function employees()
    {
        return $this->belongsToMany(Employee::class)->withPivot('position');
    }
}
