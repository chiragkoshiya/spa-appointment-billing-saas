<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InventoryItem extends Model
{
    Use SoftDeletes;

    protected $fillable = ['name','quantity','created_by','updated_by'];

    public function user()
    {
        return $this->belongsTo(User::class,'created_by');
    }
}
