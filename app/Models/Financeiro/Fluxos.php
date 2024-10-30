<?php

namespace App\Models\Financeiro;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fluxos extends Model
{
    use HasFactory;

    protected $fillable = ['id','tipo','fluxo'];
    protected $table = 'fluxos';

    public function setFluxoAttribute($value)
    {
        $this->attributes['fluxo'] = strtoupper($value);
    }
}
