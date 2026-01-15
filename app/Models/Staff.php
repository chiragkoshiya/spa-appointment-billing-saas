<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Staff extends Model
{
     use SoftDeletes;

    protected $fillable = ['name','is_active','email','phone','address','created_by','updated_by'];

    public function documents()
    {
        return $this->hasMany(StaffDocument::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}
