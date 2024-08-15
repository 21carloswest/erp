<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NfeImposto extends Model
{
    use HasFactory;

    protected $fillable = [
        'nfeId',
        'vBC',
        'vICMS',
        'vICMSDeson',
        'vFCP',
        'vBCST',
        'vST',
        'vFCPST',
        'vFCPSTRet',
        'vProd',
        'vFrete',
        'vSeg',
        'vDesc',
        'vII',
        'vIPI',
        'vIPIDevol',
        'vPIS',
        'vCOFINS',
        'vOutro',
        'vNF'
    ];

    public static function getImpostos($nfeId)
    {
        $dados = self::where('nfeId', $nfeId)
            ->select(
                'id',
                'nfeId',
                'vBC',
                'vICMS',
                'vICMSDeson',
                'vFCPUFDest',
                'vICMSUFDest',
                'vICMSUFRemet',
                'vFCP',
                'vBCST',
                'vST',
                'vFCPST',
                'vFCPSTRet',
                'vProd',
                'vFrete',
                'vSeg',
                'vDesc',
                'vII',
                'vIPI',
                'vIPIDevol',
                'vPIS',
                'vCOFINS',
                'vOutro',
                'vNF',
                'vTotTrib',
            )
            ->first();

        return $dados;
    }
}
