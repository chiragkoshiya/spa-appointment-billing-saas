<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AppointmentService extends Model
{
    Use SoftDeletes;

    protected $fillable = ['appointment_id','service_id','price','created_by','updated_by'];

    public function appointment()
    {
        return $this->belongsTo(Appointment::class,'appointment_id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class,'service_id');
    }
}
