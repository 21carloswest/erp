<?php

namespace App\Http\Requests\NotasFiscais\Nfe;

use App\Traits\EmpresaIdTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProdutoNfeRequest extends FormRequest
{
    use EmpresaIdTrait;

    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $empresaId = $this->empresaId();
        return [
            'nfeId' => [
                'required',
                'integer',
                Rule::exists('nfe', 'id')
                    ->where('empresaId', $empresaId),
            ],
            'produtoId' => [
                'required',
                'integer',
                Rule::exists('produtos', 'id')
                    ->where('empresaId', $empresaId),
            ],
            'cfop' => [
                'required',
                'integer',
                Rule::exists('cfops', 'numero')
            ],
            'vOutro' => 'required|decimal:0,4',
            'vDesc' => 'required|decimal:0,4',
            'vSeg' => 'required|decimal:0,4',
            'vFrete' => 'required|decimal:0,4',
            'valor' => 'required|decimal:0,4',
            'quantidade' => 'required|decimal:0,4',
            'vProd' => 'required|decimal:0,4',
            'vBcIcms' => 'required|decimal:0,4',
            'aliquotaIcms' => 'required|decimal:0,4',
            'vICMS' => 'required|decimal:0,4',
            'vBcIcmsSt' => 'required|decimal:0,4',
            'aliquotaIcmsSt' => 'required|decimal:0,4',
            'vICMSSt' => 'required|decimal:0,4',
            'vBcIpi' => 'required|decimal:0,4',
            'aliquotaIpi' => 'required|decimal:0,4',
            'vIpi' => 'required|decimal:0,4',
            'vBcCofins' => 'required|decimal:0,4',
            'aliquotaCofins' => 'required|decimal:0,4',
            'vCofins' => 'required|decimal:0,4',
            'vBcPis' => 'required|decimal:0,4',
            'aliquotaPis' => 'required|decimal:0,4',
            'vPis' => 'required|decimal:0,4',
        ];
    }
}
