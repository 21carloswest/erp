<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Impostos extends Model
{
    use HasFactory;

    protected $fillable = [
        'grupoImpostosId',
        'indicadorDestinoId',
        'cfopId',
        'aliqIcms',
        'aliqIcmst',
        'aliqIcmsCredito',
        'aliqIpi',
        'aliqPis',
        'aliqCofins',
        'aliqIss',
        'cstIcms',
        'cstIpi',
        'cstPis',
        'cstCofins',
        'enquadramentoIpi',
        'origem',
    ];

    public function grupoImpostos()
    {
        return $this->belongsTo(GrupoImpostos::class, 'grupoImpostosId');
    }
}
