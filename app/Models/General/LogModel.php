<?php

namespace App\Models\General;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LogModel extends Model
{
    protected $table = 'logs';

    protected $fillable = ['action', 'description', 'created_at'];
    
}