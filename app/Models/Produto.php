<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    use HasFactory;

    protected $fillable = [
        'empresaId',
        'grupoImpostosId',
        'codigo',
        'descricao',
        'ean',
        'ncm',
        'cest',
        'unid',
        'valor',
    ];
    public function grupoImpostos()
    {
        return $this->belongsTo(GrupoImpostos::class, 'grupoImpostosId', 'id');
    }
}
