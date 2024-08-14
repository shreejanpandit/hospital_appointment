<?php

namespace App\Http\Requests\appointment;

use Illuminate\Foundation\Http\FormRequest;

class AppointmentStoreRequest extends FormRequest
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
    // AppointmentStoreRequest.php
    public function rules()
    {
        return [
            'patient_id' => 'required|integer|exists:patients,id',
            'doctor_id' => 'required|integer|exists:doctors,id',
            'description' => 'required|string|max:255',
            'date' => 'required|date|after_or_equal:today',
            'time' => 'required|date_format:H:i'
        ];
    }
}
