<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TimesheetRequest extends FormRequest
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
            'employee_id' => 'required',
            'jobsite_id' => 'required',
            'date.*' => 'required|date',
            'start.*' => 'required|date_format:"h:i A"',
            'end.*' => 'required|date_format:"h:i A"'
        ];
    }
}
