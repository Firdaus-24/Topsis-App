<?php

namespace App\Imports;

use Throwable;
use App\Models\Gudangs;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithUpserts;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class GudangsImport implements ToModel,  WithValidation, SkipsOnFailure, WithUpserts, WithHeadingRow
{
    use Importable, SkipsFailures;
    /**
     
     * 
    
     */
    // public function collection(Collection $collection)
    // {
    //     $index = 1;
    //     $status = null;
    //     foreach ($collection as $row) {
    //         if ($index > 1) {
    //             if ($row[2] == 'GUDANG') {
    //                 $status = 1;
    //             } elseif ($row[2] == 'AGEN') {
    //                 $status =  2;
    //             } else {
    //                 $status = 3;
    //             };
    //             $data['nama'] = !empty($row[1]) ? $row[1] : '';
    //             $data['status_id'] = $status;
    //             $data['kota'] = !empty($row[3]) ? $row[3] : '';
    //             $data['kecamatan'] = !empty($row[4]) ? $row[4] : '';
    //             // $data['mulai_sewa'] = !empty($row[5]) ? $row[5] : '';
    //             $data['mulai_sewa'] = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[5]);
    //             $data['latitude'] = !empty($row[6]) ? $row[6] : '';
    //             $data['longitude'] = !empty($row[7]) ? $row[7] : '';
    //             $data['is_active'] = 1;

    //             Gudangs::create($data);
    //         }
    //         $index++;
    //     }
    // }
    // public function onError(Throwable $error)
    // {
    // }

    public function model(array $row)
    {

        if ($row['status_id'] == 'GUDANG') {
            $status =  1;
        } elseif ($row['status_id'] == 'AGEN') {
            $status =  2;
        } else {
            $status = 3;
        };
        return new Gudangs([
            'nama' => $row['nama'],
            'status_id' => $status,
            'kota' => $row['kota'],
            'kecamatan' => $row['kecamatan'],
            'mulai_sewa' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['mulai_sewa']),
            'latitude' => $row['latitude'],
            'longitude' => $row['longitude'],
            'is_active' => 1,
        ]);
    }
    public function uniqueBy()
    {
        return 'nama';
    }
    public function rules(): array
    {
        return [

            'nama' => 'required',
            'status_id' => 'required',
            'kota' => 'required',
            'kecamatan' => 'required',
            'mulai_sewa' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
        ];
    }

    public function customValidationMessages()
    {
        return ['nama' => 'nama sudah terdaftar'];
    }
}
