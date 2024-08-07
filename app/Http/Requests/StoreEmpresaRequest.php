<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class StoreEmpresaRequest extends FormRequest
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
            'cnpj' => ['required', 'integer', 'max_digits:14', 'regex:^(?:\d{2}\.\d{3}\.\d{3}\/\d{4}-\d{2}|\d{14})$^'],
            'razaoSocial' => 'required|string|max:255',
            'nomeFantasia' => 'sometimes|required|string|max:255',
            'email' => 'required|string|email|unique:empresas',
            'password' => ['required', Password::min(8)],
            'passwordConfirmation' => 'required|same:password',
            'inscricaoEstadual' => 'sometimes|required|integer|max_digits:15',
            'inscricaoMunicipal' => 'sometimes|required|integer|max_digits:15',
        ];
    }
}
