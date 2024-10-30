<?php

namespace App\Models\Financeiro;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Centros extends Model
{
    use HasFactory;
   
    protected $fillable = ['id','centro'];
    protected $table = 'centros';

    public function setCentroAttribute($value)
    {
        $this->attributes['centro'] = strtoupper($value);
    }
}
