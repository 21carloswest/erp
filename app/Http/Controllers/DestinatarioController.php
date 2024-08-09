<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDestinatarioRequest;
use App\Http\Requests\UpdateDestinatarioRequest;
use App\Models\Destinatario;
use App\Models\DestinatarioEndereco;
use App\Traits\EmpresaIdTrait;
use Illuminate\Support\Facades\DB;

class DestinatarioController extends Controller
{
    use EmpresaIdTrait;
    public function index()
    {
        $destinatarios = Destinatario::select('id', 'cnpjCpf', 'nomeRazao', 'tipoId')
            ->with('municipios:mun,uf')
            ->where('empresaId', $this->empresaId())
            ->paginate();

        if ($destinatarios->isEmpty()) {
            return $this->sendError('Nenhum destinatário encontrado.', 404);
        }

        return $this->sendResponse($destinatarios, 200);
    }

    public function store(StoreDestinatarioRequest $request)
    {
        $dados = DB::transaction(function () use ($request) {

            $empresaId = $this->empresaId();

            $destinatario = Destinatario::create([
                'cnpjCpf' => $request->destinatario['cnpjCpf'],
                'inscricaoEstadual' => $request->destinatario['inscricaoEstadual'],
                'inscricaoMunicipal' => $request->destinatario['inscricaoMunicipal'],
                'tipoIndicador' => $request->destinatario['tipoIndicador'],
                'nomeRazao' => $request->destinatario['nomeRazao'],
                'empresaId' => $empresaId,
            ]);

            foreach ($request->enderecos as $key => $value) {
                $enderecos[] = DestinatarioEndereco::create([

                    'destinatarioId' => $destinatario->id,
                    'municipioId' => $value['municipioId'],
                    'cep' => $value['cep'],
                    'bairro' => $value['bairro'],
                    'endereco' => $value['endereco'],
                    'numero' => $value['numero'],

                ]);
            }

            return ['destinatario' => $destinatario, 'enderecos' => $enderecos];
        });

        return $this->sendResponse($dados, 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Destinatario $destinatario)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Destinatario $destinatario)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDestinatarioRequest $request, Destinatario $destinatario)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Destinatario $destinatario)
    {
        //
    }
}
