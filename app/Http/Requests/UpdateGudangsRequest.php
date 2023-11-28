<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateGudangsRequest extends FormRequest
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
            'txtnama' => [
                'required',
                'min:3',
                'max:50',
                Rule::unique('gudangs', 'nama')->ignore($this->txtid, 'id')

            ],
            'status' => 'required',
            'txtkota' => 'required|min:5|max:50',
            'txtkecamatan' => 'required|min:5|max:50',
            'txtlong' => 'required|min:5|max:50',
            'txtlat' => 'required|min:5|max:50',
            'tglsewa' => 'required|date'

        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'txtnama.unique' => 'nama sudah terdaftar',
            'txtnama.min' => 'minimal 3 character',
            'txtnama.max' => 'maximal 50 character',
            'txtkota.required' => 'wajib diisi',
            'txtkota.min' => 'minimal 5 character',
            'txtkota.max' => 'minimal 50 character',
            'txtkecamatan.required' => 'wajib diisi',
            'txtkecamatan.min' => 'minimal 5 character',
            'txtkecamatan.max' => 'minimal 50 character',
            'txtlong.required' => 'wajib diisi',
            'txtlong.min' => 'minimal 5 character',
            'txtlong.max' => 'minimal 50 character',
            'txtlat.required' => 'wajib diisi',
            'txtlat.min' => 'minimal 5 character',
            'txtlat.max' => 'minimal 50 character',
            'tglsewa.date' => 'harus tanggal',
        ];
    }
}
