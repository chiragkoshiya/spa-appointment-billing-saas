<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InventoryMovement extends Model
{
    Use SoftDeletes;

    protected $fillable = ['inventory_item_id','user_id','change_qty','reason','created_by','updated_by'];

    /**
     * Get the inventory item for this movement
     */
    public function inventoryItem()
    {
        return $this->belongsTo(InventoryItem::class,'inventory_item_id');
    }

    /**
     * Get the user who made this movement
     */
    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    /**
     * Get the user who created this record
     */
    public function creator()
    {
        return $this->belongsTo(User::class,'created_by');
    }

    /**
     * Check if movement is an addition (positive quantity)
     */
    public function isAddition()
    {
        return $this->change_qty > 0;
    }

    /**
     * Check if movement is a deduction (negative quantity)
     */
    public function isDeduction()
    {
        return $this->change_qty < 0;
    }
}
