<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItensSolicitacoes extends Model
{
    use HasFactory;
    protected $fillable = ['servico_id', 'qtd', 'solicitacao_id'];
    protected $table = 'itenssolicitacoes';


    public function solicitacao()
    {
      return $this->hasMany(Solicitacoes::class, 'id','solicitacao_id');
    }

    public function servico()
    {
        return $this->belongsTo(Servicos::class, 'servico_id', 'id');
    }

   
  
  
}
