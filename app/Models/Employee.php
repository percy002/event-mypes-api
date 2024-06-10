<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    protected $fillable = [
        'first_name',
        'last_name',
        'dni',
        'position',
        'email',
        'cell_phone',
        'company_id',
    ];
    public function company()
    {
        return $this->belongsToMany(Company::class)->withPivot('position');
    }
}
