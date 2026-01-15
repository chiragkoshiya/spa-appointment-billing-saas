<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    Use SoftDeletes;

    protected $fillable = ['appointment_id','customer_id','total_amount','wallet_deduction','payable_amount','payment_mode','created_by','updated_by'];

    public function appointment()
    {
        return $this->belongsTo(Appointment::class,'appointment_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class,'customer_id');
    }
}
