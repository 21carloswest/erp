<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCertificadoRequest;
use App\Http\Requests\UpdateCertificadoRequest;
use App\Models\Certificado;
use App\Models\Empresa;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;

class CertificadoController extends Controller
{

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCertificadoRequest $request, Certificado $certificado)
    {
        $empresaId = $this->empresaId();
        $certificado = $request->file('file');

        $cnpjEmpresa = Empresa::select('cnpj')->where('id', $empresaId)->first()->cnpj;

        $nomeArquivo = $cnpjEmpresa . '.pfx';

        $teste = file_get_contents($certificado);

        $aaa = openssl_pkcs12_read($teste, $certs, '123456');
        $certData = openssl_x509_parse($certs['cert']);
        // dd($certData['subject']['ST']);
        $expirationDate = $certData['validTo_time_t'] - 3600 * 3;

        dd(date('Y-m-d H:i:s', $expirationDate));

        try {
            $path = $certificado->storeAs('certificados', $nomeArquivo);

            Certificado::create([
                'path' => $path,
                'password' => Crypt::encryptString($request->password),
                'empresaId' => $empresaId,
            ]);

        } catch (\Throwable $th) {
            throw $th;
        }

    }

    public function show(Certificado $certificado)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Certificado $certificado)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCertificadoRequest $request, Certificado $certificado)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Certificado $certificado)
    {
        //
    }
}
