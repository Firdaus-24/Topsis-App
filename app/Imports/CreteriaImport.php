<?php

namespace App\Imports;

use App\Models\Creteria;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithUpserts;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class CreteriaImport implements ToModel,  WithValidation, SkipsOnFailure, WithUpserts, WithHeadingRow
{
    use Importable, SkipsFailures;
    /**
    
     */
    // public function collection(Collection $collection)
    // {
    //     $index = 1;
    //     foreach ($collection as $row) {
    //         if ($index > 1) {
    //             $data['nama'] = strtoupper($row[0]);
    //             $data['type'] = strtoupper($row[1]);
    //             $data['bobot'] = $row[2];
    //             $data['is_active'] = 1;

    //             Creteria::create($data);
    //         }
    //         $index++;
    //     }
    // }
    public function model(array $row)
    {

        return new Creteria([
            'nama' => strtoupper($row['nama']),
            'type' => strtoupper($row['type']),
            'bobot' => $row['bobot'],
            'is_active' => 1,
        ]);
    }
    public function uniqueBy()
    {
        return strtoupper('nama');
    }
    public function rules(): array
    {
        return [
            'nama' => 'required|unique:creterias,nama',
            'type' => 'required',
            'bobot' => 'required',
        ];
    }

    public function customValidationMessages()
    {
        return ['nama' => 'nama criteria sudah terdaftar'];
    }
}
