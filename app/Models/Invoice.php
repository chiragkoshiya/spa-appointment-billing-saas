<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    Use SoftDeletes;

    protected $fillable = ['appointment_id','customer_id','total_amount','wallet_deduction','payable_amount','payment_mode','created_by','updated_by'];

    /**
     * Get the appointment for this invoice
     */
    public function appointment()
    {
        return $this->belongsTo(Appointment::class,'appointment_id');
    }

    /**
     * Get the customer for this invoice
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class,'customer_id');
    }

    /**
     * Get all invoice items
     */
    public function items()
    {
        return $this->hasMany(InvoiceItem::class);
    }

    /**
     * Get the user who created this invoice
     */
    public function creator()
    {
        return $this->belongsTo(User::class,'created_by');
    }

    /**
     * Get the user who last updated this invoice
     */
    public function updater()
    {
        return $this->belongsTo(User::class,'updated_by');
    }

    /**
     * Generate invoice number
     */
    public function getInvoiceNumberAttribute()
    {
        return 'INV-' . str_pad($this->id, 6, '0', STR_PAD_LEFT);
    }

    /**
     * Check if invoice is paid
     */
    public function isPaid()
    {
        return $this->payable_amount <= 0;
    }
}
