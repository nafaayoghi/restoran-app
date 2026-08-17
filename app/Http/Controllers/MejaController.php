<?php

namespace App\Http\Controllers;

use App\Models\Meja;
use Illuminate\Http\Request;

class MejaController extends Controller
{
    public function index()
    {
        $meja = Meja::all();
        return view('meja.index', compact('meja'));
    }

    public function create()
    {
        return view('meja.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'NOMOR_MEJA' => 'required',
            'KAPASITAS_MEJA' => 'required|numeric',
        ]);

        Meja::create([
            'NOMOR_MEJA' => $request->NOMOR_MEJA,
            'KAPASITAS_MEJA' => $request->KAPASITAS_MEJA,
        ]);

        return redirect('/meja')->with('success', 'Meja berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $meja = Meja::findOrFail($id);
        return view('meja.edit', compact('meja'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'KAPASITAS_MEJA' => 'required|numeric',
        ]);

        $meja = Meja::findOrFail($id);
        $meja->update([
            'KAPASITAS_MEJA' => $request->KAPASITAS_MEJA,
        ]);

        return redirect('/meja')->with('success', 'Data meja berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $meja = Meja::findOrFail($id);
        $meja->delete();

        return redirect('/meja')->with('success', 'Data meja berhasil dihapus!');
    }
}