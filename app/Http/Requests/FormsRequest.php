<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FormsRequest extends FormRequest
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
        $rules = [
            'name'          => 'required|max:191|string',
            'authenticated' => 'nullable|in:0,1',
        ];
        switch ($this->method()) {
            case 'POST':
                break;
            case 'PATCH':
            case 'PUT':
                break;
        }
        return $rules;
    }
}
