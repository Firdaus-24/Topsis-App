<?php

namespace App\Http\Controllers;

// use Excel;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Transactions;
use Illuminate\Http\Request;
use App\Imports\TransactionsImport;
use App\Models\Creteria;
use App\Models\Gudangs;
use Illuminate\Support\Facades\Log;

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
}
