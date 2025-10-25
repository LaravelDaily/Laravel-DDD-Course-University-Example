<?php

namespace StudentAdmission\Presentation\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubmitApplicationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'student_name' => ['required', 'string', 'max:255'],
            'expires_at' => ['nullable', 'date'],
            'entry_exam_score' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ];
    }

    public function messages(): array
    {
        return [
            'student_name.required' => 'The student name field is required.',
            'student_name.string' => 'The student name must be a string.',
            'student_name.max' => 'The student name may not be greater than 255 characters.',
            'expires_at.date' => 'The expiration date must be a valid date.',
            'entry_exam_score.numeric' => 'The entry exam score must be a number.',
            'entry_exam_score.min' => 'The entry exam score must be at least 0.',
            'entry_exam_score.max' => 'The entry exam score may not be greater than 100.',
            'notes.string' => 'The notes must be a string.',
            'notes.max' => 'The notes may not be greater than 1000 characters.',
        ];
    }
}
