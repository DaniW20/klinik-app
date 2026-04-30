<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TindakanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->search;

        $data = \App\Models\Tindakan::when($search, function ($query, $search) {
            return $query->where('nama_tindakan', 'like', "%$search%");
        })->paginate(5)->withQueryString();

        return view('tindakan.index', compact('data', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tindakan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_tindakan' => 'required',
            'harga' => 'required|integer'
        ]);

        \App\Models\Tindakan::create($request->all());

        return redirect('/tindakan')->with('success', 'Data tindakan berhasil ditambahkan');
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
        $tindakan = \App\Models\Tindakan::findOrFail($id);
        return view('tindakan.edit', compact('tindakan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_tindakan' => 'required',
            'harga' => 'required|integer'
        ]);

        $tindakan = \App\Models\Tindakan::findOrFail($id);
        $tindakan->update($request->all());

        return redirect('/tindakan')->with('success', 'Data berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $tindakan = \App\Models\Tindakan::findOrFail($id);
        $tindakan->delete();

        return redirect('/tindakan')->with('success', 'Data berhasil dihapus');
    }
}
