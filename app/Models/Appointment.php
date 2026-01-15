<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Appointment extends Model
{
    Use SoftDeletes;

    protected $fillable = ['customer_id','staff_id','room_id','appointment_date','start_time','end_time','status','created_by','updated_by'];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function services()
    {
        return $this->hasMany(AppointmentService::class);
    }

    public function invoice()
    {
        return $this->hasOne(Invoice::class);
    }
}
