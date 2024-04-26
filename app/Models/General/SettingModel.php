<?php

namespace App\Models\General;

class SettingModel extends Model
{
    protected $table = 'settings';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'key',
        'value',
    ];

    
}