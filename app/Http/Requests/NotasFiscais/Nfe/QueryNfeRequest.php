<?php

namespace App\Http\Requests\NotasFiscais\Nfe;

use Illuminate\Foundation\Http\FormRequest;

class QueryNfeRequest extends FormRequest
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
            'ambiente' => 'required|in:0,1'
        ];
    }
}
