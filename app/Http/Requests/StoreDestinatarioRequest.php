<?php

namespace App\Http\Requests;

use App\Traits\EmpresaIdTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Database\Query\Builder;

class StoreDestinatarioRequest extends FormRequest
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
            'destinatarios' => 'required|array',
            'destinatarios.cnpjCpf' => [
                'required',
                'numeric',
                Rule::unique('destinatarios')->where(fn(Builder $query) => $query->where('empresaId', $this->empresaId())),
                'max_digits:14',
                'regex:^([0-9]{2}[\.]?[0-9]{3}[\.]?[0-9]{3}[\/]?[0-9]{4}[-]?[0-9]{2})|([0-9]{3}[\.]?[0-9]{3}[\.]?[0-9]{3}[-]?[0-9]{2})^'
            ],
            'destinatarios.inscricaoEstadual' => 'required|integer|max_digits:15',
            'destinatarios.inscricaoMunicipal' => 'required|integer|max_digits:15',
            'destinatarios.tipoIndicador' => 'required|in:is,ic,nc',
            'destinatarios.nomeRazao' => 'required|string|max:255',
            'enderecos' => 'required|array',
            'enderecos.*.municipioId' => 'required|integer|exists:municipios,id',
            'enderecos.*.cep' => 'required|numeric|max_digits:8',
            'enderecos.*.endereco' => 'required|string|max:255',
            'enderecos.*.bairro' => 'required|string|max:255',
            'enderecos.*.numero' => 'nullable|string|max:10',
        ];
    }
}
