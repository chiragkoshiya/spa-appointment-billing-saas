<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InventoryItem extends Model
{
    Use SoftDeletes;

    protected $fillable = ['name','quantity','amount','created_by','updated_by'];

    /**
     * Get the user who created this item
     */
    public function creator()
    {
        return $this->belongsTo(User::class,'created_by');
    }

    /**
     * Get the user who last updated this item
     */
    public function updater()
    {
        return $this->belongsTo(User::class,'updated_by');
    }

    /**
     * Get all inventory movements for this item
     */
    public function movements()
    {
        return $this->hasMany(InventoryMovement::class);
    }

    /**
     * Check if item is low in stock (less than 10)
     */
    public function isLowStock()
    {
        return $this->quantity < 10;
    }

    /**
     * Check if item is out of stock
     */
    public function isOutOfStock()
    {
        return $this->quantity <= 0;
    }
}
