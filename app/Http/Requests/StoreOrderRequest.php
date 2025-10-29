<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
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
            'tgl_order' => 'required|date',
            'no_order' => 'required|string|unique:orders,no_order',
            'id_vendor' => 'required|exists:vendors,id_vendor',
            'id_item' => 'required|exists:items,id_item',
            //
        ];
    }
}
