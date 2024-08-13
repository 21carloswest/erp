<?php

namespace App\Traits;

use App\Models\Empresa;
use App\Models\Endereco;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

trait NfeTrait
{
    public function getChave($nota, $mod)
    {
        $empresa = Empresa::select('id', 'cnpj')
            ->where('id', $this->empresaId())
            ->first();

        $codMun = Endereco::select('municipios.codMun')
            ->join('municipios', 'municipios.id', '=', 'enderecos.municipioId')
            ->where('empresaId', '=', $empresa->id)
            ->first()
            ->codMun;

        $codUf = substr($codMun, 0, 2);

        $periodo = Carbon::parse($nota->dtEmissao)->format('ym');

        $serie = str_pad($nota->serie, 3, '0', STR_PAD_LEFT);

        $numero = str_pad($nota->numero, 9, '0', STR_PAD_LEFT);

        $chave = $codUf . $periodo . $empresa->cnpj . $mod . $serie . $numero . 1 . $nota->codigo;

        //calculo dv
        $pesos = [2, 3, 4, 5, 6, 7, 8, 9];
        $soma = 0;
        $tamanho = strlen($chave);

        // Percorra os dígitos da NFE da direita para a esquerda
        for ($i = $tamanho - 1; $i >= 0; $i--) {
            $digito = intval($chave[$i]);
            $peso = $pesos[($tamanho - 1 - $i) % count($pesos)];
            $soma += $digito * $peso;
        }

        // Calcula o módulo 11
        $resto = $soma % 11;

        // Determina o dígito verificador
        if ($resto == 0 || $resto == 1) {
            return $chave . 0;
        } else {
            return $chave . (11 - $resto);
        }

        // 1 Código da UF do emitente do Documento Fiscal 
        // 2 Ano e Mês de emissão da NF-e 04 AAMM Extraídos de B09 nota
        // 3 CNPJ/CPF do emitente 14 CNPJ/CPF C02/C02a empresa 
        // 4 Modelo do Documento Fiscal 02 mod B06 parametro
        // 5 Série do Documento Fiscal 03 serie B07 configuracao
        // 6 Número do Documento Fiscal 09 nNF B08 nota 
        // 7 forma de emissão da NF-e 01 tpEmis B22 fixo
        // 8 Código Numérico que compõe a Chave de Acesso 08 cNF B03 nota
        // 9 Dígito Verificador da Chave de Acesso 01 cDV B23 retorno
    }
}