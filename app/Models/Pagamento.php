<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pagamento extends Model
{
    protected $fillable = [
        'cobranca_id',
        'valor',
        'data_vencimento',
        'data_pagamento',
        'status'
    ];

    // Relacionamento com a cobrança
    public function cobranca()
    {
        return $this->belongsTo(Cobranca::class);
    }
}
