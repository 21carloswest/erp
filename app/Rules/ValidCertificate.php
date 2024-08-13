<?php

namespace App\Rules;

use App\Models\Certificado;
use App\Traits\EmpresaIdTrait;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidCertificate implements ValidationRule
{

    use EmpresaIdTrait;

    protected $password;

    public function __construct($password)
    {
        $this->password = $password;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (Certificado::where('empresaId', '=', $this->empresaId())->first())
        {
            $fail('Já existe um certificado salvo para a empresa.');
        } 

        $pfx = file_get_contents($value);

        $pfxContent = @openssl_pkcs12_read($pfx, $certs, $this->password);


        if (!$pfxContent) {
            $fail('Senha incorreta.');
        }

        if ($pfxContent) {

            $certData = openssl_x509_parse($certs['cert']);

            $expirationDate = $certData['validTo_time_t'];

            ($expirationDate < time()) ? $fail('Certificado vencido.') : null;

        }
    }

}
