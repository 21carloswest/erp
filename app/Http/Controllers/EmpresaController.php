<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEmpresaRequest;
use App\Http\Requests\UpdateEmpresaRequest;
use App\Models\Contato;
use App\Models\Empresa;
use App\Models\EmpresaCnae;
use App\Models\Endereco;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EmpresaController extends Controller
{

    public function store(StoreEmpresaRequest $request)
    {
        $empresa = DB::transaction(function () use ($request) {

            $empresa = Empresa::create([
                'cnpj' => $request->cnpj,
                'razaoSocial' => $request->razaoSocial,
                'nomeFantasia' => $request->nomeFantasia,
                'password' => bcrypt($request->password),
                'email' => $request->email,
                'inscricaoEstadual' => $request->inscricaoEstadual,
                'ativa' => 1,
            ]);

            Contato::create([
                'empresaId' => $empresa->id,
            ]);

            Endereco::create([
                'empresaId' => $empresa->id,
            ]);

            return $empresa;
        });

        return $this->sendResponse($empresa, 201);

    }


    public function show(Empresa $empresa, Endereco $endereco, EmpresaCnae $empresaCnae, Contato $contato)
    {
        $empresa = $empresa->where('id', $this->empresaId())
            ->select([
                'id',
                'regimeTributario',
                'cnpj',
                'razaoSocial',
                'nomeFantasia',
                'email',
                'inscricaoEstadual',
                'inscricaoMunicipal',
                'regimeTributario',
                'created_at'
            ])
            ->get();

        $endereco = $endereco->where('empresaId', $this->empresaId())
            ->select([
                'id',
                'cep',
                'bairro',
                'endereco',
                'numero',
            ])
            ->get();

        $contato = $contato->where('empresaId', $this->empresaId())
            ->select([
                'id',
                'telefone',
                'celular',
                'nome',
            ])
            ->get();

        $empresaCnae = $empresaCnae->where('empresaId', $this->empresaId())
            ->select(['empresaId', 'cnaeId'])
            ->get();

        return $this->sendResponse(['empresa' => $empresa, 'endereco' => $endereco, 'contato' => $contato, 'empresaCnae' => $empresaCnae], 200);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEmpresaRequest $request, Empresa $empresa)
    {
        // $cnaes = EmpresaCnae::where('id', $request->contatoId)->findOrFail($this->empresaId());

        DB::transaction(function () use ($request) {

            $empresa = Empresa::findOrFail($this->empresaId());

            $empresa->fill($request->all());

            $empresa->save();

            $endereco = Endereco::where('id', $request->enderecoId)->findOrFail($this->empresaId());

            $endereco->fill($request->all());

            $endereco->save();

            $contato = Contato::where('id', $request->contatoId)->findOrFail($this->empresaId());

            $contato->fill($request->all());

            $contato->save();

        });
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Empresa $empresa)
    {
        //
    }
}
