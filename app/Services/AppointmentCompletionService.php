<?php

namespace App\Services;

use App\Models\Appointment;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\AppointmentService as AppointmentServiceModel;
use App\Models\MemberWallet;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AppointmentCompletionService
{
    /**
     * Complete appointment: Set status to completed, payment_status to paid, and generate invoice
     * All in one transaction
     */
    public function completeAppointment(Appointment $appointment): array
    {
        return DB::transaction(function () use ($appointment) {
            // Update appointment status and payment status
            $appointment->update([
                'status' => 'completed',
                'payment_status' => 'paid',
                'updated_by' => Auth::id(),
            ]);

            // Generate invoice if it doesn't exist
            if (!$appointment->invoice) {
                $this->generateInvoice($appointment);
            }

            return [
                'success' => true,
                'message' => 'Appointment completed successfully. Invoice generated.',
            ];
        });
    }

    /**
     * Generate invoice for appointment
     * Shared method used by observer and service
     */
    public function generateInvoice(Appointment $appointment): Invoice
    {
        // Prevent duplicate invoice
        if ($appointment->invoice) {
            return $appointment->invoice;
        }

        // Reload appointment with relationships
        $appointment->load(['customer.wallet', 'service', 'services.service', 'offer']);

        $totalAmount = $appointment->amount;

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
            'payment_mode' => $appointment->payment_method ?? 'cash',
            'created_by' => Auth::id() ?? $appointment->created_by,
            'updated_by' => Auth::id() ?? $appointment->updated_by,
        ]);

        // Invoice items - use service from appointment
        $service = $appointment->service;
        if ($service) {
            $description = $service->name;

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
                'amount' => $totalAmount,
                'created_by' => Auth::id() ?? $appointment->created_by,
                'updated_by' => Auth::id() ?? $appointment->updated_by,
            ]);
        }

        return $invoice;
    }
}

