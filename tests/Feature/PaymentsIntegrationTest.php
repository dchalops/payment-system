<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Payments\PaymentsModel;
use App\Models\Clients\ClientModel;
use App\Models\Auth\UserModel;
use App\Models\Payments\PaymentMethodModel;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class PaymentsIntegrationTest extends TestCase
{
    use DatabaseMigrations, WithFaker;

    public function testListPayments(): void
    {
        PaymentsModel::factory()->count(3)->create();

        $response = $this->get('/payments');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'message',
            'data' => [
                '*' => [
                    'id',
                    'description',
                    'amount',
                    'status',
                    'created_at',
                    'client' => [
                        'id',
                        'name',
                    ],
                ],
            ],
        ]);
    }

    public function testGetPaymentDetails(): void
    {
        $payment = PaymentsModel::factory()->create();

        $response = $this->get("/payments/{$payment->id}");

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'message',
            'data' => [
                'id',
                'description',
                'amount',
                'status',
                'created_at',
                'client' => [
                    'id',
                    'name',
                ],
            ],
        ]);
    }
}
