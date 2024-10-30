<?php

namespace App\Models\Financeiro;

use App\Models\Lavagens;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movimentos extends Model
{
    use HasFactory;

    protected $fillable = ['id','parcela_id','codigo','data','tipo','centro_id','conta_id','fluxo_id','descricao','valor','user_id','status','forma_pagamento_id','saldo','venda_id'];
    protected $table = 'movimentos';

    public function setDescricaoAttribute($value)
    {
        $this->attributes['descricao'] = strtoupper($value);
    }
       public function centro(){
        return $this->belongsTo(Centros::class, 'centro_id', 'id');
    } 
    public function conta(){
        return $this->belongsTo(Contas::class, 'conta_id', 'id');
    } 
    public function fluxo(){
        return $this->belongsTo(Fluxos::class, 'fluxo_id', 'id');
    } 
    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    } 
   
}
