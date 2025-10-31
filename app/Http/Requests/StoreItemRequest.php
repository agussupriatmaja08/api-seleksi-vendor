<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;


class StoreItemRequest extends FormRequest
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
            'kode_item' => 'required|string|unique:items,kode_item',
            'nama_item' => 'required|string|max:255',
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
            'kode_item.required' => 'Kode item harus diisi.',
            'kode_item.string' => 'Kode item harus berupa teks.',
            'kode_item.unique' => 'Kode item sudah terdaftar.',
            'nama_item.required' => 'Nama item harus diisi.',
            'nama_item.string' => 'Nama item harus berupa teks.',
            'nama_item.max' => 'Nama item maksimal :max karakter.',
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