<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;


class UpdateOrderRequest extends FormRequest
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
            'tgl_order' => 'required|date_format:Y-m-d',
            'no_order' => 'required|string|unique:orders,no_order,' . $this->route('order') . ',id_order',
            'id_vendor' => 'required|exists:vendors,id_vendor',
            'id_item' => 'required|exists:items,id_item',
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
            'tgl_order.required' => 'Tanggal order harus diisi.',
            'tgl_order.date_format' => 'Format tanggal harus Y-m-d (YYYY-MM-DD).',
            'no_order.required' => 'Nomor order harus diisi.',
            'no_order.string' => 'Nomor order harus berupa teks.',
            'no_order.unique' => 'Nomor order sudah terdaftar.',
            'id_vendor.required' => 'ID vendor harus diisi.',
            'id_vendor.exists' => 'Vendor yang dipilih tidak ditemukan.',
            'id_item.required' => 'ID item harus diisi.',
            'id_item.exists' => 'Item yang dipilih tidak ditemukan.',
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
