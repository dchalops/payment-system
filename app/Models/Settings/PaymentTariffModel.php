<?php

namespace App\Models\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentTariffModel extends Model
{
    use HasFactory;

    protected $table = 'payment_tariffs';
    protected $fillable = ['name_tariff', 'tariff'];

}
