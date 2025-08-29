<?php

namespace App\Policies;

use App\Models\User;

class AuthPolicy
{
    /**
     * Tentukan apakah user dapat melihat user lain (misalnya hanya admin).
     */
    public function viewUser(User $user): bool
    {
        return $user->role == 'user';
    }

    // Policy lainnya, bisa diatur sesuai kebutuhan
}
