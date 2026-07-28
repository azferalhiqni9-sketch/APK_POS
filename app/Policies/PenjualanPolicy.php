<?php

namespace App\Policies;

use App\Models\Penjualan;
use App\Models\User;

class PenjualanPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Penjualan $penjualan): bool
    {
        return true;
    }

    public function delete(User $user, Penjualan $penjualan): bool
    {
        // Admin bisa menghapus, atau kasir yang membuat transaksi tersebut
        $isAdmin = $user->role->name === 'admin';
        $isOwner = $penjualan->user_id === $user->id;
        
        // Status harus OPEN (menggunakan strtoupper agar aman dari 'open' / 'OPEN')
        $isOpen = strtoupper($penjualan->status) === 'OPEN';

        return ($isAdmin || $isOwner) && $isOpen;
    }

    public function view(User $user, Penjualan $penjualan): bool
    {
        return true;
    }
}