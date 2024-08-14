<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProdutoRequest;
use App\Http\Requests\UpdateProdutoRequest;
use App\Models\Produto;
use App\Traits\EmpresaIdTrait;

class ProdutoController extends Controller
{
    use EmpresaIdTrait;

    public function index()
    {
        $Produtos = Produto::select(
            'id',
            'empresaId',
            'grupoImpostosId',
            'codigo',
            'descricao',
            'ean',
            'ncm',
            'cest',
            'unid',
            'valor',
        )
            ->with('grupoImpostos')
            ->where('empresaId', $this->empresaId())
            ->paginate();

        if ($Produtos->isEmpty()) {
            return $this->sendError('Nenhum produto encontrado.', 404);
        }

        return $this->sendResponse($Produtos, 200);
    }

    public function store(StoreProdutoRequest $request)
    {

        $empresaId = $this->empresaId();

        $produto = Produto::create([
            'empresaId' => $empresaId,
            'grupoImpostosId' => $request->grupoImpostosId,
            'codigo' => $request->codigo,
            'descricao' => $request->descricao,
            'ean' => $request->ean,
            'ncm' => $request->ncm,
            'cest' => $request->cest,
            'unid' => $request->unid,
            'valor' => $request->valor,
        ]);

        return $this->sendResponse($produto, 200);
    }

    public function show(Produto $produto, $id)
    {
        $Produtos = $produto->select(
            'id',
            'empresaId',
            'grupoImpostosId',
            'codigo',
            'descricao',
            'ean',
            'ncm',
            'cest',
            'unid',
            'valor',
        )
            ->with('grupoImpostos')

            ->where('id', $id)
            ->where('empresaId', $this->empresaId())
            ->get();

        if ($Produtos->isEmpty()) {
            return $this->sendError('Nenhum produto encontrado.', 404);
        }

        return $this->sendResponse($Produtos, 200);
    }

    public function update(UpdateProdutoRequest $request, Produto $produto)
    {
        $empresaId = $this->empresaId();

        $produto = $produto->where('id', $request->id)
            ->where('empresaId', $this->empresaId())
            ->first();

        if (empty($produto)) {
            return $this->sendError('Nenhum produto encontrado.', 404);
        }

        $produto->fill($request->all());

        $produto->save();

        return $this->sendResponse($produto, 200);
    }

    public function destroy(Produto $produto)
    {
        //
    }
}
