<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Staff extends Model
{
     use SoftDeletes;

    protected $fillable = [
        'name',
        'photo',
        'is_active',
        'email',
        'phone',
        'dob',
        'pan_photo',
        'aadhaar_photo',
        'address',
        'city',
        'work_last_place',
        'joining_date',
        'leaving_date',
        'salary',
        'has_terms_conditions',
        'terms_conditions_details',
        'created_by',
        'updated_by'
    ];

    public function documents()
    {
        return $this->hasMany(StaffDocument::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}
