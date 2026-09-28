<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PenjualOrderController extends Controller
{
    /**
     * Tampilkan daftar pesanan masuk untuk produk milik penjual.
     */
    public function index(Request $request): View
    {
        $penjualId = Auth::id();

        // Ambil order yang berisi produk milik penjual ini
        $query = Order::whereHas('details.produk', function ($q) use ($penjualId) {
            $q->where('penjual_id', $penjualId);
        })->with([
            'pembeli',
            'details.produk' => function ($q) use ($penjualId) {
                $q->where('penjual_id', $penjualId);
            },
        ]);

        // Filter status pesanan jika dipilih
        if ($request->filled('status') && $request->status !== 'semua') {
            $query->where('status_order', $request->status);
        }

        $orders = $query->latest('id_order')->get();

        // Hitung statistik status pesanan untuk penjual
        $allOrders = Order::whereHas('details.produk', function ($q) use ($penjualId) {
            $q->where('penjual_id', $penjualId);
        })->get();

        $counts = [
            'semua' => $allOrders->count(),
            'menunggu_bayar' => $allOrders->where('status_order', 'menunggu_bayar')->count(),
            'menunggu_konfirmasi' => $allOrders->where('status_order', 'menunggu_konfirmasi')->count(),
            'diproses' => $allOrders->where('status_order', 'diproses')->count(),
            'dikirim' => $allOrders->where('status_order', 'dikirim')->count(),
            'selesai' => $allOrders->where('status_order', 'selesai')->count(),
            'dibatalkan' => $allOrders->where('status_order', 'dibatalkan')->count(),
        ];

        return view('penjual.pesanan', compact('orders', 'counts'));
    }

    /**
     * Perbarui status pesanan oleh penjual.
     */
    public function updateStatus(Request $request, int $id): RedirectResponse
    {
        $penjualId = Auth::id();

        $request->validate([
            'status_order' => 'required|in:menunggu_bayar,menunggu_konfirmasi,diproses,dikirim,selesai,dibatalkan',
        ]);

        // Pastikan order mengandung produk milik penjual
        $order = Order::whereHas('details.produk', function ($q) use ($penjualId) {
            $q->where('penjual_id', $penjualId);
        })->where('id_order', $id)->firstOrFail();

        $order->status_order = $request->status_order;
        $order->save();

        $statusText = match ($request->status_order) {
            'diproses' => 'diproses (menunggu pengemasan)',
            'dikirim' => 'dikirim',
            'selesai' => 'selesai',
            'dibatalkan' => 'dibatalkan',
            'menunggu_konfirmasi' => 'menunggu konfirmasi',
            default => $request->status_order,
        };

        return back()->with('success', 'Status pesanan #ORD-'.$order->id_order.' berhasil diperbarui menjadi '.$statusText.'!');
    }
}
