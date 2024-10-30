<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campanhas extends Model
{
    use HasFactory;
    protected $fillable = ['titulo','descricao','desconto','status','limite','id','qtd_cupons','foto_path'];
    protected $table = 'campanhas';

    public function cupom(){
        return $this->hasMany(Cupons::class, 'campanha_id', 'id');
    } 


    public function setTituloAttribute($value)
    {
        $this->attributes['titulo'] = strtoupper($value);
    }
}
