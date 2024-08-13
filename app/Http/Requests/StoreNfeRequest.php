<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreNfeRequest extends FormRequest
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
            'nfe' => 'required|array',
            'nfe.empresaId' => 'prohibited',
            'nfe.statusId' => 'prohibited',
            'nfe.ambiente' => 'prohibited',
            'nfe.dtAutorizacao' => 'prohibited',
            'nfe.chave' => 'prohibited',
            'nfe.serie' => 'prohibited',
            'nfe.numero' => 'prohibited',
            'nfe.codigo' => 'prohibited',
            'nfe.ipEnvio' => 'prohibited',
            'nfe.naturezaOperacao' => 'sometimes|required|string|max:100',
            'nfe.saida' => 'sometimes|required|boolean',
            'nfe.dtEmissao' => 'sometimes|required|date:Y-m-d H:i:s',
            'nfe.dtSaida' => 'sometimes|nullable|date:Y-m-d H:i:s',
            'nfe.finalidadeId' => 'sometimes|integer|exists:finalidades,id',
            'nfe.destinoId' => 'sometimes|integer|exists:indicador_destinos,id',

            'nfe.intermediadorId' => 'sometimes|integer|exists:intermediadors,id',
            'nfe.destinatarioId' => 'sometimes|integer|exists:destinatarios,id',
            'nfe.destinatarioEnderecoId' => 'sometimes|integer|exists:destinatario_enderecos,id',
            'nfe.transportadoraId' => 'sometimes|integer|exists:transportadoras,id',
        ];
    }
}
