<?php

namespace App\Models\Payments;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppliedTariffModel extends Model
{
    use HasFactory;

    protected $table = 'applied_tariffs';
    protected $fillable = ['payment_id', 'original_amount', 'tariff', 'final_amount'];

    public function payment(): BelongsTo
    {
        return $this->belongsTo(PaymentsModel::class, 'payment_id');
    }
}
