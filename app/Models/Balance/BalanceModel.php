<?php

namespace App\Models\Balance;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BalanceModel extends Model
{
    use HasFactory;

    protected $table = 'balances';
    protected $fillable = ['client_id', 'amount', 'reason'];

    public function client(): BelongsTo
    {
        return $this->belongsTo(ClientModel::class);
    }
}
