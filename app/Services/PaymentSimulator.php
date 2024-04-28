<?php

namespace App\Services;

use App\Models\Payments\PaymentsModel;
use App\Models\Balance\BalanceModel;
use App\Models\Payments\AppliedTariffModel;
use App\Models\Settings\PaymentTariffModel;
use App\Services\SystemMonitor;

class PaymentSimulator
{
    protected $systemMonitor;

    public function __construct(SystemMonitor $systemMonitor)
    {
        $this->systemMonitor = $systemMonitor;
    }

    public function process(PaymentsModel $payment): array
    {
        if ($payment->status === 'paid') {
            $this->systemMonitor->logEvent(
                'Payment Process Attempt',
                'Attempted to process an already paid payment. Payment ID: ' . $payment->id
            );

            return [
                'success' => false,
                'message' => 'The payment has already been processed.',
            ];
        }

        $paymentMethod = $payment->paymentMethod->name;
        $tariffRecord = PaymentTariffModel::where('payment_method', $paymentMethod)->first();
        $tariff = $tariffRecord ? $tariffRecord->tariff : 0;

        $tariffAmount = $payment->amount * $tariff;
        $finalAmount = $payment->amount - $tariffAmount;

        if (rand(1, 10) <= 7) {
            $payment->status = 'paid';
            $payment->save();

            BalanceModel::create([
                'client_id' => $payment->client_id,
                'amount' => $finalAmount,
                'reason' => 'Payment processed successfully.',
            ]);

            AppliedTariffModel::create([
                'payment_id' => $payment->id,
                'original_amount' => $payment->amount,
                'tariff' => $tariffAmount,
                'final_amount' => $finalAmount,
            ]);

            $this->systemMonitor->logEvent(
                'Payment Processed',
                'Payment ID: ' . $payment->id . ' processed successfully. Tariff applied: ' . $tariffAmount
            );

            return [
                'success' => true,
                'message' => 'Payment processed successfully.',
            ];
        } else {
            $payment->status = 'failed';
            $payment->save();

            $this->systemMonitor->logEvent(
                'Payment Processing Failed',
                'Payment processing failed. Payment ID: ' . $payment->id
            );

            return [
                'success' => false,
                'message' => 'Payment processing failed.',
            ];
        }
    }
}
