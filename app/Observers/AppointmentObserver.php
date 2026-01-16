<?php

namespace App\Observers;

use App\Models\Appointment;
use App\Services\AppointmentCompletionService;

class AppointmentObserver
{
    protected $appointmentService;

    public function __construct(AppointmentCompletionService $appointmentService)
    {
        $this->appointmentService = $appointmentService;
    }

    /**
     * Handle the Appointment "created" event.
     */
    public function created(Appointment $appointment): void
    {
        //
    }

    /**
     * Handle the Appointment "updated" event.
     */
    public function updated(Appointment $appointment): void
    {
        // Generate invoice ONLY when payment_status changes to paid
        if ($appointment->isDirty('payment_status') && $appointment->payment_status === 'paid') {
            $this->appointmentService->generateInvoice($appointment);
        }

        // If status changed to completed, complete the appointment (status + payment + invoice)
        if ($appointment->isDirty('status') && $appointment->status === 'completed') {
            $this->appointmentService->completeAppointment($appointment);
        }
    }

    /**
     * Handle the Appointment "deleted" event.
     */
    public function deleted(Appointment $appointment): void
    {
        //
    }

    /**
     * Handle the Appointment "restored" event.
     */
    public function restored(Appointment $appointment): void
    {
        //
    }

    /**
     * Handle the Appointment "force deleted" event.
     */
    public function forceDeleted(Appointment $appointment): void
    {
        //
    }
}
