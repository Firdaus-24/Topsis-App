<?php

namespace App\Imports;

use App\Models\Creteria;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class CreteriaImport implements ToCollection
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        $index = 1;
        foreach ($collection as $row) {
            if ($index > 1) {
                $data['nama'] = strtoupper($row[0]);
                $data['type'] = strtoupper($row[1]);
                $data['bobot'] = $row[2];
                $data['is_active'] = 1;

                Creteria::create($data);
            }
            $index++;
        }
    }
}
