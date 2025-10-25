<?php

namespace StudentAdmission\Presentation\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCourseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', 'unique:courses,name'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'The course name field is required.',
            'name.string' => 'The course name must be a string.',
            'name.max' => 'The course name may not be greater than 255 characters.',
            'name.unique' => 'A course with this name already exists.',
        ];
    }
}
