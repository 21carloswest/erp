<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Destinatario extends Model
{
    use HasFactory;

    protected $fillable = [
        'cnpjCpf',
        'inscricaoEstadual',
        'inscricaoMunicipal',
        'tipoIndicador',
        'nomeRazao'
    ];

    public function enderecos()
    {
        return $this->hasMany(DestinatarioEndereco::class, 'destinatarioId', 'id');
    }

    public function municipios()
    {
        return $this->hasManyThrough(Municipio::class, DestinatarioEndereco::class, 'destinatarioId', 'municipioId');
    }
}
