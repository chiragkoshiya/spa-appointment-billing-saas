<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'phone', 'email', 'customer_type', 'created_by', 'updated_by'
    ];

    public function wallet()
    {
        return $this->hasOne(MemberWallet::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}
