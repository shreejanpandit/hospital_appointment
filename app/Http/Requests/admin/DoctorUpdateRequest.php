<?php

namespace App\Http\Requests\admin;

use Illuminate\Foundation\Http\FormRequest;

class DoctorUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'contact' => 'required|string',
            'bio' => 'required|string|max:255',
            'department_id' => 'required|exists:departments,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ];
    }
}
