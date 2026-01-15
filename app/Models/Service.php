<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'price', 'duration_minutes', 'is_active', 'created_by', 'updated_by'];

    /**
     * Get all appointments for this service
     */
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}
