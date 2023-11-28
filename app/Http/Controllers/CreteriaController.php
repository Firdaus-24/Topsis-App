<?php

namespace App\Http\Controllers;

use App\Models\Creteria;
use Illuminate\Http\Request;
use App\Imports\CreteriaImport;
use App\Http\Requests\StoreCreteriaRequest;
use Excel;

class CreteriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Creteria::paginate(5);

        if (request('search-creteria')) {
            $data = Creteria::where('nama', 'like', '%' . request('search-creteria') . '%')->paginate(5);
        }

        return view('creteria.index')->with(['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('creteria.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCreteriaRequest $request)
    {
        $request->validated();
        Creteria::create([
            'nama' =>  strtoupper($request->txtnama),
            'type' =>  $request->txttype,
            'bobot' =>  $request->txtbobot,
        ]);

        return back()->with('success', 'data berhasil di simpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Creteria $creteria, $id)
    {
        return view('creteria.update')->with(['data' => Creteria::where('id', $id)->first()]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Creteria $creteria)
    {
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Creteria $creteria, $id)
    {
        $data = [
            'nama'  => $request->txtnama,
            'type' => $request->txttype,
            'bobot'  => $request->txtbobot
        ];

        Creteria::where('id', $id)->update($data);
        return back()->with('success', 'data berhasil di update');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Creteria $creteria, $id)
    {
        $data = Creteria::find($id);

        if ($data->is_active == 1) {
            $active = 0;
            $mg = "data berhasil di nonaktifkan";
        } else {
            $active = 1;
            $mg = "data berhasil di aktifkan";
        }

        Creteria::where('id', $id)
            ->update(['is_active' => $active]);


        return back()->with('success', $mg);
    }

    public function importCreteria(Request $request)
    {
        Excel::import(new CreteriaImport(), $request->file('file'));
        return back()->with('success', 'data berhasil di upload');
    }
}
