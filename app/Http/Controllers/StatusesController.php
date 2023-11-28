<?php

namespace App\Http\Controllers;

use App\Models\Statuses;
use Illuminate\Cache\Repository;
use Illuminate\Http\Request;

class StatusesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('statuses.index')->with(['data' => Statuses::all()]);
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
        $request->validate([
            'txtnama' => 'required|unique:statuses,status_nama|min:3|max:30'
        ]);


        Statuses::create([
            'status_nama' => strtoupper($request->txtnama)
        ]);

        return back()->with('success', 'data berhasil di simpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Statuses $statuses, $id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Statuses $statuses, $id)
    {
        $data = $statuses->findOrFail($id);
        return response()->json([
            'id' => $data->id,
            'nama' => $data->status_nama
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $data = Statuses::find($request->id);
        $request->validate([
            'txtnama' => 'required|unique:statuses,status_nama|min:3|max:30'
        ]);
        $data->status_nama = strtoupper($request->txtnama);

        $data->save();

        return back()->with('success', 'data berhasil di update');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Statuses $statuses, $id)
    {
        $msg = null;
        $data = Statuses::find($id);
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
