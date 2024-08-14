<?php

namespace App\Http\Requests;

use App\Traits\EmpresaIdTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProdutoRequest extends FormRequest
{
    use EmpresaIdTrait;
    /**
     * Determine if the user is authorized to make this request.
     */
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
        return [
            'empresaId' => 'prohibited',
            'grupoImpostosId' => [
                'required',
                'integer',
                Rule::exists('grupo_impostos', 'id')
                    ->where('empresaId', $this->empresaId()),
            ],
            'codigo' => 'required|string|max:60',
            'descricao' => 'required|string|max:120',
            'ean' => 'required|numeric|max_digits:14',
            'ncm' => 'required|numeric|exists:ncms,codigo',
            'cest' => 'required|numeric|max_digits:7',
            'unid' => 'required|string|max:6',
            'valor' => 'required|decimal:0,4',
        ];
    }
}
