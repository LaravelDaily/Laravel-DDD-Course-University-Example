<?php

namespace StudentAdmission\Presentation\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStudentCoursesRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'courses' => ['nullable', 'array'],
            'courses.*' => ['integer', 'exists:courses,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'courses.*.exists' => 'One or more selected courses do not exist.',
        ];
    }
}
