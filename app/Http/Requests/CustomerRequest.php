<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerRequest extends FormRequest
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
        $id = (int) $this->segment(3);
        $rules = [
            'name'                => 'required',
            'email'               => "required|unique:customers,email,{$id},id",
        ];

      return $rules;
    }

    public function messages()
    {
        return [
            'name.required'            => 'Please enter customer name !',
            'email.required'  => 'Please enter email address !',
            'email.email'                => 'This email already used',
        ];
    }
}
