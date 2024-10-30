<?php

namespace App\Models\Financeiro;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contas extends Model
{
    use HasFactory;
    protected $fillable = ['id','conta'];
    protected $table = 'contas';

    public function setContaAttribute($value)
    {
        $this->attributes['conta'] = strtoupper($value);
    }
}
