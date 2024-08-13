<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateImpostosRequest extends FormRequest
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
            'grupoImpostosId' => 'prohibited',
            'indicadorDestinoId' => 'prohibited',
            'cfopId' => 'sometimes|required|integer|exists:cfops,id',
            'aliqIcms' => 'sometimes|required|decimal:0,4',
            'aliqIcmst' => 'sometimes|required|decimal:0,4',
            'aliqIcmsCredito' => 'sometimes|required|decimal:0,4',
            'aliqIpi' => 'sometimes|required|decimal:0,4',
            'aliqPis' => 'sometimes|required|decimal:0,4',
            'aliqCofins' => 'sometimes|required|decimal:0,4',
            'aliqIss' => 'sometimes|required|decimal:0,4',
            'cstIcms' => 'sometimes|required|max_digits:3',
            'cstIpi' => 'sometimes|required|max_digits:3',
            'cstPis' => 'sometimes|required|max_digits:3',
            'cstCofins' => 'sometimes|required|max_digits:3',
            'enquadramentoIpi' => 'sometimes|required|max_digits:3',
            'origem' => 'sometimes|required|integer|max_digits:1',
        ];
    }
}
