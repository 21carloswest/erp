<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreImpostosRequest;
use App\Http\Requests\UpdateImpostosRequest;
use App\Models\Impostos;
use App\Traits\EmpresaIdTrait;
use Illuminate\Support\Facades\DB;

class ImpostosController extends Controller
{
    use EmpresaIdTrait;
    public function index()
    {
        $impostos = Impostos::select(
            'id',
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
        )
            ->join('grupo_impostos', 'grupoImpostosId', '=', 'grupo_impostos.id')
            ->where('grupo_impostos.empresaId', $this->empresaId())
            ->paginate();

        if ($impostos->isEmpty()) {
            return $this->sendError('Nenhum imposto encontrado.', 404);
        }

        return $this->sendResponse($impostos, 200);
    }

    public function show(Impostos $impostos, $id)
    {
        $impostos = $impostos::select(
            'impostos.id',
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
        )
            ->join('grupo_impostos', 'grupoImpostosId', '=', 'grupo_impostos.id')
            ->where('impostos.id', '=', $id)
            ->where('grupo_impostos.empresaId', $this->empresaId())
            ->where('empresaId', $this->empresaId())
            ->get();

        if ($impostos->isEmpty()) {
            return $this->sendError('Nenhum grupo de impostos encontrado.', 404);
        }

        return $this->sendResponse($impostos, 200);
    }

    public function update(UpdateImpostosRequest $request, Impostos $impostos)
    {
        $impostos = DB::transaction(function () use ($request, $impostos) {

            $impostos = $impostos->where('impostos.id', $request->id)
                ->join('grupo_impostos', 'grupoImpostosId', '=', 'grupo_impostos.id')
                ->where('grupo_impostos.empresaId', $this->empresaId())
                ->first();

            if (!$impostos) { 
                return;
            }

            $impostos->fill($request->all());

            $impostos->save();

            return $impostos;
        });

        if (!$impostos) {
            return $this->sendError('Nenhum imposto encontrado.', 404);
        }
        return $this->sendResponse($impostos, 200);
    }

}
