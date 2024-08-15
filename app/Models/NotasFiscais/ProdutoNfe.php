<?php

namespace App\Models\NotasFiscais;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdutoNfe extends Model
{
    use HasFactory;

    protected $table = 'produto_nfe';

    public $timestamps = false;

    protected $fillable = [
        'nfeId',
        'produtoId',
        'cfop',
        'valor',
        'quantidade',
        'vProd',
        'vOutro',
        'vDesc',
        'vSeg',
        'vFrete',
        'vBcIcms',
        'aliquotaIcms',
        'vICMS',
        'vBcIcmsSt',
        'aliquotaIcmsSt',
        'vICMSSt',
        'vBcIpi',
        'aliquotaIpi',
        'vIpi',
        'vBcCofins',
        'aliquotaCofins',
        'vCofins',
        'vBcPis',
        'aliquotaPis',
        'vPis',
    ];
}
