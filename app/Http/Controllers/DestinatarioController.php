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
        $destinatarios = Destinatario::with([
            'enderecos' => function ($query) {
                $query->select('destinatarioId', 'municipioId');
            },
            'enderecos.municipios' => function ($query) {
                $query->select('id', 'uf', 'mun');
            }
        ])
            ->select('id', 'cnpjCpf', 'nomeRazao')
            ->where('destinatarios.empresaId', $this->empresaId())
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
                'cnpjCpf' => $request->destinatarios['cnpjCpf'],
                'inscricaoEstadual' => $request->destinatarios['inscricaoEstadual'],
                'inscricaoMunicipal' => $request->destinatarios['inscricaoMunicipal'],
                'tipoIndicador' => $request->destinatarios['tipoIndicador'],
                'nomeRazao' => $request->destinatarios['nomeRazao'],
                'empresaId' => $empresaId,
            ]);

            foreach ($request->enderecos as $key => $value) {
                $enderecos[$key] = DestinatarioEndereco::create([
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

    public function show(Destinatario $destinatario, $id)
    {
        $destinatario = Destinatario::with([
            'enderecos' => function ($query) {
                $query->select('destinatarioId', 'municipioId', 'cep', 'bairro', 'endereco', 'numero');
            },
            'enderecos.municipios' => function ($query) {
                $query->select('id', 'uf', 'mun');
            }
        ])
            ->select(
                'id',
                'cnpjCpf',
                'nomeRazao',
                'inscricaoEstadual',
                'inscricaoMunicipal',
                'tipoIndicador',
            )
            ->where('destinatarios.id', $id)
            ->where('destinatarios.empresaId', $this->empresaId())
            ->get();

        if ($destinatario->isEmpty()) {
            return $this->sendError('Nenhum destinatário encontrado.', 404);
        }

        return $this->sendResponse($destinatario, 200);
    }

    public function update(UpdateDestinatarioRequest $request, Destinatario $destinatario)
    {
        $destinatario = DB::transaction(function () use ($request, $destinatario) {

            $destinatario = $destinatario->where('id', $request->destinatarios['id'])
                ->where('empresaId', $this->empresaId())
                ->first();

            if (!$destinatario) {
                return;
            }

            $destinatario->fill($request->destinatarios);

            $destinatario->save();

            if ($request->enderecos) {

                foreach ($request->enderecos as $key => $value) {
                    $enderecos = DestinatarioEndereco::where('id', $value['id'])
                        ->where('destinatarioId', $destinatario->id)
                        ->first();

                    if (!$enderecos) {
                        return;
                    }

                    $enderecos->fill($value);

                    $enderecos->save();

                    $enderecosArray[] = $enderecos->toArray();
                }
            }

            $retorno['destinatario'] = $destinatario->toArray();

            $request->destinatarios ? $retorno['enderecos'] = $enderecosArray : null;

            return $retorno;
        });

        if (!$destinatario) {
            return $this->sendError('Nenhum destinatário encontrado.', 404);
        }

        return $this->sendResponse($destinatario, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Destinatario $destinatario)
    {
        //
    }
}
