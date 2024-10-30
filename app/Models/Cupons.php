<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cupons extends Model
{
    use HasFactory;
    protected $fillable = ['id','codigo','cliente_id','campanha_id','status','desconto'];
    protected $table = 'cupons';

    public function cliente(){
        return $this->hasMany(Clientes::class, 'id', 'cliente_id');
    } 

    public function campanha(){
        return $this->hasMany(Campanhas::class, 'id', 'campanha_id');
    } 
}
