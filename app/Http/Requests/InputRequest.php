<?php

namespace App\Http\Requests;

use App\Rules\ValidRule;
use Illuminate\Foundation\Http\FormRequest;

class InputRequest extends FormRequest
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
            'label'         => 'required|string|max:191',
            'type'          => 'required|in:text,select,checkbox,textarea',
            'placeholder'   => 'nullable|string|max:191',
            'rules.*'       => [
                new ValidRule,
                'required_with:rules.*'
            ],
            'values.*'      => '',
            'options.*'     => 'nullable',
            'sort_order'    => 'nullable|numeric|min:0',
        ];
    }
}
