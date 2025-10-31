<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;


class UpdateVendorItemRequest extends FormRequest
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
            'id_vendor' => 'required|exists:vendors,id_vendor',
            'id_item' => 'required|exists:items,id_item',
            'harga_sebelum' => 'required|numeric|min:0',
            'harga_sekarang' => 'required|numeric|min:0',


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
            'id_vendor.required' => 'ID vendor harus diisi.',
            'id_vendor.exists' => 'Vendor yang dipilih tidak ditemukan.',
            'id_item.required' => 'ID item harus diisi.',
            'id_item.exists' => 'Item yang dipilih tidak ditemukan.',
            'harga_sebelum.required' => 'Harga sebelum harus diisi.',
            'harga_sebelum.numeric' => 'Harga sebelum harus berupa angka.',
            'harga_sebelum.min' => 'Harga sebelum tidak boleh kurang dari :min.',
            'harga_sekarang.required' => 'Harga sekarang harus diisi.',
            'harga_sekarang.numeric' => 'Harga sekarang harus berupa angka.',
            'harga_sekarang.min' => 'Harga sekarang tidak boleh kurang dari :min.',
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
