<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCertificadoRequest;
use App\Models\Certificado;
use App\Models\Empresa;
use App\Traits\EmpresaIdTrait;
use App\Traits\TimezoneTrait;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;

class CertificadoController extends Controller
{
    use TimezoneTrait, EmpresaIdTrait;

    public function store(StoreCertificadoRequest $request, Certificado $certificado)
    {
        $empresaId = $this->empresaId();

        $certificado = $request->file('file');

        $certPassword = $request->password;

        $expiritionDate = $this->getExpiritionDate($certificado, $certPassword);

        $cnpjEmpresa = Empresa::select('cnpj')->where('id', $empresaId)->first()->cnpj;

        $nomeArquivo = $cnpjEmpresa . '.pfx';

        try {
            $path = $certificado->storeAs('certificados', $nomeArquivo);

            $cert = Certificado::create([
                'path' => $path,
                'password' => Crypt::encryptString($request->password),
                'empresaId' => $empresaId,
                'dataValidade' => $expiritionDate,
            ]);

        } catch (\Throwable $th) {
            return $this->sendError($th, 500);
        }

        return $this->sendResponse($cert, 200, 'Certificado salvo com sucesso.');
    }

    public function show(Certificado $certificado)
    {
        $certificado = $certificado->where('empresaId', $this->empresaId())
            ->select(['id', 'dataValidade'])
            ->get();

        if ($certificado->isEmpty()) {
            return $this->sendError('Nenhum certificado encontrado.', 404);
        }

        return $this->sendResponse($certificado, 200);
    }

    public function destroy(Certificado $certificado)
    {
        $certificado = $certificado->select('id', 'path')->where('empresaId', '=', $this->empresaId());

        if ($certificado->get()->isEmpty()) {
            return $this->sendError('Certificado não encontrado.');
        }

        try {

            $path = $certificado->first()->path;

            Storage::delete($path);

            $certificado->delete();

        } catch (\Throwable $th) {
            return $this->sendError($th, 500);
        }

        return $this->sendResponse($certificado, 200, 'Certificado excluído.');
    }

    public function getExpiritionDate($file, $password)
    {
        //certificado em string
        $file = file_get_contents($file);

        //passa a senha do certificado
        $openPfx = openssl_pkcs12_read($file, $certs, $password);

        //dados do certificado
        $certData = openssl_x509_parse($certs['cert']);

        //uf de emissao do certificado
        $uf = $certData['subject']['ST'];

        //fuso do estado de emissao
        $timezone = $this->getTimezone($uf);

        //data em unix
        $expirationDate = $certData['validTo_time_t'] + $timezone * 3600;

        return date('Y-m-d H:i:s', $expirationDate);

    }

}
