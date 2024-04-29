<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Insert users
        DB::table('users')->insert([
            [
                'name' => 'Banco Solidario',
                'email' => 'solidario@solidario.com',
                'email_verified_at' => now(),
                'username' => hash('sha256', 'usuarioSolidario'),
                'password' => Hash::make('usuario'), // Replace 'password' with the actual password you want to use
                'created_at' => '2024-04-28 2:20:04', // Replace with actual creation date or use now() for the current timestamp
                'updated_at' => '2024-04-28 2:20:04', // Replace with actual update date or use now() for the current timestamp
            ],
            [
                'name' => 'Banco Pichincha',
                'email' => 'pichincha@pichincha.com',
                'email_verified_at' => now(),
                'username' => hash('sha256', 'usuarioPichincha'),
                'password' => Hash::make('usuario'), // Replace 'password' with the actual password you want to use
                'created_at' => '2024-04-28 2:20:04', // Replace with actual creation date or use now() for the current timestamp
                'updated_at' => '2024-04-28 2:20:04', // Replace with actual update date or use now() for the current timestamp
            ],
            
        ]);
        // Insert clients
        DB::table('clients')->insert([
            ['name' => 'John Doe', 'cpf' => '12345678901', 'email' => 'john@example.com', 'phone' => '555-1234', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Jane Smith', 'cpf' => '10987654321', 'email' => 'jane@example.com', 'phone' => '555-5678', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Insert payments
        DB::table('payments')->insert([
            ['client_id' => 1, 'description' => 'Service Payment for January', 'amount' => 200.50, 'status' => 'paid', 'user_id' => 1, 'payment_method_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['client_id' => 2, 'description' => 'Service Payment for February', 'amount' => 180.75, 'status' => 'pending', 'user_id' => 1, 'payment_method_id' => 2, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Insert payment methods
        DB::table('payment_methods')->insert([
            ['name' => 'Credit Card', 'slug' => 'credit-card', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'PayPal', 'slug' => 'paypal', 'created_at' => now(), 'updated_at' => now()],
            // ... other payment methods
        ]);

        // Insert payment tariffs
        DB::table('payment_tariffs')->insert([
            ['payment_method_id' => 5, 'tariff' => 0.015],
            ['payment_method_id' => 6, 'tariff' => 0.02],
            // ... other tariffs
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('users')->whereIn('email', ['solidario@solidario.com', 'pichincha@pichincha.com'])->delete();
        // Delete clients
        DB::table('clients')->whereIn('email', ['john@example.com', 'jane@example.com'])->delete();

        // Delete payments
        DB::table('payments')->where('client_id', 1)->orWhere('client_id', 2)->delete();

        // Delete payment methods
        DB::table('payment_methods')->whereIn('slug', ['credit-card', 'paypal'])->delete();

        // Delete payment tariffs
        DB::table('payment_tariffs')->whereIn('payment_method_id', [5, 6])->delete();
    }
};
