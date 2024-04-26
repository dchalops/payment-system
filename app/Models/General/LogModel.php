<?php

namespace App\Models\General;

class Log extends Model
{
    protected $table = 'logs';

    protected $fillable = ['user_id', 'action', 'description', 'created_at'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}