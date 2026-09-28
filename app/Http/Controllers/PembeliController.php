<?php

namespace App\Http\Controllers;

use App\Models\DetailOrder;
use App\Models\Order;
use App\Models\Produk;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class PembeliController extends Controller
{
    /**
     * Tampilkan beranda pembeli (katalog produk).
     */
    public function dashboard(Request $request): View
    {
        $query = Produk::query();

        if ($request->filled('search')) {
            $query->where('nama_product', 'like', '%'.$request->search.'%');
        }

        if ($request->filled('kategori') && $request->kategori !== 'Semua Kategori') {
            $query->where('kategori', $request->kategori);
        }

        $produks = $query->latest('id_product')->get();
        $cartCount = count(session('cart', []));

        return view('pembeli.dashboard', compact('produks', 'cartCount'));
    }

    /**
     * Tambahkan produk ke keranjang belanja (Session).
     */
    public function addToCart(Request $request): RedirectResponse
    {
        $request->validate([
            'id_product' => 'required|exists:produk,id_product',
            'jumlah' => 'nullable|integer|min:1',
        ]);

        $produk = Produk::findOrFail($request->id_product);
        $jumlah = $request->input('jumlah', 1);

        if ($produk->status_product === 'habis' || $produk->stok < 1) {
            return back()->with('error', 'Maaf, stok produk ini telah habis.');
        }

        $cart = session()->get('cart', []);

        if (isset($cart[$produk->id_product])) {
            $cart[$produk->id_product]['jumlah'] += $jumlah;
        } else {
            $cart[$produk->id_product] = [
                'id_product' => $produk->id_product,
                'nama_product' => $produk->nama_product,
                'harga' => $produk->harga,
                'gambar_product' => $produk->gambar_product,
                'kategori' => $produk->kategori,
                'jumlah' => $jumlah,
            ];
        }

        session()->put('cart', $cart);

        return redirect()->route('pembeli.keranjang')->with('success', 'Produk berhasil ditambahkan ke keranjang belanja!');
    }

    /**
     * Tampilkan halaman keranjang belanja.
     */
    public function keranjang(): View
    {
        $cart = session()->get('cart', []);

        $totalHarga = 0;
        foreach ($cart as $item) {
            $totalHarga += $item['harga'] * $item['jumlah'];
        }

        return view('pembeli.keranjang', compact('cart', 'totalHarga'));
    }

    /**
     * Perbarui jumlah produk di keranjang.
     */
    public function updateCart(Request $request): RedirectResponse
    {
        $request->validate([
            'id_product' => 'required',
            'jumlah' => 'required|integer|min:1',
        ]);

        $cart = session()->get('cart', []);

        if (isset($cart[$request->id_product])) {
            $cart[$request->id_product]['jumlah'] = $request->jumlah;
            session()->put('cart', $cart);
        }

        return back()->with('success', 'Jumlah produk di keranjang berhasil diperbarui.');
    }

    /**
     * Hapus item dari keranjang belanja.
     */
    public function removeFromCart(Request $request): RedirectResponse
    {
        $request->validate([
            'id_product' => 'required',
        ]);

        $cart = session()->get('cart', []);

        if (isset($cart[$request->id_product])) {
            unset($cart[$request->id_product]);
            session()->put('cart', $cart);
        }

        return back()->with('success', 'Produk dihapus dari keranjang belanja.');
    }

    /**
     * Tampilkan halaman checkout.
     */
    public function checkout(): View|RedirectResponse
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('pembeli.dashboard')->with('error', 'Keranjang belanja kamu masih kosong.');
        }

        $totalHarga = 0;
        foreach ($cart as $item) {
            $totalHarga += $item['harga'] * $item['jumlah'];
        }

        return view('pembeli.checkout', compact('cart', 'totalHarga'));
    }

    /**
     * Proses pembuatan pesanan/order baru.
     */
    public function processCheckout(Request $request): RedirectResponse
    {
        $request->validate([
            'alamat_pengiriman' => 'required|string|min:10',
        ]);

        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('pembeli.dashboard')->with('error', 'Keranjang belanja kamu masih kosong.');
        }

        $totalHarga = 0;
        foreach ($cart as $item) {
            $totalHarga += $item['harga'] * $item['jumlah'];
        }

        // 1. Buat Order baru
        $order = Order::create([
            'pembeli_id' => Auth::id(),
            'tgl_order' => now(),
            'total_harga' => $totalHarga,
            'status_order' => 'menunggu_bayar',
            'alamat_pengiriman' => $request->alamat_pengiriman,
            'bukti_bayar' => null,
        ]);

        // 2. Buat DetailOrder & potong stok produk jika ada
        foreach ($cart as $item) {
            DetailOrder::create([
                'order_id' => $order->id_order,
                'product_id' => $item['id_product'],
                'jumlah' => $item['jumlah'],
                'harga_satuan' => $item['harga'],
                'subtotal' => $item['harga'] * $item['jumlah'],
            ]);

            // Update stok produk
            $produk = Produk::find($item['id_product']);
            if ($produk) {
                $produk->stok = max(0, $produk->stok - $item['jumlah']);
                if ($produk->stok === 0) {
                    $produk->status_product = 'habis';
                }
                $produk->save();
            }
        }

        // 3. Kosongkan keranjang belanja
        session()->forget('cart');

        return redirect()->route('pembeli.order.show', $order->id_order)->with('success', 'Pesanan baru berhasil dibuat! Silakan lakukan pembayaran dan unggah bukti transfer.');
    }

    /**
     * Tampilkan daftar pesanan milik pembeli.
     */
    public function orders(Request $request): View
    {
        $query = Order::where('pembeli_id', Auth::id())->with('details.produk');

        if ($request->filled('status') && $request->status !== 'semua') {
            $query->where('status_order', $request->status);
        }

        $orders = $query->latest('id_order')->get();

        return view('pembeli.order_index', compact('orders'));
    }

    /**
     * Tampilkan detail pesanan & formulir upload bukti bayar.
     */
    public function showOrder(int $id): View|RedirectResponse
    {
        $order = Order::where('pembeli_id', Auth::id())->where('id_order', $id)->with('details.produk')->firstOrFail();

        return view('pembeli.order_show', compact('order'));
    }

    /**
     * Unggah bukti pembayaran untuk order tertentu.
     */
    public function uploadBuktiBayar(Request $request, int $id): RedirectResponse
    {
        $order = Order::where('pembeli_id', Auth::id())->where('id_order', $id)->firstOrFail();

        $request->validate([
            'bukti_bayar' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($request->hasFile('bukti_bayar')) {
            if ($order->bukti_bayar && Storage::disk('public')->exists($order->bukti_bayar)) {
                Storage::disk('public')->delete($order->bukti_bayar);
            }

            $path = $request->file('bukti_bayar')->store('bukti_bayar', 'public');
            $order->bukti_bayar = $path;
            $order->status_order = 'menunggu_konfirmasi';
            $order->save();
        }

        return back()->with('success', 'Bukti pembayaran berhasil diunggah! Status pesanan kini menunggu konfirmasi penjual.');
    }
}
