<?php

namespace App\Exports;

use App\Models\Creteria;
use App\Models\Transactions;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;

class TransactionsExport implements FromCollection
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $alternatives = DB::table('gudangs')->where('is_active', '=', 1)->get();
        $criteriaNames = Creteria::pluck('nama');
        $Matrix = [];

        foreach ($alternatives as $alternative) {
            $normalizedRow = [];
            foreach ($criteriaNames as $criteriaName) {
                $value = Transactions::where('gudangs_id', $alternative->id)
                    ->whereHas('creteria', function ($query) use ($criteriaName) {
                        $query->where('nama', $criteriaName);
                    })
                    ->value('value');

                $normalizedRow[] = $value;
            }

            $Matrix[$alternative->id] = [
                'id' => $alternative->id,
                'name' => $alternative->nama,
                'values' => $normalizedRow,
            ];
        }
        return $Matrix;
    }
}
