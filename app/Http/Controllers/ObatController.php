<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ObatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->search;

        $data = \App\Models\Obat::when($search, function ($query, $search) {
            return $query->where('nama_obat', 'like', "%$search%");
        })->paginate(5)->withQueryString();

        return view('obat.index', compact('data', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('obat.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_obat' => 'required',
            'stok' => 'required|integer',
            'harga' => 'required|integer'
        ]);

        \App\Models\Obat::create($request->all());

        return redirect('/obat')->with('success', 'Data obat berhasil ditambahkan');
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
        $obat = \App\Models\Obat::findOrFail($id);
        return view('obat.edit', compact('obat'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_obat' => 'required',
            'stok' => 'required|integer',
            'harga' => 'required|integer'
        ]);

        $obat = \App\Models\Obat::findOrFail($id);
        $obat->update($request->all());

        return redirect('/obat')->with('success', 'Data obat berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
   public function destroy($id)
    {
        $obat = \App\Models\Obat::findOrFail($id);
        $obat->delete();

        return redirect('/obat')->with('success', 'Data obat berhasil dihapus');
    }
}
