<?php

namespace App\Observers;

use App\Models\Appointment;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AppointmentObserver
{
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
        // Only trigger when status changes to completed
        if (
            $appointment->isDirty('status') &&
            $appointment->status === 'completed'
        ) {
            $this->generateInvoice($appointment);
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

     protected function generateInvoice(Appointment $appointment)
    {
        // Prevent duplicate invoice
        if ($appointment->invoice) {
            return;
        }

        DB::transaction(function () use ($appointment) {

            $totalAmount = 0;

            foreach ($appointment->services as $service) {
                $totalAmount += $service->price;
            }

            $walletDeduction = 0;
            $payableAmount   = $totalAmount;

            // Member wallet logic
            if (
                $appointment->customer->customer_type === 'member' &&
                $appointment->customer->wallet
            ) {
                $wallet = $appointment->customer->wallet;

                $walletDeduction = min($wallet->balance, $totalAmount);
                $payableAmount   = $totalAmount - $walletDeduction;

                // Update wallet balance
                $wallet->decrement('balance', $walletDeduction);
            }

            // Create invoice
            $invoice = Invoice::create([
                'appointment_id'   => $appointment->id,
                'customer_id'      => $appointment->customer_id,
                'total_amount'     => $totalAmount,
                'wallet_deduction' => $walletDeduction,
                'payable_amount'   => $payableAmount,
                'payment_mode'     => 'cash',
                'created_by'       => Auth::id() ?? $appointment->created_by,
                'updated_by'       => Auth::id() ?? $appointment->updated_by,
            ]);

            // Invoice items
            foreach ($appointment->services as $service) {
                InvoiceItem::create([
                    'invoice_id'  => $invoice->id,
                    'description' => $service->service->name,
                    'amount'      => $service->price,
                    'created_by' => Auth::id() ?? $appointment->created_by,
                    'updated_by' => Auth::id() ?? $appointment->updated_by,
                ]);
            }
        });
    }
}
