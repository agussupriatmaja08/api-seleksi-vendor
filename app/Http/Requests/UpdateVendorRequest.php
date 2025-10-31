<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;


class UpdateVendorRequest extends FormRequest
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

            'kode_vendor' => 'required|string|max:255|unique:vendors,kode_vendor,' . $this->route('vendor') . ',id_vendor',
            'nama_vendor' => 'required|string|max:255',
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
            'kode_vendor.required' => 'Kode vendor harus diisi.',
            'kode_vendor.string' => 'Kode vendor harus berupa teks.',
            'kode_vendor.unique' => 'Kode vendor sudah terdaftar.',
            'kode_vendor.max' => 'Kode vendor maksimal :max karakter.',
            'nama_vendor.required' => 'Nama vendor harus diisi.',
            'nama_vendor.string' => 'Nama vendor harus berupa teks.',
            'nama_vendor.max' => 'Nama vendor maksimal :max karakter.',
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
