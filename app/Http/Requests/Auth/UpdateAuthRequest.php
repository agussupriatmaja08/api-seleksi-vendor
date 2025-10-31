<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class UpdateAuthRequest extends FormRequest
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

            'name' => 'sometimes|string|max:50|min:1',
            'email' => 'sometimes|email|unique:users,email,' . $this->route('user') . ',id',
            'password' => 'sometimes|string|min:8'
            //
        ];
    }

    /**
     * Custom messages 
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'name.string' => 'Nama harus berupa teks.',
            'name.max' => 'Nama maksimal :max karakter.',
            'name.min' => 'Nama minimal :min karakter.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.string' => 'Password harus berupa teks.',
            'password.min' => 'Password minimal :min karakter.',
        ];
    }
    /**
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     *
     * @throws \Illuminate\Http\Exceptions\HttpResponseException
     */
    protected function failedValidation(Validator $validator)
    {
        $result = (object) [
            'status' => false,
            'message' => 'Validation failed',
            'data' => $validator->errors(),
            'statusCode' => 422
        ];

        throw new HttpResponseException(
            response()->json([
                'status' => $result->status,
                'message' => $result->message,
                'data' => $result->data,
            ], $result->statusCode)
        );
    }
}
