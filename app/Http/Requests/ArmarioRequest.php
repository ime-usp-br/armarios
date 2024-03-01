<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArmarioRequest extends FormRequest
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
            'numero_inicial' => 'required|numeric',
            'numero_final' => 'nullable|numeric|min:' . $this->input('numero_inicial'),
        ];
    }


    public function messages()
    {
        return [
            'numero_inicial.required' => 'O número inicial é obrigatório.',
            'numero_inicial.numeric' => 'O número inicial deve ser um valor numérico.',
            'numero_final.numeric' => 'O número final deve ser um valor numérico.',
            'numero_final.min' => 'O número final deve ser maior que o número inicial.',
        ];
    }
}
