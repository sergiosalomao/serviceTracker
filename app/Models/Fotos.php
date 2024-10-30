<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fotos extends Model
{
    use HasFactory;
   
    protected $fillable = ['descricao','veiculo_id','path'];
    protected $table = 'fotos';

    public function produto(){
        return $this->belongsTo(Produtos::class, 'produto_id', 'id');
    } 
}
