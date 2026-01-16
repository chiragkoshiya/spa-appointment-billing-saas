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
        // Generate invoice ONLY when payment_status changes to paid
        if ($appointment->isDirty('payment_status') && $appointment->payment_status === 'paid') {
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

            // Calculate offer discount
            $offerDiscount = 0;
            if ($appointment->offer_id && $appointment->offer) {
                $offer = $appointment->offer;

                if ($offer->discount_type === 'percentage') {
                    $offerDiscount = ($totalAmount * $offer->discount_value) / 100;
                } else {
                    $offerDiscount = $offer->discount_value;
                }
            }

            // Amount after offer discount
            $amountAfterOffer = $totalAmount - $offerDiscount;
            if ($amountAfterOffer < 0) {
                $amountAfterOffer = 0;
            }

            $walletDeduction = 0;
            $payableAmount = $amountAfterOffer;

            // Member wallet logic (apply after offer discount)
            if (
                $appointment->customer &&
                $appointment->customer->customer_type === 'member' &&
                $appointment->customer->wallet
            ) {
                $wallet = $appointment->customer->wallet;

                $walletDeduction = min($wallet->balance, $amountAfterOffer);
                $payableAmount = $amountAfterOffer - $walletDeduction;

                // Update wallet balance
                $wallet->decrement('balance', $walletDeduction);
            }

            // Create invoice
            $invoice = Invoice::create([
                'appointment_id' => $appointment->id,
                'customer_id' => $appointment->customer_id,
                'total_amount' => $totalAmount,
                'wallet_deduction' => $walletDeduction,
                'payable_amount' => $payableAmount,
                'payment_mode' => 'cash',
                'created_by' => Auth::id() ?? $appointment->created_by,
                'updated_by' => Auth::id() ?? $appointment->updated_by,
            ]);

            // Invoice items
            foreach ($appointment->services as $service) {
                $description = $service->service->name;

                // Add offer info to description if applicable
                if ($appointment->offer_id && $appointment->offer) {
                    $discountText = $appointment->offer->discount_type === 'percentage'
                        ? $appointment->offer->discount_value . '%'
                        : '₹' . number_format($appointment->offer->discount_value, 2);
                    $description .= ' (Offer: ' . $appointment->offer->name . ' - ' . $discountText . ' off)';
                }

                InvoiceItem::create([
                    'invoice_id' => $invoice->id,
                    'description' => $description,
                    'amount' => $service->price,
                    'created_by' => Auth::id() ?? $appointment->created_by,
                    'updated_by' => Auth::id() ?? $appointment->updated_by,
                ]);
            }
        });
    }
}
