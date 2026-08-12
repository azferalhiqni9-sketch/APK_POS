<?php

namespace App\Policies;

use App\Models\Jenis;
use App\Models\User;

class JenisPolicy
{
    public function update(User $user, Jenis $jenis): bool
    {
        return $user->role->name === 'admin';
    }

    public function delete(User $user, Jenis $jenis): bool
    {
        return $user->role->name === 'admin';
    }
}