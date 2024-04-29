<?php
namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PaymentsFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function testCreatePayment()
    {
        $client = \App\Models\Clients\ClientModel::factory()->create();
        $user = \App\Models\Auth\UserModel::factory()->create();
        $paymentMethod = \App\Models\Payments\PaymentMethodModel::factory()->create();

        $payment = \App\Models\Payments\PaymentsModel::factory()->create([
            'client_id' => $client->id,
            'user_id' => $users->id,
            'payment_method_id' => $paymentMethod->id
        ]);

        $this->assertDatabaseHas('payments', [
            'id' => $payment->id
        ]);
    }
}