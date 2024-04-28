<?php

namespace App\Models\Clients;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientModel extends Model
{
    use HasFactory;

    protected $table = 'clients';
    protected $fillable = ['name', 'cpf', 'email', 'phone'];

    public function payments(): HasMany
    {
        return $this->hasMany(PaymentsModel::class);
    }
}
