<?php

namespace App\Models\Financeiro;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormasPagamento extends Model
{
    use HasFactory;

    protected $fillable = ['forma','id'];
    protected $table = 'formas_pagamento';
    public function setFormaAttribute($value)
    {
        $this->attributes['forma'] = strtoupper($value);
    }
}
