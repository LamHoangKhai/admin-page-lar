<?php

namespace App\Http\Requests\Admin\User;

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
            "email" => "required|unique:users,email",
            "password" => "required|min:6",
            "confirmation_password" => "required|same:password",
            "phone" => "required"
            //
        ];
    }
    public function messages()
    {
        return [
            "email.required" => "Vui lòng nhập email",
            "email.unique" => "Email đã tồn tại",
            "password.required" => "Vui lòng nhập password",
            "password.min" => "Password toi thieu 6 ky tu",
            "confirmation_password.same" => "Password confirmation không giống nhau",
            "confirmation_password.required" => "Vui lòng nhập password confirm",
            "phone.required" => "Vui lòng nhập số điện thoại"
        ];
    }
}
