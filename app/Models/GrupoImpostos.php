<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GrupoImpostos extends Model
{
    use HasFactory;

    protected $fillable = ['tipoId', 'name', 'empresaId'];

    public function impostos(){
        return $this->hasMany(Impostos::class, 'grupoImpostosId', 'id');
    }

    public function produtos(){
        return $this->hasMany(Produto::class, 'grupoImpostosId', 'id');
    }
}
