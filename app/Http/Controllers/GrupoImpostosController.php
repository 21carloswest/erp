<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGrupoImpostosRequest;
use App\Http\Requests\UpdateGrupoImpostosRequest;
use App\Models\GrupoImpostos;
use App\Models\Impostos;
use App\Traits\EmpresaIdTrait;
use Illuminate\Support\Facades\DB;

class GrupoImpostosController extends Controller
{
    use EmpresaIdTrait;

    public function index()
    {
        $grupoImpostos = GrupoImpostos::select('id', 'name', 'tipoId')
            ->where('empresaId', $this->empresaId())
            ->paginate();

        if ($grupoImpostos->isEmpty()) {
            return $this->sendError('Nenhum grupo de impostos encontrado.', 404);
        }

        return $this->sendResponse($grupoImpostos, 200);
    }

    public function store(StoreGrupoImpostosRequest $request)
    {
        $dados = DB::transaction(function () use ($request) {

            $empresaId = $this->empresaId();

            $grupo = GrupoImpostos::create([
                'tipoId' => $request->grupo['tipoId'],
                'name' => $request->grupo['name'],
                'empresaId' => $empresaId,
            ]);

            foreach ($request->impostos as $key => $value) {
                $impostos[] = Impostos::create([
                    'grupoImpostosId' => $grupo->id,
                    'indicadorDestinoId' => $value['indicadorDestinoId'],
                    'cfopId' => $value['cfopId'],
                    'aliqIcms' => $value['aliqIcms'],
                    'aliqIcmst' => $value['aliqIcmst'],
                    'aliqIcmsCredito' => $value['aliqIcmsCredito'],
                    'aliqIpi' => $value['aliqIpi'],
                    'aliqPis' => $value['aliqPis'],
                    'aliqCofins' => $value['aliqCofins'],
                    'aliqIss' => $value['aliqIss'],
                    'cstIcms' => $value['cstIcms'],
                    'cstIpi' => $value['cstIpi'],
                    'cstPis' => $value['cstPis'],
                    'cstCofins' => $value['cstCofins'],
                    'enquadramentoIpi' => $value['enquadramentoIpi'],
                    'origem' => $value['origem'],
                ]);
            }

            return ['grupoImpostos' => $grupo, 'impostos' => $impostos];
        });

        return $this->sendResponse($dados, 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(GrupoImpostos $grupoImpostos, $id)
    {
        $grupoImpostos = GrupoImpostos::select('id', 'name', 'tipoId')
            ->with('impostos:id,grupoImpostosId,indicadorDestinoId,cfopId,aliqIcms,origem,enquadramentoIpi,cstCofins,cstPis,cstIpi,cstIcms,aliqIss,aliqCofins,aliqPis,aliqIpi,aliqIcmst,aliqIcmsCredito')
            ->where('id', '=', $id)
            ->where('empresaId', $this->empresaId())
            ->get();

        if ($grupoImpostos->isEmpty()) {
            return $this->sendError('Nenhum grupo de impostos encontrado.', 404);
        }

        return $this->sendResponse($grupoImpostos, 200);
    }


    public function update(UpdateGrupoImpostosRequest $request, GrupoImpostos $grupoImpostos)
    {
        $grupoImpostos = DB::transaction(function () use ($request, $grupoImpostos) {

            $grupoImpostos = $grupoImpostos->where('id', $request->grupo['id'])
                ->where('empresaId', $this->empresaId())
                ->firstOrFail();

            $grupoImpostos->fill($request->grupo);

            $grupoImpostos->save();

            if ($request->impostos) {

                foreach ($request->impostos as $key => $value) {
                    $impostos = Impostos::where('id', $value['id'])
                        ->where('grupoImpostosId', $grupoImpostos->id)
                        ->firstOrFail();

                    $impostos->fill($request->impostos[$key]);

                    $impostos->save();

                    $impostosArray[] = $impostos->toArray();
                }
            }

            $retorno['grupoImpostos'] = $grupoImpostos->toArray();


            $request->impostos ? $retorno['impostos'] = $impostosArray : null;

            return $retorno;
        });

        return $this->sendResponse($grupoImpostos, 200);

    }

    public function destroy(GrupoImpostos $grupoImpostos, $id)
    {
        $grupo = $grupoImpostos->where('id', $id)
            ->with('produtos:id,grupoImpostosId')
            ->where('empresaId', $this->empresaId())
            ->select('id')
            ->first();

        if (empty($grupo)) {
            return $this->sendError('Grupo de impostos não encontrado.', 404);
        }

        if (!$grupo->produtos->isEmpty()) {
            return $this->sendError(
                'O grupo de impostos não pode ser apagado, pois existe um produto vinculado.',
                404
            );
        }

        $delete = $grupo->delete();

        if ($delete) {
            return $this->sendResponse('', 200, 'Grupo de impostos excluído.');
        } else {
            return $this->sendError('Houve um erro ao excluir.', 404);
        }
        
    }
}
