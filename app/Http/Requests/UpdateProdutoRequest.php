<?php

namespace App\Http\Requests;

use App\Traits\EmpresaIdTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProdutoRequest extends FormRequest
{
    use EmpresaIdTrait;
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id' => 'required',
            'grupoImpostosId' => [
                'sometimes',
                'required',
                'integer',
                Rule::exists('grupo_impostos', 'id')
                    ->where('empresaId', $this->empresaId()),
            ],
            'codigo' => 'sometimes|required|string|max:60',
            'descricao' => 'sometimes|required|string|max:120',
            'ean' => 'sometimes|required|numeric|max_digits:14',
            'ncm' => 'sometimes|required|numeric|exists:ncms,codigo',
            'cest' => 'sometimes|required|numeric|max_digits:7',
            'unid' => 'sometimes|required|string|max:6',
            'valor' => 'sometimes|required|decimal:0,4',
        ];
    }
}
