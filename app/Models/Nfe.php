<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nfe extends Model
{
    use HasFactory;

    const NaoEnviada = 4;


    protected $table = 'nfe';

    protected $fillable = [
        'empresaId',
        'finalidadeId',
        'destinoId',
        'statusId',
        'intermediadorId',
        'destinatarioId',
        'destinatarioEnderecoId',
        'transportadoraId',
        'naturezaOperacao',
        'saida',
        'ambiente',
        'dtEmissao',
        'dtSaida',
        'serie',
        'numero',
        'codigo',
        'chave',
    ];

    public function destinatario()
    {
        return $this->belongsTo(Destinatario::class, 'destinatarioId', 'id');
    }

    public function nfeImposto()
    {
        return $this->hasOne(NfeImposto::class, 'nfeId', 'id');
    }

    public function nfeInfo()
    {
        return $this->hasOne(NfeInfo::class, 'nfeId', 'id');
    }
}
