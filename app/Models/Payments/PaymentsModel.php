<?php

namespace App\Models\Payments;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PaymentsModel extends Model
{
    use HasFactory;
    protected $table = 'payments';

    protected $fillable = ['client_name', 'client_cpf', 'description', 'amount', 'state', 'user_id', 'payment_method_id'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(UserModel::class);
    }

    public function paymentMethod(): BelongsTo
    {
        return $this->belongsTo(PaymentMethodModel::class);
    }
}
