<?php

namespace App\Http\Controllers;

use App\Models\Alternatif;
use Illuminate\Http\Request;

class AlternatifController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data =  Alternatif::get();

        if (request('search-alternatif')) {
            $data = Alternatif::where('nama', 'LIKE', '%' . request('search-alternatif') . '%')->get();
        }

        return view('alternatifs.index', ['data' => $data]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Alternatif::create([
            'nama' => strtoupper($request->txtnama),
            'is_active' => 1
        ]);

        return back()->with('success', 'alternatif berhasil di tambahkan');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        Alternatif::where('id', $request->txtid)->update(['nama' => strtoupper($request->txtnama)]);

        return back()->with('success', 'data berhasil di update');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Alternatif $alternatif, $id)
    {
        $msg = null;
        $data = Alternatif::find($id);
        if ($data->is_active == 1) {
            $data->is_active = 0;
            $msg = "non active";
        } else {
            $data->is_active = 1;
            $msg = "active";
        }

        $data->save();

        return back()->with('success', 'data berhasil ' . $msg);
    }
}
