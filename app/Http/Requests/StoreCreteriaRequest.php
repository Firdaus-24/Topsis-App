<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCreteriaRequest extends FormRequest
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
            'txtnama' => 'required|unique:creterias,nama|min:3|max:50',
            'txttype' => 'required|in:COST,BENEFIT',
            'txtbobot' => 'required|numeric|min:1',
        ];
    }
    public function messages(): array
    {
        return [
            'txtnama.unique' => 'nama sudah terdaftar',
            'txtnama.min' => 'minimal 3 character',
            'txtnama.max' => 'maximal 50 character',
            'txttype.required' => 'wajib diisi',
            'txtbobot.required' => 'wajib diisi',
            'txtbobot.numeric' => 'harus angka',
            'txtbobot.min' => 'minimal 1 angka',
        ];
    }
}
