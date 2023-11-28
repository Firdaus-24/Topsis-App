<?php

namespace App\Imports;

use App\Models\Gudangs;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class GudangsImport implements ToCollection
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        $index = 1;
        $status = null;
        foreach ($collection as $row) {
            if ($index > 1) {
                if ($row[2] == 'GUDANG') {
                    $status = 1;
                } elseif ($row[2] == 'AGEN') {
                    $status =  2;
                } else {
                    $status = 3;
                };
                $data['nama'] = !empty($row[1]) ? $row[1] : '';
                $data['status_id'] = $status;
                $data['kota'] = !empty($row[3]) ? $row[3] : '';
                $data['kecamatan'] = !empty($row[4]) ? $row[4] : '';
                // $data['mulai_sewa'] = !empty($row[5]) ? $row[5] : '';
                $data['mulai_sewa'] = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[5]);
                $data['latitude'] = !empty($row[6]) ? $row[6] : '';
                $data['longitude'] = !empty($row[7]) ? $row[7] : '';
                $data['is_active'] = 1;
                // dd($data);
                Gudangs::create($data);
            }
            $index++;
        }
    }
}
