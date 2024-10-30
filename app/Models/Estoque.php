<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estoque extends Model
{
    use HasFactory;
    protected $fillable = [

        'produto_id', 'und',  'qtd', 'status', 'tipo','historico','compra_id',
    ];
    protected $table = 'estoque';

  
    public function produto()
    {
        return $this->belongsTo(Produtos::class, 'produto_id', 'id');
    }
    public function compra()
    {
        return $this->belongsTo(Compras::class, 'compra_id', 'id');
    }
}
