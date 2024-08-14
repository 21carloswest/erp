<?php

namespace App\Http\Requests\NotasFiscais\Nfe;

use App\Traits\EmpresaIdTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreNfeRequest extends FormRequest
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
        $empresaId = $this->empresaId();
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
            'nfe.intermediadorId' => [
                'sometimes',
                'integer',
                Rule::exists('intermediadors', 'id')
                    ->where('empresaId', $empresaId),
            ],
            'nfe.destinatarioId' => [
                'sometimes',
                'integer',
                Rule::exists('destinatarios', 'id')
                    ->where('empresaId', $empresaId),
            ],
            'nfe.destinatarioEnderecoId' => [
                'sometimes',
                'integer',
                Rule::exists('destinatario_enderecos', 'id')
                    ->where('destinatarioId', $this->input('nfe.destinatarioId')),
            ],
            'nfe.transportadoraId' => [
                'sometimes',
                'integer',
                Rule::exists('transportadoras', 'id')
                    ->where('empresaId', $empresaId),
            ],

        ];
    }
}
