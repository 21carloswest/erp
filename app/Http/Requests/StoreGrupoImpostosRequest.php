<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreGrupoImpostosRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return TRUE;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'grupo.tipoId' => 'required|integer|exists:tipo_items,id',
            'grupo.name' => 'required|string|max:100',
            'impostos.estadual' => 'required|array',
            'impostos.interestadual'=> 'required|array',
            'impostos.exterior'=> 'required|array',
            'impostos.*.indicadorDestinoId' => 'required|integer|exists:indicador_destinos,id',
            'impostos.*.cfopId' => 'required|integer|exists:cfops,id',
            'impostos.*.aliqIcms' => 'required|decimal:0,4',
            'impostos.*.aliqIcmst' => 'required|decimal:0,4',
            'impostos.*.aliqIcmsCredito' => 'required|decimal:0,4',
            'impostos.*.aliqIpi' => 'required|decimal:0,4',
            'impostos.*.aliqPis' => 'required|decimal:0,4',
            'impostos.*.aliqCofins' => 'required|decimal:0,4',
            'impostos.*.aliqIss' => 'required|decimal:0,4',
            'impostos.*.cstIcms' => 'required|max_digits:3',
            'impostos.*.cstIpi' => 'required|max_digits:3',
            'impostos.*.cstPis' => 'required|max_digits:3',
            'impostos.*.cstCofins' => 'required|max_digits:3',
            'impostos.*.enquadramentoIpi' => 'required|max_digits:3',
            'impostos.*.origem' => 'required|integer|max_digits:1',
        ];
    }
}
