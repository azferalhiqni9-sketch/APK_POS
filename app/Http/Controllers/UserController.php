<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchRequest;
use Illuminate\Http\Request;
use App\Http\Requests\User\StoreRequest;
use App\Http\Requests\User\UpdateRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Menampilkan halaman daftar user (Index).
     * Dilengkapi fitur pencarian berdasarkan nama atau email.
     */
    public function index(SearchRequest $request)
    {
        // Mengambil input kata kunci pencarian dari user
        $keyword = $request->input('search');

        // Cek apakah user mengetik sesuatu di kolom pencarian
        if ($keyword) {
            // Jika ya, cari data menggunakan indeks FULLTEXT MySQL (name & email) lalu paginasi 10 data per halaman
            $users = User::whereRaw("MATCH(name, email) AGAINST(? IN BOOLEAN MODE)", [$keyword])
                ->paginate(10)
                ->withQueryString();
        } else {
            // Jika tidak ada pencarian, tampilkan semua data user dengan paginasi 10 data
            $users = User::query()->paginate(10)->withQueryString();
        }

        // Mengirim data $users ke view resources/views/users/index.blade.php
        return view('users.index', compact('users'));
    }

    /**
     * Menampilkan form untuk menambah user baru.
     */
    public function create()
    {
        // Mengambil semua data role (misal: Admin/Kasir) untuk pilihan di form
        $roles = Role::all();
        
        // Membuka view form tambah user
        return view('users.create', compact('roles'));
    }

    /**
     * Menyimpan data user baru ke database.
     */
    public function store(StoreRequest $request)
    {
        // Validasi data sudah otomatis ditangani oleh StoreRequest
        $dataReq = $request->validated();

        // Memasukkan data tervalidasi ke dalam array
        $data['name']     = $dataReq['name'];
        $data['email']    = $dataReq['email'];
        $data['password'] = Hash::make($dataReq['password']); // Enkripsi password agar aman
        $data['role_id']  = $dataReq['role_id'];

        // Menyimpan data ke tabel users
        User::create($data);

        // Setelah simpan, arahkan kembali ke halaman daftar user (admin.users) + pesan sukses untuk Toast
        return redirect()->route('admin.users')->with('success', 'User berhasil dibuat');
    }

    /**
     * Menampilkan detail user (pada kode ini digunakan sebagai alternatif cepat hapus).
     */
    public function show(User $user)
    {
        $user->delete();
        return back()->with('success', 'User dihapus');
    }

    /**
     * Menampilkan form edit untuk mengubah data user.
     */
    public function edit(User $user)
    {
        // Mengambil data role dan data user yang akan diedit
        $roles = Role::all();
        return view('users.edit', compact('user', 'roles'));
    }

    /**
     * Memperbarui data user yang sudah di-edit ke database.
     */
    public function update(UpdateRequest $request, User $user)
    {
        // Validasi data inputan edit
        $dataReq = $request->validated();

        // Memperbarui properti user
        $user->name    = $dataReq['name'];
        $user->email   = $dataReq['email'];
        $user->role_id = $dataReq['role_id'];

        // Cek apakah password diisi atau tidak (jika kosong, password lama tidak diubah)
        if (!empty($dataReq['password'])) {
            $user->password = Hash::make($dataReq['password']);
        }

        // Simpan perubahan ke database
        $user->save();

        // Setelah diupdate, langsung arahkan kembali ke halaman utama/daftar user (admin.users)
        return redirect()->route('admin.users')->with('success', 'User berhasil diupdate');
    }

    /**
     * Menghapus data user dari database.
     */
   public function destroy(User $user)
   {
       // Cek pengaman: apakah user ini punya relasi data transaksi penjualan
       if ($user->penjualan()->exists()) {
           // Jika punya, batalkan hapus dan kembalikan pesan error
           return back()->with('error', 'User tidak dapat dihapus karena memiliki riwayat transaksi penjualan.');
       }

       // Jika aman dan tidak ada transaksi terkait, hapus user
       $user->delete();

       // Kembalikan ke halaman sebelumnya dengan pesan sukses
       return back()->with('success', 'User berhasil dihapus.');
   }
}