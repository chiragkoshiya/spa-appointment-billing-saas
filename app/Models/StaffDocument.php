<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StaffDocument extends Model
{
    use SoftDeletes;

    protected $fillable = ['staff_id','document_type','file_path','created_by','updated_by'];

    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }
}
