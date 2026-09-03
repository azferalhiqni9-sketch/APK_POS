<?php

namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Http\Requests\SearchRequest;
use App\Http\Requests\Produk\StoreRequest;
use App\Http\Requests\Produk\UpdateRequest;
use App\Models\Produk;
use App\Models\Jenis; // Import Model Jenis untuk relasi data jenis produk
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class ProdukController extends Controller
{
    use AuthorizesRequests;

    /**
     * Menampilkan daftar semua produk beserta fitur pencarian.
     */
    public function index(SearchRequest $request)
    {
        // Memeriksa hak akses untuk melihat daftar produk
        $this->authorize('viewAny', Produk::class);
        $keyword = $request->input('search');

        // Filter pencarian berdasarkan nama produk jika keyword diisi
        if ($keyword) {
            $products = Produk::when($keyword, function ($query) use ($keyword) {
                $query->where('nama', 'like', "%" . $keyword . "%");
            })
                ->orderBy('nama')
                ->paginate(10)
                ->withQueryString();
        } else {
            // Jika tidak ada pencarian, tampilkan data terbaru dengan pagination
            $products = Produk::latest()->paginate(10)->withQueryString();
        }

        return view('produk.index', compact('products'));
    }

    /**
     * Menampilkan form untuk membuat produk baru.
     */
    public function create()
    {
        // Memeriksa hak akses untuk membuat produk
        $this->authorize('create', Produk::class);
        
        // Mengambil seluruh data jenis untuk pilihan dropdown di form
        $jenis = Jenis::all(); 

        return view('produk.create', compact('jenis'));
    }

    /**
     * Menyimpan data produk baru ke dalam database.
     */
    public function store(StoreRequest $request)
    {
        // Memeriksa hak akses tambah produk
        $this->authorize('create', Produk::class);
        $dataReq = $request->validated();

        // Menyiapkan data yang akan dimasukkan ke database
        $data['user_id']    = Auth::id();
        $data['jenis_id']   = $dataReq['jenis_id']; // Menyimpan ID jenis produk yang dipilih
        $data['nama']       = $dataReq['name'];
        $data['harga_beli'] = $dataReq['purchase_price'];
        $data['harga_jual'] = $dataReq['selling_price'];
        $data['stok']       = $dataReq['stock'] ?? true;

        // Proses upload file foto produk jika ada
        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('products', 'public');
        }

        // Simpan data ke database
        Produk::create($data);

        return redirect()->route('produk.index')->with('success', 'Produk created successfully.');
    }

    /**
     * Menampilkan detail spesifik produk (diarahkan kembali ke index untuk mencegah layar putih).
     */
    public function show(string $id)
    {
        return redirect()->route('produk.index');
    }

    /**
     * Menampilkan form untuk mengedit data produk.
     */
    public function edit(Produk $produk)
    {
        // Memeriksa hak akses update produk
        $this->authorize('update', $produk);

        // Mengambil data jenis untuk ditampilkan pada dropdown pilihan jenis di form edit
        $jenis = Jenis::all(); 

        return view('produk.edit', compact('produk', 'jenis'));
    }

    /**
     * Memperbarui data produk yang ada di dalam database.
     */
    public function update(UpdateRequest $request, Produk $produk)
    {
        // Memeriksa hak akses update produk
        $this->authorize('update', $produk);
        $dataReq = $request->validated();

        // Menyiapkan data terbaru untuk proses update
        $data = [
            'user_id'    => Auth::id(),
            'jenis_id'   => $dataReq['jenis_id'], // Memperbarui relasi jenis_id
            'nama'       => $dataReq['name'],
            'harga_beli' => $dataReq['purchase_price'],
            'harga_jual' => $dataReq['selling_price'],
            'stok'       => $dataReq['stock'],
        ];

        // Cek apakah ada file foto baru yang di-upload
        if ($request->hasFile('foto')) {
            // Hapus foto lama di storage jika ada
            if (
                $produk->foto &&
                Storage::disk('public')->exists($produk->foto)
            ) {
                Storage::disk('public')->delete($produk->foto);
            }

            // Simpan foto baru ke storage
            $data['foto'] = $request->file('foto')->store('products', 'public');
        }

        // Lakukan pembaruan data produk
        $produk->update($data);

        // Diubah agar langsung kembali ke halaman index (daftar produk) setelah disimpan
        return redirect()->route('produk.index')
            ->with('success', 'Produk berhasil diperbarui.');
    }

    /**
     * Menghapus data produk dari database.
     */
   /**
     * Menghapus data produk dari database.
     */
    public function destroy(Produk $produk)
    {
        $this->authorize('delete', $produk);

        DB::transaction(function () use ($produk) {
            
            // 1. Hapus semua item penjualan terkait secara otomatis & perbarui total transaksinya
            foreach ($produk->itemPenjualan as $item) {
                $sale = $item->penjualan;

                $item->delete();

                if ($sale) {
                    $sale->update([
                        'total_pembayaran' => $sale->itemPenjualan()->sum('subtotal')
                    ]);
                }
            }

            // 2. Hapus foto produk dari storage jika ada
            if ($produk->foto && Storage::disk('public')->exists($produk->foto)) {
                Storage::disk('public')->delete($produk->foto);
            }

            // 3. Hapus produknya
            $produk->delete();
        });

        return redirect()->route('produk.index')->with('success', 'Produk berhasil dihapus.');
    }
}
