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
        // Note: We don't handle status changes here to avoid infinite loops with completeAppointment()
        // The completeAppointment() service method should be called directly from controllers
        if ($appointment->isDirty('payment_status') && $appointment->payment_status === 'paid') {
            // Only generate invoice if status is already completed or if we're just marking as paid
            // Avoid calling completeAppointment here as it causes infinite loops
            if ($appointment->status === 'completed') {
                $this->appointmentService->generateInvoice($appointment);
            }
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
