<?php

namespace App\Http\Requests\Products;

use App\Enums\Attributes;
use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
            Attributes::NAME => 'required|unique:products,'.Attributes::NAME.'|max:255',
            Attributes::DESCRIPTION => 'nullable|max:500',
            Attributes::QUANTITY => 'required|integer',
            Attributes::CATEGORY_ID => 'required|exists:categories,id',
        ];
    }
}
