<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clientes extends Model
{
    use HasFactory;
    protected $fillable = ['id', 'nome', 'obs','telefone','nascimento', 'numero','email', 'niver', 'cpf_cnpj', 'complemento', 'rua','bairro','cep','cidade','uf','sexo','tipo_cliente'];
    protected $table = 'clientes';
}
