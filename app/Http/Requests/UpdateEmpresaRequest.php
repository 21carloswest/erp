<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class UpdateEmpresaRequest extends FormRequest
{
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
            'cnpj' => 'prohibited',
            'razaoSocial' => 'sometimes|required|string|max:255',
            'nomeFantasia' => 'sometimes|required|string|max:255',
            'email' => 'prohibited',
            'password' => ['sometimes', 'required', Password::min(8)],
            'passwordConfirmation' => 'required_with:password|same:password',
            'inscricaoEstadual' => 'sometimes|required|integer|max_digits:15',
            'inscricaoMunicipal' => 'sometimes|required|integer|max_digits:15',
            'regimeTributario' => 'sometimes|required|integer|max_digits:1',
            'cep' => 'sometimes|required|integer|max_digits:8',
            'bairro' => 'sometimes|required|string|max:255',
            'endereco' => 'sometimes|required|string|max:255',
            'numero' => 'sometimes|required|string|max:10',
            'municipioId' => 'sometimes|required|integer|exists:municipios,id',
            'uf' => 'sometimes|required|exists:municipios,uf',
            'telefone' => 'sometimes|required|integer|max_digits:15',
            'celular' => 'sometimes|required|integer|max_digits:15',
            'nome' => 'sometimes|required|string|max:50',
            'cnae.*' => 'sometimes|required|integer|exists:cnaes,id',
        ];
    }
}
