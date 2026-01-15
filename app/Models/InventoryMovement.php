<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InventoryMovement extends Model
{
    Use SoftDeletes;

    protected $fillable = ['inventory_item_id','user_id','change_qty','reason','created_by','updated_by'];

    public function inventoryItem()
    {
        return $this->belongsTo(InventoryItem::class,'inventory_item_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
