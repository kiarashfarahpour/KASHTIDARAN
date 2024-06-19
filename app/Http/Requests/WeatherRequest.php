<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WeatherRequest extends FormRequest
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
            'name'          => 'required|max:191',
            'status'        => 'nullable|in:0,1',
        ];
        switch ($this->method()) {
            case 'POST':
                $rules['slug']          =  'required|max:191|alpha_dash|unique:weather';
                break;
            case 'PATCH':
            case 'PUT':
                $rules['slug']          = 'required|max:191|alpha_dash|unique:weather,id,' . $this->id;
                break;
        }
        return $rules;
    }
}
