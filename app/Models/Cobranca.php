<?php

namespace App\Models;

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
        'status'
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
}
