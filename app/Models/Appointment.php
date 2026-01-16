<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Appointment extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'customer_id',
        'phone',
        'staff_id',
        'room_id',
        'service_id',
        'appointment_date',
        'start_time',
        'end_time',
        'duration',
        'is_member',
        'payment_method',
        'amount',
        'offer_id',
        'payment_status',
        'sleep',
        'status',
        'created_by',
        'updated_by'
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'appointment_date' => 'date',
        ];
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function services()
    {
        return $this->hasMany(AppointmentService::class);
    }

    public function invoice()
    {
        return $this->hasOne(Invoice::class);
    }

    public function offer()
    {
        return $this->belongsTo(Offer::class);
    }
}
