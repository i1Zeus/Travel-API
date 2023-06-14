<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TravelRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'is_public' => 'boolean',
            'name' => ['required', 'max:100', 'unique:travels'],
            'description' => ['required'],
            'number_of_days' => ['required', 'integer'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'A name is required',
            'name.unique' => 'A name must be unique',
            'description.required' => 'A description is required',
            'number_of_days.required' => 'A number of days is required',
        ];
    }
}
