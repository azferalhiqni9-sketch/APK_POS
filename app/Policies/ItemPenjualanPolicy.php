<?php

namespace App\Policies;

use App\Models\ItemPenjualan;
use App\Models\User;

class ItemPenjualanPolicy
{
    public function delete(User $user, ItemPenjualan $itemPenjualan): bool
    {
        // Izinkan jika user adalah admin, atau kasir yang memiliki transaksi tersebut
        return $user->role->name === 'admin' || $itemPenjualan->penjualan->user_id === $user->id;
    }
}