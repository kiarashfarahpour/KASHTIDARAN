<?php

namespace App\Http\Requests;

use App\Models\Input;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ContactRequest extends FormRequest
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
        $rules      = [];
        $inputs     = array_keys(request('inputs') ?? []);
        $hasValue   = ['min', 'max', 'digits_between', 'starts_with', 'regex'];
        foreach ($inputs as $id) {
            $input = Input::find($id);
            $ruleValue  = array_combine($input->rules, $input->values);
            $rule = [];
            if($input->type == 'select') {
                foreach ($input->options as $option) {
                    $optionList[] = $option;
                }
                $rule[] = Rule::in($optionList);
            }
            foreach ($ruleValue as $r => $value) {
                $rule[] = $r . (in_array($r, $hasValue) ? ':' . $value : '');
            }
            $rules['inputs.' . $id] = $rule;
        }
        return $rules;
    }
}
