<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ToursListRequest extends FormRequest
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

    public function rules(): array
    {
        return  [
            'priceFrom' => 'numeric',
            'priceTo' => 'numeric',
            'dateFrom' => 'date',
            'dateTo' => 'date',
            'sortBy' => Rule::in(['price_in_cents']),
            'sortOrder' => Rule::in(['asc', 'desc']),
        ];
    }

    public function messages(): array
    {
        return [
            'priceFrom' => "The 'priceFrom' accepts only numeric values.",
            'priceTo' => "The 'priceTo' accepts only numeric values.",
            'dateFrom' => "The 'dateFrom' accepts only date values.",
            'dateTo' => "The 'dateTo' accepts only date values.",
            'sortBy' => "The 'sortby' accepts only 'price'.",
            'sortOrder' => "The sort order accepts only 'asc' and 'desc'.",
        ];
    }
}
