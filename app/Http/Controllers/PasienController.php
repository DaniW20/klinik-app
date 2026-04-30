<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PasienController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->search;

        $data = \App\Models\Pasien::when($search, function ($query, $search) {
            return $query->where('nama', 'like', "%$search%");
        })->paginate(5)->withQueryString();

        return view('pasien.index', compact('data', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
            return view('pasien.create');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
        'nama' => 'required',
        'alamat' => 'required',
        'no_hp' => 'required',
        'tanggal_lahir' => 'required|date'

        
    ]);

    \App\Models\Pasien::create($request->all());

    return redirect('/pasien')->with('success', 'Data berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $pasien = \App\Models\Pasien::findOrFail($id);
        return view('pasien.edit', compact('pasien'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required',
            'alamat' => 'required',
            'no_hp' => 'required',
            'tanggal_lahir' => 'required|date'
        ]);

        $pasien = \App\Models\Pasien::findOrFail($id);
        $pasien->update($request->all());

        return redirect('/pasien')->with('success', 'Data berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $pasien = \App\Models\Pasien::findOrFail($id);
        $pasien->delete();

        return redirect('/pasien')->with('success', 'Data berhasil dihapus');
    }
}
