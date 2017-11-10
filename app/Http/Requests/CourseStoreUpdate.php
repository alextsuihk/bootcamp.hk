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
            'number' => 'sometimes|size:3|required|unique:courses',        // when edit-update, $request->number not exist
            'title' => 'required|max:50',
            'sub_title' => 'sometimes|max:100',
            'abstract' => 'required|min:20',
            'level_id' => 'required|integer',
            'active' => 'sometimes',
            'delete' => 'sometimes',
            'remark' => 'sometimes',
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
