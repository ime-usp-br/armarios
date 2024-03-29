<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SolicitarEmprestimoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'numero' => [
                'required',
                'exists:armarios,id',
            ]
        ];
    }


    public function messages()
    {
        return [
            'numero.required' => 'Informe o número do armário.',
        ];
    }
}
