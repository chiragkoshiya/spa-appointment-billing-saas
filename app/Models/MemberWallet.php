<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MemberWallet extends Model
{
    use SoftDeletes;

    protected $fillable = ['customer_id', 'balance', 'created_by', 'updated_by'];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
