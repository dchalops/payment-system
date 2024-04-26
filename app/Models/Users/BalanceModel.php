<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BalanceModel extends Model
{
    use HasFactory;
    
    protected $fillable = ['user_id', 'amount', 'reason'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(UserModel::class);
    }
}
