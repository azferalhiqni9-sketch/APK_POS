<?php

namespace App\Http\Controllers;

use App\Models\ItemPenjualan;
use App\Models\Penjualan;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ItemPenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
            'product_id' => 'required|exists:produk,id',
            'quantity' => 'required|integer|min:1'
        ]);

        // Cari transaksi OPEN milik user, jika tidak ada (sedang edit transaksi lama), ambil transaksi terakhir milik user
        $sale = Penjualan::where('user_id', Auth::id())
            ->where('status', 'OPEN')
            ->latest()
            ->first();

        if (!$sale) {
            $sale = Penjualan::where('user_id', Auth::id())->latest()->firstOrFail();
        }

        $product = Produk::findOrFail($request->product_id);

        if ($product->stok < $request->quantity) {
            return back()->with('swal_error', 'Stok produk ' . $product->nama . ' tidak mencukupi! Sisa stok: ' . $product->stok);
        }

        DB::transaction(function () use ($request, $sale, $product) {

            $product = Produk::lockForUpdate()->findOrFail($product->id);
            $product->decrement('stok', $request->quantity);

            $item = ItemPenjualan::where('penjualan_id', $sale->id)
                ->where('produk_id', $product->id)
                ->lockForUpdate()
                ->first();

            if ($item) {
                $item->kuantitas += $request->quantity;
            } else {
                $item = new ItemPenjualan([
                    'penjualan_id' => $sale->id,
                    'produk_id' => $product->id,
                    'kuantitas' => $request->quantity,
                    'harga_satuan' => $product->harga_jual,
                ]);
            }

            $item->subtotal = $item->kuantitas * $item->harga_satuan;
            $item->save();

            $sale->total_pembayaran = $sale->itemPenjualan()->sum('subtotal');
            $sale->save();
        });

        return back();
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ItemPenjualan $itempenjualan)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $produk = $itempenjualan->produk;
        $selisih = $request->quantity - $itempenjualan->kuantitas;

        if ($selisih > 0 && $produk->stok < $selisih) {
            return back()->with('swal_error', 'Stok produk ' . $produk->nama . ' tidak mencukupi untuk penambahan tersebut!');
        }

        DB::transaction(function () use ($request, $itempenjualan, $selisih) {

            $produk = $itempenjualan->produk()->lockForUpdate()->first();

            if ($selisih > 0) {
                $produk->decrement('stok', $selisih);
            } elseif ($selisih < 0) {
                $produk->increment('stok', abs($selisih));
            }

            $itempenjualan->update([
                'kuantitas' => $request->quantity,
                'subtotal' => $request->quantity * $itempenjualan->harga_satuan
            ]);

            $itempenjualan->penjualan->update([
                'total_pembayaran' => $itempenjualan->penjualan->itemPenjualan()->sum('subtotal')
            ]);
        });

        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ItemPenjualan $itempenjualan)
    {
        $this->authorize('delete', $itempenjualan);
        
        DB::transaction(function () use ($itempenjualan) {

            $produk = $itempenjualan->produk()->lockForUpdate()->first();
            $sale = $itempenjualan->penjualan;

            if ($produk) {
                $produk->increment('stok', $itempenjualan->kuantitas);
            }

            $itempenjualan->delete();

            if ($sale) {
                $sale->update([
                    'total_pembayaran' => $sale->itemPenjualan()->sum('subtotal')
                ]);
            }
        });

        return back();
    }
}