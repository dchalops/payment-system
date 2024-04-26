<?php

namespace App\Services;

use App\Models\Payment;
use App\Models\Balance;
use App\Services\SystemMonitor;

class PaymentSimulator
{
    protected $systemMonitor;

    public function __construct(SystemMonitor $systemMonitor)
    {
        $this->systemMonitor = $systemMonitor;
    }

    public function process(Payment $payment): array
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

        if (rand(1, 10) <= 7) {
            $payment->status = 'paid';
            $payment->save();

            Balance::create([
                'user_id' => $payment->user_id,
                'amount' => $payment->value,
                'reason' => 'Payment processed successfully.',
            ]);

            $this->systemMonitor->logEvent(
                'Payment Processed',
                'Payment ID: ' . $payment->id . ' processed successfully.'
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
