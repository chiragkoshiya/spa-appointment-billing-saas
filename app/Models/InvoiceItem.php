<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InvoiceItem extends Model
{
    Use SoftDeletes;

    protected $fillable = ['invoice_id','description','amount','created_by','updated_by'];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class,'invoice_id');
    }
}
