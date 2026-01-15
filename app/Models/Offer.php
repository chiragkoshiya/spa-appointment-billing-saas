<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Offer extends Model
{
    use SoftDeletes;
    protected $fillable = ['name','discount_type','discount_value','start_date','end_date','is_active','created_by','updated_by'];
}
