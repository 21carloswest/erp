<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreConfiguracaoRequest;
use App\Http\Requests\UpdateConfiguracaoRequest;
use App\Models\Configuracao;
use App\Traits\EmpresaIdTrait;
use Illuminate\Support\Facades\DB;

class ConfiguracaoController extends Controller
{
    use EmpresaIdTrait;

    public function show(Configuracao $configuracao)
    {
        $configuracao = $configuracao->where('empresaId', $this->empresaId())
            ->get();

        return $this->sendResponse($configuracao, 200);
    }

    public function update(UpdateConfiguracaoRequest $request, Configuracao $configuracao)
    {
        $configuracao = DB::transaction(function () use ($request, $configuracao) {

            $configuracao = $configuracao->where('empresaId', $this->empresaId())->firstOrFail();

            $configuracao->fill($request->all());

            $configuracao->save();

            return $configuracao;
        });

        return $this->sendResponse($configuracao, 200);
    }
}
