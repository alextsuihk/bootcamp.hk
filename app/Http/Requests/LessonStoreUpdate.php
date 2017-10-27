<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LessonStoreUpdate extends FormRequest
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
            'venue' => 'nullable',
            'instructor' => 'nullable',
            'teaching_language_id' => 'required|integer',
            'first_day' => 'nullable|date',
            'last_day' => 'nullable|date',
            'schedule' => 'nullable',
            'active' => 'sometimes',
            'quota' => 'nullable|integer',
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
                // AT-Pending: to be developed
        ];
    }
}
