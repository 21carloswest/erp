<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateGrupoImpostosRequest extends FormRequest
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
            'grupo.tipoId' => 'prohibited',
            'grupo.empresaId' => 'prohibited',
            'grupo.name' => 'sometimes|required|string|max:100',

            'impostos.estadual' => 'sometimes|required|array',
            'impostos.interestadual' => 'sometimes|required|array',
            'impostos.exterior' => 'sometimes|required|array',

            'impostos.*.grupoImpostosId' => 'prohibited',
            'impostos.*.indicadorDestinoId' => 'prohibited',

            'impostos.*.id' => 'required_with:impostos.*',
            'impostos.*.cfopId' => 'sometimes|required|integer|exists:cfops,id',
            'impostos.*.aliqIcms' => 'sometimes|required|decimal:0,4',
            'impostos.*.aliqIcmst' => 'sometimes|required|decimal:0,4',
            'impostos.*.aliqIcmsCredito' => 'sometimes|required|decimal:0,4',
            'impostos.*.aliqIpi' => 'sometimes|required|decimal:0,4',
            'impostos.*.aliqPis' => 'sometimes|required|decimal:0,4',
            'impostos.*.aliqCofins' => 'sometimes|required|decimal:0,4',
            'impostos.*.aliqIss' => 'sometimes|required|decimal:0,4',
            'impostos.*.cstIcms' => 'sometimes|required|max_digits:3',
            'impostos.*.cstIpi' => 'sometimes|required|max_digits:3',
            'impostos.*.cstPis' => 'sometimes|required|max_digits:3',
            'impostos.*.cstCofins' => 'sometimes|required|max_digits:3',
            'impostos.*.enquadramentoIpi' => 'sometimes|required|max_digits:3',
            'impostos.*.origem' => 'sometimes|required|integer|max_digits:1',
        ];
    }
}
