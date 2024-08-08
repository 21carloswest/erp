<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateConfiguracaoRequest extends FormRequest
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
            'empresaId' => 'prohibited',
            'ambiente' => 'sometimes|required|integer|in:0,1', //0 producao 1 homologacao
            'habilitaNfe' => 'sometimes|required|boolean',
            'habilitaNfce' => 'sometimes|required|boolean',
            'habilitaNfse' => 'sometimes|required|boolean',
            'proxNfe' => 'sometimes|required|integer|min:0',
            'proxNfce'=> 'sometimes|required|integer|min:0',
            'proxNfse'=> 'sometimes|required|integer|min:0',
            'serieNfe'=> 'sometimes|required|integer|min:0',
            'serieNfce'=> 'sometimes|required|integer|min:0',
            'serieNfse'=> 'sometimes|required|integer|min:0',
        ];
    }
}
