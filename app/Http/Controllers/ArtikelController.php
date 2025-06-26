<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use Illuminate\Http\Request;

class ArtikelController extends Controller
{
    // Menampilkan daftar artikel (untuk API/AJAX) - ADMIN ONLY
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $artikels = Artikel::orderBy('created_at', 'desc')->get();
            return response()->json([
                'success' => true,
                'data' => $artikels
            ]);
        }
        
        return view('dashboard.artikel.index');
    }

    // Public method untuk mendapatkan artikel - accessible by all users
    public function getPublicArticles(Request $request)
    {
        try {
            $artikels = Artikel::orderBy('created_at', 'desc')->get();
            return response()->json([
                'success' => true,
                'data' => $artikels
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memuat artikel'
            ], 500);
        }
    }

    // Menyimpan artikel baru - TANPA THUMBNAIL
    public function store(Request $request)
    {
        $request->validate([
            'published_date' => 'required|date',
            'source' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'link' => 'required|url'
        ]);

        $data = $request->only([
            'published_date',
            'source', 
            'title',
            'description',
            'link'
        ]);

        $artikel = Artikel::create($data);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Artikel berhasil disimpan!',
                'data' => $artikel
            ]);
        }

        return redirect()->back()->with('success', 'Artikel berhasil disimpan!');
    }

    // Update artikel - TANPA THUMBNAIL
    public function update(Request $request, $id)
    {
        $artikel = Artikel::findOrFail($id);

        $request->validate([
            'published_date' => 'required|date',
            'source' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'link' => 'required|url'
        ]);

        $data = $request->only([
            'published_date',
            'source', 
            'title',
            'description',
            'link'
        ]);

        $artikel->update($data);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Artikel berhasil diupdate!',
                'data' => $artikel
            ]);
        }

        return redirect()->back()->with('success', 'Artikel berhasil diupdate!');
    }

    // Hapus artikel - TANPA PERLU HAPUS THUMBNAIL
    public function destroy($id)
    {
        $artikel = Artikel::findOrFail($id);
        $artikel->delete();

        return response()->json([
            'success' => true,
            'message' => 'Artikel berhasil dihapus!'
        ]);
    }
}