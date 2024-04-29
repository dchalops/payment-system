<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Payments\PaymentsModel;
use App\Models\Clients\ClientModel;
use App\Models\Auth\UserModel;
use App\Models\Payments\PaymentMethodModel;

class PaymentsUnitTest extends TestCase
{
    public function testCreatePayment(): void
    {
        $client = ClientModel::factory()->create();
        $user = UserModel::factory()->create();
        $paymentMethod = PaymentMethodModel::factory()->create();

        $data = [
            'client_id' => $client->id,
            'description' => 'Payment for services',
            'amount' => 100.00,
            'user_id' => $user->id,
            'payment_method_id' => $paymentMethod->id,
        ];

        $payment = PaymentsModel::create($data);

        $this->assertNotNull($payment);
        $this->assertEquals($data['client_id'], $payment->client_id);
        $this->assertEquals($data['description'], $payment->description);
        $this->assertEquals($data['amount'], $payment->amount);
        $this->assertEquals($data['user_id'], $payment->user_id);
        $this->assertEquals($data['payment_method_id'], $payment->payment_method_id);
    }
}
