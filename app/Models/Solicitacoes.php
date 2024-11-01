<?php

namespace App\Models;

use App\Models\Financeiro\FormasPagamento;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Solicitacoes extends Model
{
    use HasFactory;
    protected $fillable = ['id', 'data_solicitacao','cliente_id','status','valor','data_final','entrada','desconto'];
    protected $table = 'solicitacoes';

    public function cliente()
    {
        return $this->belongsTo(Clientes::class, 'cliente_id', 'id');
    }

    
}
