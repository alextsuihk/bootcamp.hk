<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CourseStoreUpdate extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        //return false;     // AT-PENDING: need to check use authorization
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
            //'number' => 'required|integer|between:100,999|unique:courses',
            'number' => 'sometimes|required|integer|between:100,999|unique:courses',
            'title' => 'required|max:50',
            'abstract' => 'required|min:20',
            'level_id' => 'required|integer',
            'is_active' => 'sometimes',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'number.required' => 'Course Number is required',
            'number.integer'  => 'Course Number must be 3-digit (between :min ~ :max)',
            'number.between'  => 'Course Number must be 3-digit (between :min ~ :max)',
            'title.required'  => 'A title is required',
            'abstract.required'  => 'An abstract is required',
            'level_id.integer'  => 'Please choose a difficulty level'
        ];
    }
}
