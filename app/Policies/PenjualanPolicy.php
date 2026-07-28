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

    public function view(User $user, Penjualan $penjualan): bool
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
        return true;
    }
}