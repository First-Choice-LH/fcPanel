<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeRequest extends FormRequest
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
                'first_name' => 'required|string',
                'last_name' => 'required|string'
            ];
        }else{
            $rules = [
                'first_name' => 'required|string',
                'last_name' => 'required|string',
                //'jobsite_id' => 'required',
            ];
        }

        return $rules;
    }
}
