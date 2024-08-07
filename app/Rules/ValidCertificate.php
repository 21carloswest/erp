<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidCertificate implements ValidationRule
{
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
        $pfx = file_get_contents($value);

        $pfxContent = @openssl_pkcs12_read($pfx, $certs, $this->password);

        (!$pfxContent) ? $fail('Senha incorreta.') : null;
    }
    
}
