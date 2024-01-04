<?php

namespace App\Http\Controllers;

use App\Models\Gudangs;
use App\Models\Statuses;
use Illuminate\Http\Request;
use App\Http\Requests\StoreGudangsRequest;
use App\Http\Requests\UpdateGudangsRequest;
use App\Imports\GudangsImport;
use Excel;
// use Maatwebsite\Excel\Facades\Excel::class;

class GudangsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $gudang = Gudangs::with('statuses')->orderBy('nama')->paginate(10);
        if (request('search-gudang')) {
            $gudang = Gudangs::where('nama', 'LIKE', '%' . request('search-gudang') . '%')->with('statuses')->orderBy('nama')->paginate(10);
        }

        return view('gudangs.index')->with(['data' => $gudang]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('gudangs.add')->with(['statuses' => Statuses::where('is_active', 1)->get()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGudangsRequest $request)
    {
        $request->validated();

        Gudangs::create([
            'nama' => strtoupper($request->txtnama),
            'status_id' => $request->status,
            'kota' => $request->txtkota,
            'kecamatan' => $request->txtkecamatan,
            'longitude' => $request->txtlong,
            'latitude' => $request->txtlat,
            'mulai_sewa' => $request->tglsewa,
            'is_active' => 1
        ]);




        return back()->with('success', 'data berhasil disimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Gudangs $gudangs, $id)
    {
        $data = $gudangs->find($id);

        return view('gudangs.update')->with([
            'txtid' => $data->id,
            'txtnama' => $data->nama,
            'txtstatus' => $data->status_id,
            'txtkota' => $data->kota,
            'txtkecamatan' =>  $data->kecamatan,
            'txtlong' =>  $data->longitude,
            'txtlat' =>  $data->latitude,
            'tglsewa' =>  $data->mulai_sewa,
            'statuses' => Statuses::where('is_active', 1)->get()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Gudangs $gudangs)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGudangsRequest $request, Gudangs $gudangs)
    {
        $data = Gudangs::find($request->txtid);

        $data->nama = strtoupper($request->txtnama);
        $data->status_id = $request->status;
        $data->kota = $request->txtkota;
        $data->kecamatan = $request->txtkecamatan;
        $data->longitude = $request->txtlong;
        $data->latitude = $request->txtlat;
        $data->mulai_sewa = $request->tglsewa;

        $data->save();


        return back()->with('success', 'data berhasil update');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Gudangs $gudangs, $id)
    {
        $data = Gudangs::find($id);
        if ($data->is_active == 1) {
            $active = 0;
        } else {
            $active = 1;
        }

        Gudangs::where('id', $id)
            ->update(['is_active' => $active]);


        return back()->with('success', 'data berhasil di non aktifkan');
    }


    public function importGudangs(Request $request)
    {
        $file = $request->file('file')->store('public/import');
        // $import = new GudangsImport;
        (new GudangsImport)->import($file, null, \Maatwebsite\Excel\Excel::XLSX);
        // $import->import($file);
        // Excel::import(new GudangsImport(), $request->file('file'));
        return back()->with('success', 'data berhasil di upload');
    }
}
