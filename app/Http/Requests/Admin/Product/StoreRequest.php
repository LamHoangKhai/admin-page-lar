<?php

namespace App\Http\Requests\Admin\Product;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            "name" => "required|unique:products,name",
            "price" => "required|numeric",


        ];
    }
    public function messages()
    {
        return [
            "name.required" => "Vui lòng nhập tên product",
            "name.unique" => "Tên sản phẩm đã tồn tại",
            "price.required" => "Vui lòng nhập giá",
            "price.numeric" => "Vui lòng nhập số",
        ];
    }
}
