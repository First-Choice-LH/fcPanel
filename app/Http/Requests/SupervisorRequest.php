<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SupervisorRequest extends FormRequest
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
        if(empty($this->id)){
            $rules = [
                'client_id' => 'required',
                //'jobsite_id' => 'required',
                'first_name' => 'required|string',
                'last_name' => 'required|string',
                // 'username' => 'required|string|unique:users',
                // 'password' => 'min:6',
                // 'repassword' => 'required_with:password|same:password|min:6'
            ];
        }else{
            $rules = [
                'client_id' => 'required',
                'first_name' => 'required|string',
                'last_name' => 'required|string'
            ];
        }
        return $rules;
    }

    public function messages(){
        return [
            'client_id.required' => 'Company is required',
            'jobsite_id.required' => 'Jobsite is required'
        ];
    }
}
