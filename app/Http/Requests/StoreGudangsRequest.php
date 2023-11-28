<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreGudangsRequest extends FormRequest
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
            'txtnama' => 'required|unique:gudangs,nama|min:3|max:50',
            'status' => 'required',
            'txtkota' => 'required|unique:gudangs,kota|min:5|max:50',
            'txtkecamatan' => 'required|unique:gudangs,kecamatan|min:5|max:50',
            'txtlong' => 'required|unique:gudangs,longitude|min:5|max:50',
            'txtlat' => 'required|unique:gudangs,latitude|min:5|max:50',
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
