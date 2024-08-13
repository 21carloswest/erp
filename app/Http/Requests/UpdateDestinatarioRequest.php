<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDestinatarioRequest extends FormRequest
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
            'destinatarios' => 'required|array',
            'destinatarios.id' => 'required|integer',
            'destinatarios.cnpjCpf' => 'prohibited',
            'destinatarios.empresaId' => 'prohibited',
            'destinatarios.inscricaoEstadual' => 'sometimes|required|numeric|max_digits:15',
            'destinatarios.inscricaoMunicipal' => 'sometimes|required|numeric|max_digits:15',
            'destinatarios.tipoIndicador' => 'sometimes|required|in:is,ic,nc',
            'destinatarios.nomeRazao' => 'sometimes|required|string|max:255',
            'enderecos' => 'sometimes|required|array',
            'enderecos.*.id' => 'required_with:enderecos.*',
            'enderecos.*.destinatarioId'=> 'prohibited',
            'enderecos.*.municipioId' => 'sometimes|required|integer|exists:municipios,id',
            'enderecos.*.cep' => 'sometimes|required|numeric|max_digits:8',
            'enderecos.*.endereco' => 'sometimes|required|string|max:255',
            'enderecos.*.bairro' => 'sometimes|required|string|max:255',
            'enderecos.*.numero' => 'sometimes|nullable|string|max:10',
        ];
    }
}
