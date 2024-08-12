<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreNfeRequest;
use App\Http\Requests\UpdateNfeRequest;
use App\Models\Configuracao;
use App\Models\Nfe;
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

    public function index()
    {
        //
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

            // $table->timestamp('dtAutorizacao')->nullable();

            // $table->string('chave')->nullable();
            // $table->integer('serie');
            // $table->integer('numero');
            // $table->string('codigo', 8);


            return ['nfe' => $nfe];
        });

        return $this->sendResponse($dados, 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Nfe $nfe)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateNfeRequest $request, Nfe $nfe)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Nfe $nfe)
    {
        //
    }

    public function enviar ()
    {
        //ipEnvio
    }
}
