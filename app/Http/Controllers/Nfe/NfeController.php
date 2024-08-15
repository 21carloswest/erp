<?php

namespace App\Http\Controllers\Nfe;

use App\Http\Controllers\Controller;
use App\Http\Requests\NotasFiscais\Nfe\QueryNfeRequest;
use App\Http\Requests\NotasFiscais\Nfe\StoreNfeRequest;
use App\Http\Requests\NotasFiscais\Nfe\StoreProdutoNfeRequest;
use App\Http\Requests\NotasFiscais\Nfe\UpdateNfeRequest;
use App\Models\Configuracao;
use App\Models\Nfe;
use App\Models\NfeImposto;
use App\Models\NfeInfo;
use App\Models\NotasFiscais\ProdutoNfe;
use App\Traits\EmpresaIdTrait;
use App\Traits\NfeTrait;
use App\Traits\TimezoneTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class NfeController extends Controller
{
    use EmpresaIdTrait;

    use TimezoneTrait;

    use NfeTrait;

    public function index(QueryNfeRequest $request)
    {
        $nfes = Nfe::with([
            'destinatario' => function ($query) {
                $query->select('id', 'cnpjCpf', 'nomeRazao');
            },
            'nfeImposto' => function ($query) {
                $query->select('vNF', 'nfeId');
            },
        ])
            ->select('id', 'destinatarioId', 'numero', 'dtEmissao', 'statusId', 'ambiente')
            ->where('ambiente', '=', $request->input('ambiente'))
            ->where('nfe.empresaId', $this->empresaId())
            ->paginate();

        if ($nfes->isEmpty()) {
            return $this->sendError('Nenhuma nota encontrada.', 404);
        }

        return $this->sendResponse($nfes, 200);
    }

    public function store(StoreNfeRequest $request)
    {
        $dados = DB::transaction(function () use ($request) {

            $empresaId = $this->empresaId();

            if (!$request->has('nfe.dtEmissao')) {
                $uf = DB::table('enderecos')
                    ->select('municipios.uf')
                    ->join('municipios', 'municipios.id', '=', 'enderecos.municipioId')
                    ->where('empresaId', '=', $empresaId)
                    ->first()
                    ->uf;

                $timezone = $this->getTimezone($uf);

                $dataEmissao = Carbon::now()->setTimezone($timezone)->toDateTimeString();
            }

            $config = Configuracao::select('ambiente', 'serieNfe', 'proxNfe')->where('empresaId', $empresaId)->first();

            $nfe = new Nfe;

            $nfe->fill($request->nfe);

            $numeroAleatorio = rand(1, 99999999);

            $codigoNf = str_pad($numeroAleatorio, 8, '0', STR_PAD_LEFT);

            $nfe->fill([
                'empresaId' => $empresaId,
                'statusId' => Nfe::NaoEnviada,
                'ambiente' => $config->ambiente,
                'serie' => $config->serieNfe,
                'dtEmissao' => (@$dataEmissao) ? @$dataEmissao : $request->nfe['dtEmissao'],
                // 'dtSaida' => $request->nfe['dtSaida'] ? @$dataEmissao : $request->nfe['dtSaida'],
                'numero' => $config->proxNfe,
                'codigo' => $codigoNf
            ]);

            $chave = $this->getChave($nfe, 55);

            $nfe->chave = $chave;

            $nfe->save();

            $configuracao = Configuracao::where('empresaId', $this->empresaId())->firstOrFail();

            $configuracao->proxNfe = $configuracao->proxNfe + 1;

            $configuracao->save();

            $nfeImpostos = NfeImposto::create([
                'nfeId' => $nfe->id,
                'vBC' => 0,
                'vICMS' => 0,
                'vICMSDeson' => 0,
                'vFCP' => 0,
                'vBCST' => 0,
                'vST' => 0,
                'vFCPST' => 0,
                'vFCPSTRet' => 0,
                'vProd' => 0,
                'vFrete' => 0,
                'vSeg' => 0,
                'vDesc' => 0,
                'vII' => 0,
                'vIPI' => 0,
                'vIPIDevol' => 0,
                'vPIS' => 0,
                'vCOFINS' => 0,
                'vOutro' => 0,
                'vNF' => 0,
            ]);

            $nfeInfo = NfeInfo::create([
                'nfeId' => $nfe->id,
            ]);

            return ['nfe' => $nfe, 'impostos' => $nfeImpostos];
        });

        return $this->sendResponse($dados, 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(QueryNfeRequest $request, Nfe $nfe)
    {
        $nfe = $nfe->with([
            'destinatario' => function ($query) {
                $query->select('id', 'cnpjCpf', 'nomeRazao');
            },
            'nfeImposto' => function ($query) {
                $query->select(
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
                );
            },
        ])
            ->where('id', '=', $request->id)
            ->where('ambiente', '=', $request->input('ambiente'))
            ->where('empresaId', $this->empresaId())
            ->select(
                'id',
                'finalidadeId',
                'destinoId',
                'statusId',
                'intermediadorId',
                'destinatarioId',
                'destinatarioEnderecoId',
                'transportadoraId',
                'naturezaOperacao',
                'saida',
                'ambiente',
                'dtEmissao',
                'dtSaida',
                'dtAutorizacao',
                'chave',
                'serie',
                'numero',
            )
            ->get();

        if ($nfe->isEmpty()) {
            return $this->sendError('Nota não encontrada.', 404);
        }

        return $this->sendResponse($nfe, 200);
    }

    public function update(UpdateNfeRequest $request, Nfe $nfe)
    {

    }

    public function destroy(Nfe $nfe, $id)
    {
        $nfe = $nfe->where('id', $id)
            ->with('nfeImposto', 'nfeInfo')
            ->where('empresaId', $this->empresaId())
            ->select('id', 'statusId')
            ->get();

        if ($nfe->isEmpty()) {
            return $this->sendError('Nota não encontrada.', 404);
        }

        if ($nfe[0]->statusId !== Nfe::NaoEnviada) {
            return $this->sendError('A nota não pode ser apagada.', 404);
        }

        $delete = DB::transaction(function () use ($nfe) {

            $nfe[0]->nfeImposto->delete();

            $nfe[0]->nfeInfo->delete();

            $delete = $nfe[0]->delete();

            return $delete;
        });

        if ($delete) {
            return $this->sendResponse('', 200, 'Nota excluída.');
        } else {
            return $this->sendError('Houve um erro ao excluir.', 404);
        }
    }

    public function storeProdutoNfe(StoreProdutoNfeRequest $request, ProdutoNfe $produtoNfe)
    {
        $dados = DB::transaction(function () use ($request, $produtoNfe) {

            $produtoNfe->fill($request->all());

            $produtoNfe->save();

            $nfeImposto = NfeImposto::getImpostos($produtoNfe->nfeId);

            $nfeImposto->vBC += $produtoNfe->vBcIcms;
            $nfeImposto->vICMS += $produtoNfe->vICMS;
            // $nfeImposto->vICMSDeson += $produtoNfe->;
            // $nfeImposto->vFCP += produtoNfe->;
            $nfeImposto->vBCST += $produtoNfe->vBcIcmsSt;
            $nfeImposto->vST += $produtoNfe->vICMSSt;
            // $nfeImposto->vFCPST += $produtoNfe->;
            // $nfeImposto->vFCPSTRet+= $produtoNfe->;
            $nfeImposto->vProd += $produtoNfe->vProd;
            $nfeImposto->vFrete += $produtoNfe->vFrete;
            $nfeImposto->vSeg += $produtoNfe->vSeg;
            $nfeImposto->vDesc += $produtoNfe->vDesc;
            // $nfeImposto->vII += $produtoNfe->;
            $nfeImposto->vIPI += $produtoNfe->vIpi;
            // $nfeImposto->vIPIDevol += $produtoNfe->;
            $nfeImposto->vPIS += $produtoNfe->vPis;
            $nfeImposto->vCOFINS += $produtoNfe->vCofins;
            $nfeImposto->vOutro += $produtoNfe->vOutro;
            $nfeImposto->vNF = $nfeImposto->vProd
                - $nfeImposto->vDesc
                - $nfeImposto->vICMSDeson
                + $nfeImposto->vST
                + $nfeImposto->vFCPST
                + $nfeImposto->vFrete
                + $nfeImposto->vSeg
                + $nfeImposto->vOutro
                + $nfeImposto->vII
                + $nfeImposto->vIPI
                + $nfeImposto->vIPIDevol
                + $nfeImposto->vServ;

            $nfeImposto->save();

            // (+) vProd (id:W07)
            // (-) vDesc (id:W10)
            // (-) vICMSDeson (id:W04a)
            // (+) vST (id:W06)
            // (+) vFCPST (id:W06a)
            // (+) vFrete (id:W08)
            // (+) vSeg (id:W09)
            // (+) vOutro (id:W15)
            // (+) vII (id:W11)
            // (+) vIPI (id:W12)
            // (+) vIPIDevol (id: W12a)
            // (+) vServ (id:W18) (*3) (NT 2011/005)
            return ['item' => $produtoNfe, 'nfeImpostos' => $nfeImposto];
        });

        return $this->sendResponse($dados, 200);
    }

    public function enviar()
    {
        //ipEnvio
    }
}
