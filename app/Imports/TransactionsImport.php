<?php

namespace App\Imports;

use App\Models\Gudangs;
use App\Models\Creteria;
use App\Models\Transactions;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;

class TransactionsImport implements ToModel
{
    private $criteriaNames;

    public function __construct(array $criteriaNames)
    {
        $this->criteriaNames = $criteriaNames;
    }

    public function model(array $row)
    {
        $alternativeName = array_shift($row);

        $alternative = Gudangs::where('nama', $alternativeName)->first();

        if ($alternative) {
            $alternativeId = $alternative->id;

            $transactions = [];
            foreach ($this->criteriaNames as $index => $criteriaName) {

                $criteria = Creteria::where('nama', $criteriaName)->first();

                if ($criteria) {
                    $criteriaId = $criteria->id;
                    $value = $row[$index];

                    // Create a new Transaction instance
                    $transactions[] = new Transactions([
                        'gudangs_id' => $alternativeId,
                        'creterias_id' => $criteriaId,
                        'value' => $value,
                        'is_active' => 1,
                    ]);
                } else {
                    // Handle the case where the criteria is not found
                    Log::error("Criteria not found: $criteriaName");
                }
            }

            return $transactions;
        }

        return null;
    }
}
