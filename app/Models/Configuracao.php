<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Configuracao extends Model
{
    use HasFactory;

    protected $fillable = [
        'ambiente', //0 producao 1 homologacao
        'habilitaNfe',
        'habilitaNfce',
        'habilitaNfse',
        'proxNfe',
        'proxNfce',
        'proxNfse',
        'serieNfe',
        'serieNfce',
        'serieNfse',
        'empresaId'
    ];


}
