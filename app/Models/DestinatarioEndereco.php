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
}
