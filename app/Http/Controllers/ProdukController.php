<?php

namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Http\Requests\SearchRequest;
use App\Http\Requests\Produk\StoreRequest;
use App\Http\Requests\Produk\UpdateRequest;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class ProdukController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of the resource.
     */
    public function index(SearchRequest $request)
    {
        $this->authorize('viewAny', Produk::class);
        $keyword = $request->input('search');

        if ($keyword) {
            $products = Produk::when($keyword, function ($query) use ($keyword) {
                $query->where('nama', 'like', "%" . $keyword . "%");
            })
                ->orderBy('nama')
                ->paginate(10)
                ->withQueryString();
        } else {
            $products = Produk::latest()->paginate(10)->withQueryString();
        }

        return view('produk.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Produk::class);
        return view('produk.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $this->authorize('create', Produk::class);
        $dataReq = $request->validated();

        $data['user_id'] = Auth::id();
        $data['nama'] = $dataReq['name'];
        $data['harga_beli'] = $dataReq['purchase_price'];
        $data['harga_jual'] = $dataReq['selling_price'];
        $data['stok'] = $dataReq['stock'] ?? true;

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('products', 'public');
        }

        Produk::create($data);

        return redirect()->route('produk.index')->with('success', 'Produk created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Mencegah layar putih jika link diakses langsung
        return redirect()->route('produk.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Produk $produk)
    {
        $this->authorize('update', $produk);
        return view('produk.edit', compact('produk'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Produk $produk)
    {
        $this->authorize('update', $produk);
        $dataReq = $request->validated();

        $data = [
            'user_id'    => Auth::id(),
            'nama'       => $dataReq['name'],
            'harga_beli' => $dataReq['purchase_price'],
            'harga_jual' => $dataReq['selling_price'],
            'stok'       => $dataReq['stock'],
        ];

        // jika upload foto baru
        if ($request->hasFile('foto')) {
            // hapus foto lama jika ada & memang tersimpan
            if (
                $produk->foto &&
                Storage::disk('public')->exists($produk->foto)
            ) {
                Storage::disk('public')->delete($produk->foto);
            }

            // simpan foto baru
            $data['foto'] = $request->file('foto')->store('products', 'public');
        }

        $produk->update($data);

        return redirect()->route('produk.edit', $produk)
            ->with('success', 'Produk updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Produk $produk)
    {
        $this->authorize('delete', $produk);

        try {
            // Hapus file foto jika ada
            if ($produk->foto && Storage::disk('public')->exists($produk->foto)) {
                Storage::disk('public')->delete($produk->foto);
            }

            // Hapus data produk dari database
            $produk->delete();

            return redirect()->route('produk.index')
                ->with('success', 'Product deleted successfully.');

        } catch (QueryException $e) {
            // Ditangkap jika gagal karena tertahan relasi transaksi penjualan
            if ($e->getCode() == '23000') {
                return redirect()->route('produk.index')
                    ->with('error', 'Gagal menghapus! Produk ini sudah memiliki riwayat transaksi penjualan.');
            }

            return redirect()->route('produk.index')
                ->with('error', 'Terjadi kesalahan pada sistem database.');
        }
    }
}