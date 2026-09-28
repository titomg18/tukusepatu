<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProdukController extends Controller
{
    /**
     * Tampilkan daftar produk milik penjual yang sedang login.
     */
    public function index(Request $request): View
    {
        $penjualId = Auth::id();

        $query = Produk::where('penjual_id', $penjualId);

        // Filter kata kunci pencarian
        if ($request->filled('search')) {
            $query->where('nama_product', 'like', '%'.$request->search.'%');
        }

        // Filter kategori
        if ($request->filled('kategori') && $request->kategori !== 'Semua Kategori') {
            $query->where('kategori', $request->kategori);
        }

        $produks = $query->latest('id_product')->get();

        return view('penjual.produk', compact('produks'));
    }

    /**
     * Tampilkan formulir tambah produk baru.
     */
    public function create(): View
    {
        return view('penjual.produk_tambah');
    }

    /**
     * Simpan produk baru ke database.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama_product' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'kategori' => 'required|string|max:100',
            'gambar_product' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'status_product' => 'required|in:tersedia,habis',
        ]);

        $gambarPath = null;
        if ($request->hasFile('gambar_product')) {
            $gambarPath = $request->file('gambar_product')->store('produk', 'public');
        }

        Produk::create([
            'penjual_id' => Auth::id(),
            'nama_product' => $validated['nama_product'],
            'deskripsi' => $validated['deskripsi'] ?? null,
            'harga' => $validated['harga'],
            'stok' => $validated['stok'],
            'kategori' => $validated['kategori'],
            'gambar_product' => $gambarPath,
            'status_product' => $validated['status_product'],
        ]);

        return redirect()->route('penjual.produk')->with('success', 'Produk sepatu baru berhasil ditambahkan!');
    }

    /**
     * Tampilkan formulir edit produk.
     */
    public function edit(int $id): View|RedirectResponse
    {
        $produk = Produk::where('penjual_id', Auth::id())->where('id_product', $id)->firstOrFail();

        return view('penjual.produk_edit', compact('produk'));
    }

    /**
     * Perbarui data produk di database.
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $produk = Produk::where('penjual_id', Auth::id())->where('id_product', $id)->firstOrFail();

        $validated = $request->validate([
            'nama_product' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'kategori' => 'required|string|max:100',
            'gambar_product' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'status_product' => 'required|in:tersedia,habis',
        ]);

        if ($request->hasFile('gambar_product')) {
            // Hapus gambar lama jika ada
            if ($produk->gambar_product && Storage::disk('public')->exists($produk->gambar_product)) {
                Storage::disk('public')->delete($produk->gambar_product);
            }

            $produk->gambar_product = $request->file('gambar_product')->store('produk', 'public');
        }

        $produk->update([
            'nama_product' => $validated['nama_product'],
            'deskripsi' => $validated['deskripsi'] ?? null,
            'harga' => $validated['harga'],
            'stok' => $validated['stok'],
            'kategori' => $validated['kategori'],
            'status_product' => $validated['status_product'],
            'gambar_product' => $produk->gambar_product,
        ]);

        return redirect()->route('penjual.produk')->with('success', 'Produk berhasil diperbarui!');
    }

    /**
     * Hapus produk dari database.
     */
    public function destroy(int $id): RedirectResponse
    {
        $produk = Produk::where('penjual_id', Auth::id())->where('id_product', $id)->firstOrFail();

        if ($produk->gambar_product && Storage::disk('public')->exists($produk->gambar_product)) {
            Storage::disk('public')->delete($produk->gambar_product);
        }

        $produk->delete();

        return redirect()->route('penjual.produk')->with('success', 'Produk berhasil dihapus!');
    }
}
