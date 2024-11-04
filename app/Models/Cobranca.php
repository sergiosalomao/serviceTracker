<?php

namespace App\Models;

use App\Models\Financeiro\FormasPagamento;
use Illuminate\Database\Eloquent\Model;

class Cobranca extends Model
{
    protected $fillable = [
        'solicitacao_id',
        'valor_total',
        'data_vencimento',
        'parcelas',
        'entrada',
        'desconto',
        'status','forma_pagamento'
    ];

    // Relacionamento com os pagamentos
    public function pagamentos()
    {
        return $this->hasMany(Pagamento::class);
    }
    

    public function solicitacao()
    {
        return $this->belongsTo(Solicitacoes::class);
    }
    public function formapagamento()
    {
        return $this->belongsTo(FormasPagamento::class, 'forma_pagamento', 'id');
    }
}
