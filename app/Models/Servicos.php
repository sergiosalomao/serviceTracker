<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servicos extends Model
{
    use HasFactory;
    protected $fillable = [
        'id', 'categoria_id', 'descricao', 'status','codigo','tempo_estimado','valor'
    ];
    protected $table = 'servicos';

    public function categoria()
    {
        return $this->belongsTo(Categorias::class, 'categoria_id', 'id');
    }
    
}
