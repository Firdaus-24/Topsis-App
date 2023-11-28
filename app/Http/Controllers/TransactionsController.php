<?php

namespace App\Http\Controllers;

// use Excel;
use App\Models\Gudangs;
use App\Models\Creteria;
use App\Models\Transactions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Imports\TransactionsImport;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class TransactionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Transactions::paginate(10);

        if (request('search-trans')) {
            $data = Transactions::whereHas('gudangs', function ($query) {
                $query->where('nama', 'like', '%' . request('search-trans') . '%');
            })->paginate(10);
        }

        return view('transaksi.index')->with(['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Transactions $transactions)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transactions $transactions, $id)
    {
        $data = Transactions::find($id);
        $gudang = Gudangs::where('is_active', 1)->get();
        $creteria = Creteria::where('is_active', 1)->get();
        return view('transaksi.update')->with(['data' => $data, 'creteria' => $creteria, 'gudang' => $gudang]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transactions $transactions)
    {
        $data = Transactions::find($request->id);
        $data->gudangs_id = $request->txtgudangid;
        $data->creterias_id = $request->txtcreteria;
        $data->value = $request->txtvalue;

        $data->save();

        return back()->with('success', 'data berhasil di update');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transactions $transactions, $id)
    {
        $data = Transactions::find($id);
        if ($data->is_active == 1) {
            $active = 0;
            $msg = 'data berhasil di nonaktifkan';
        } else {
            $active = 1;
            $msg = 'data berhasil di aktifkan';
        }

        Transactions::where('id', $id)
            ->update(['is_active' => $active]);


        return back()->with('success', $msg);
    }
    public function importTransaksi(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx',
        ]);

        $file = $request->file('file');
        try {
            $headerRow = Excel::toArray([], $file)[0][0];
            $import = new TransactionsImport(array_slice($headerRow, 1)); // Exclude the first column (Name)

            Excel::import($import, $file);

            return redirect()->back()->with('success', 'Data imported successfully.');
        } catch (\Exception $e) {

            Log::error($e);

            return redirect()->back()->with('error', 'Error importing data. Check the log for details.');
        }
    }

    public function topsis()
    {
        $criterias = Creteria::all();

        //matrix awal
        $matrix = $this->Matrix();
        // Step 1: Normalize the Decision Matrix
        $normalizedMatrix = $this->normalizeDecisionMatrix();
        // Step 2: Determine Weighted Normalized Decision Matrix
        $weightedMatrix = $this->calculateWeightedMatrix($normalizedMatrix);

        // Step 3: Determine Ideal and Negative-Ideal Solutions
        $idealSolution = $this->calculateIdealSolution($weightedMatrix);
        // dd($idealSolution);
        // Step 4: Calculate Separation Measures
        $distances = $this->calculateDistances($idealSolution);
        // dd($distances);

        // Step 5: Calculate Relative Closeness to the Ideal Solution
        $resultPreference = $this->calculatePreference($distances);

        // Step 6: Rank the Alternatives
        $rankedAlternatives = $this->rankAlternatives($resultPreference);

        // Step 7: Pass the results to a view
        return view(
            'topsis-results',
            compact([
                'matrix',
                'normalizedMatrix',
                'weightedMatrix',
                'idealSolution',
                'distances',
                'resultPreference',
                'rankedAlternatives',
                'criterias'
            ])
        );
    }
    private function Matrix()
    {
        $alternatives = Gudangs::all();
        // dd($alternatives);
        $criteriaNames = Creteria::pluck('nama');
        $Matrix = [];

        foreach ($alternatives as $alternative) {
            $normalizedRow = [];
            // dd($alternative->initials);
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
                'nama' => $alternative->nama,
                'values' => $normalizedRow,
            ];
        }
        // dd($Matrix);
        return $Matrix;
    }

    private function normalizeDecisionMatrix()
    {
        // Retrieve all alternatives
        $alternatives = Gudangs::all();
        $criteriaNames = Creteria::pluck('nama');
        $normalizedMatrix = [];
        $divisors = []; // Array to store divisors for each criterion

        foreach ($criteriaNames as $criteriaName) {
            // Calculate the sum of squared values for each criterion
            $sumOfSquares = Transactions::whereHas('creteria', function ($query) use ($criteriaName) {
                $query->where('nama', $criteriaName);
            })->sum(DB::raw('POWER(value, 2)'));

            // Calculate the divisor as the square root of the sum of squares
            $divisor = sqrt($sumOfSquares);
            // Format the divisor with three decimal places
            // $formattedDivisor = round($divisor, 2);
            $formattedDivisor = number_format(round($divisor, 2), 2, '.', '');

            $divisors[$criteriaName] = $formattedDivisor;
        }

        // Calculate the sum of divisors squared
        $sumOfDivisorsSquared = array_reduce($divisors, function ($carry, $divisor) {
            return $carry + pow($divisor, 2);
        }, 0);

        $sumOfDivisorsSquared = sqrt($sumOfDivisorsSquared);

        // dd($divisors, $sumOfDivisorsSquared);
        foreach ($alternatives as $alternative) {
            $normalizedRow = [];

            foreach ($criteriaNames as $criteriaName) {
                $value = Transactions::where('gudangs_id', $alternative->id)
                    ->whereHas('creteria', function ($query) use ($criteriaName) {
                        $query->where('nama', $criteriaName);
                    })
                    ->value('value');

                // Normalize the value by dividing it with the corresponding divisor
                $normalizedValue = $divisors[$criteriaName] !== 0 ? $value / $divisors[$criteriaName] : 0;
                // $formattedValue = round($normalizedValue, 3);
                $formattedValue = number_format(round($normalizedValue, 3), 3, '.', '');

                $normalizedRow[] = $formattedValue;
            }

            $normalizedMatrix[$alternative->id] = [
                'id' => $alternative->id,
                'nama' => $alternative->nama,
                'values' => $normalizedRow,
            ];
        }
        // dd($normalizedMatrix);
        return $normalizedMatrix;
    }

    // Step 2: Determine Weighted Normalized Decision Matrix
    private function calculateWeightedMatrix($normalizedMatrix)
    {
        $weightedMatrix = [];

        foreach ($normalizedMatrix as $alternativeId => $alternativeData) {
            $weightedRow = [];

            // Extract id, name, and values from alternativeData
            $id = $alternativeData['id'];
            $name = $alternativeData['nama'];
            $values = $alternativeData['values'];

            $criteriaWeights = Creteria::all()->toArray();

            // Calculate the weighted values
            // dd($values);
            foreach ($values as $index => $normalizedValue) {
                // dd($criteriaWeights[$index]['bobot']);
                $weightedValue = number_format($normalizedValue * $criteriaWeights[$index]['bobot'], 3, '.', '');
                // $weightedRow[] = $weightedValue;
                $weightedRow[] = [
                    'criteria_id' => $criteriaWeights[$index]['id'],
                    'type' => $criteriaWeights[$index]['type'],
                    'value' => $weightedValue,
                ];
            }

            $weightedMatrix[$id] = [
                'id' => $id,
                'nama' => $name,
                'values' => $weightedRow,
            ];
        }
        // dd($weightedMatrix);
        return $weightedMatrix;
    }

    private function calculateIdealSolution($weightedMatrix)
    {
        $criterias = Creteria::all();
        $values = [];

        foreach ($weightedMatrix as $row) {
            // dd($row['values']);
            $id = $row['id'];
            foreach ($criterias as $criteria) {
                // dd($criteria[]);

                foreach ($row['values'] as $data) {
                    # code...
                    // dd($criteria['id'] == $data['criteria_id']);
                    if ($criteria['id'] == $data['criteria_id']) {

                        // dd($data['value']);
                        $weightedValue[$criteria['id']] =  [
                            'criteria_id' => $criteria['id'],
                            'nama' => $criteria['nama'],
                            'type' => $criteria['type'],
                            'value' => number_format($criteria['bobot'] * $data['value'], 3, '.', ',')
                            // round($criteria['bobot'] * $data['value'], 3)
                            // number_format($criteria['bobot'] * $data['value'], 3, '.', ',')
                        ];
                    }
                }
            }
            $values[$id] = [
                'id' => $id,
                'nama' => $row['nama'],
                'values' => $weightedValue,
            ];
        }
        // dd(json_encode($values));
        $maxValues = [];
        $minValues = [];

        foreach ($values as $item) {
            foreach ($item['values'] as $criteria) {
                $criteriaId = $criteria['criteria_id'];
                $value = floatval($criteria['value']);

                if ($criteria['type'] == 'BENEFIT') {
                    $maxValues[$criteriaId] = isset($maxValues[$criteriaId])
                        ? max($maxValues[$criteriaId], number_format($value, 3, '.', ','))
                        : number_format($value, 3, '.', ',');

                    $minValues[$criteriaId] = isset($minValues[$criteriaId])
                        ? min($minValues[$criteriaId], number_format($value, 3, '.', ','))
                        : number_format($value, 3, '.', ',');
                } elseif ($criteria['type'] == 'COST') {
                    $maxValues[$criteriaId] = isset($maxValues[$criteriaId])
                        ? min($maxValues[$criteriaId], number_format($value, 3, '.', ','))
                        : number_format($value, 3, '.', ',');

                    $minValues[$criteriaId] = isset($minValues[$criteriaId])
                        ? max($minValues[$criteriaId], number_format($value, 3, '.', ','))
                        : number_format($value, 3, '.', ',');
                }
            }
        }
        foreach ($maxValues as $maxValue) {
            $maxValue = number_format($maxValue,  3, '.', ',');
        }

        foreach ($minValues as $minValue) {
            $minValue =  number_format($minValue,  3, '.', ',');
        }



        return [
            'MAX' => $maxValues,
            'MIN' => $minValues,
            'MatrixIdealSolutions' => $values
        ];
    }

    // Step 4: Calculate Separation Measures
    private function calculateDistances($idealSolution)
    {
        $MaxtrixD_Positive = [];
        $MaxtrixD_Negative = [];
        // dd($idealSolution['MAX']);
        $max = $idealSolution['MAX'];
        $min = $idealSolution['MIN'];
        $matrix = $idealSolution['MatrixIdealSolutions'];
        $newValuesMax = [];
        $newValuesMin = [];
        $DMax = [];
        $DMin = [];
        // Round the values to three decimal places
        foreach ($max as &$maxValue) {
            $maxValue = round($maxValue, 3);
        }

        foreach ($min as &$minValue) {
            $minValue = round($minValue, 3);
        }
        //matrix ideal positif
        foreach ($matrix as $item) {
            $sumValues = 0;
            foreach ($item['values'] as $criteria) {
                $criteriaId = $criteria['criteria_id'];
                $value = floatval($criteria['value']);

                // Calculate the new value based on the provided formula
                $newValue = pow(($value - $max[$criteriaId]), 2);

                // Store the new value in the $newValuesMax array
                $newValuesMax[$criteriaId] =  [
                    'creterias_id' => $criteriaId,
                    'value' => number_format($newValue, 3, '.', ',')
                    // round($criteria['weight'] * $data['value'], 3)
                ];

                $sumValues += floatval($newValue);
            }
            $MaxtrixD_Positive[$item['id']] = [
                'id' => $item['id'],
                'nama' => $item['nama'],
                'dataMatrix' => $newValuesMax,
                'dPositive' => number_format(sqrt($sumValues), 3, '.', ',')
            ];
            $DMax[$item['id']] = [
                'alternative_id' => $item['id'],
                'nama' => $item['nama'],
                'values' => number_format(sqrt($sumValues), 3, '.', ',')
            ];
        }

        //matrix ideal Negative
        foreach ($matrix as $item) {
            $sumValues = 0;
            foreach ($item['values'] as $criteria) {
                $criteriaId = $criteria['criteria_id'];
                $value = floatval($criteria['value']);

                // Calculate the new value based on the provided formula
                $newValue = pow(($value - $min[$criteriaId]), 2);

                // Store the new value in the $newValuesMin array
                $newValuesMin[$criteriaId] =  [
                    'criteria_id' => $criteriaId,
                    'value' => number_format($newValue, 3, '.', ',')
                    // round($criteria['weight'] * $data['value'], 3)
                ];

                $sumValues += floatval($newValue);
            }
            $MaxtrixD_Negative[$item['id']] = [
                'id' => $item['id'],
                'name' => $item['nama'],
                'dataMatrix' => $newValuesMin,
                'dNegative' => number_format(sqrt($sumValues), 3, '.', ',')
            ];
            $DMin[$item['id']] = [
                'alternative_id' => $item['id'],
                'name' => $item['nama'],
                'values' => number_format(sqrt($sumValues), 3, '.', ',')
            ];
        }
        // dd($DMax,$DMin);
        return [
            'DMax' => $DMax,
            'DMin' => $DMin,
            'DistancePositive' => $MaxtrixD_Positive,
            'DistanceNegative' => $MaxtrixD_Negative,
        ];
        return $MaxtrixD_Positive;
    }


    // Step 5: Calculate Relative Closeness to the Ideal Solution
    private function calculatePreference($distances)
    {

        $alternatives = Gudangs::all();
        $DPositiveValues = $distances['DMax'];
        $DNegativeValues = $distances['DMin'];
        // dd($DPositiveValues);
        $results = [];
        foreach ($alternatives as $alternative) {
            $alternativeId = $alternative->id;
            $positiveValue = $DPositiveValues[$alternativeId]['values'] ?? 0;
            // dd($DPositiveValues[$alternativeId]);
            $negativeValue = $DNegativeValues[$alternativeId]['values'] ?? 0;

            // Avoid division by zero
            $totalValue = ($positiveValue + $negativeValue) > 0 ? ($negativeValue / ($positiveValue + $negativeValue)) : 0;

            $results[] = [
                'id' => $alternativeId,
                'nama' => $alternative->nama,
                'DPositive_value' => $positiveValue,
                'DNegative_value' => $negativeValue,
                'result' => number_format($totalValue, 3, '.', ','),
            ];
        }

        // dd($results);

        // Return the calculated closeness values
        return $results;
    }


    // Step 6: Rank the Alternatives
    private function rankAlternatives($resultPreference)
    {
        // Sort results by the 'result' key in descending order
        usort($resultPreference, function ($a, $b) {
            return $b['result'] <=> $a['result'];
        });

        // Add rank
        $rank = 1;
        foreach ($resultPreference as &$result) {
            $result['rank'] = $rank++;
        }
        // dd($resultPreference);
        return $resultPreference;
    }
}
