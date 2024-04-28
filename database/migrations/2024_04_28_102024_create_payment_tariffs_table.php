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
        Schema::create('payment_tariffs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('payment_method_id')
                ->constrained('payment_methods')
                ->onDelete('cascade');
            $table->decimal('tariff', 5, 4);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_tariffs'); // Elimina la tabla payment_tariffs
    }
};

