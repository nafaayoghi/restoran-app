<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::all();
        return view('menu.index', compact('menus'));
    }

    public function create()
    {
        return view('menu.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'NAMA_MENU' => 'required',
            'HARGA_MENU' => 'required|numeric',
            'KATEGORI_MENU' => 'required',
        ]);

        Menu::create([
            'NAMA_MENU' => $request->NAMA_MENU,
            'HARGA_MENU' => $request->HARGA_MENU,
            'KATEGORI_MENU' => $request->KATEGORI_MENU,
        ]);

        return redirect('/menu')->with('success', 'Menu berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $menu = Menu::findOrFail($id);
        return view('menu.edit', compact('menu'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'NAMA_MENU' => 'required',
            'HARGA_MENU' => 'required|numeric',
            'KATEGORI_MENU' => 'required',
        ]);

        $menu = Menu::findOrFail($id);
        $menu->update([
            'NAMA_MENU' => $request->NAMA_MENU,
            'HARGA_MENU' => $request->HARGA_MENU,
            'KATEGORI_MENU' => $request->KATEGORI_MENU,
        ]);

        return redirect('/menu')->with('success', 'Menu berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $menu = Menu::findOrFail($id);
        $menu->delete();

        return redirect('/menu')->with('success', 'Menu berhasil dihapus!');
    }
}