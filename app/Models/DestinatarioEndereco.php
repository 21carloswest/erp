<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DestinatarioEndereco extends Model
{
    use HasFactory;

    protected $fillable = [
        'destinatarioId',
        'municipioId',
        'cep',
        'bairro',
        'endereco',
        'numero',
    ];

    public function municipios()
    {
        return $this->belongsTo(Municipio::class, 'municipioId');
    }

    public function destinatario()
    {
        return $this->belongsTo(Destinatario::class, 'destinatarioId');
    }
}
