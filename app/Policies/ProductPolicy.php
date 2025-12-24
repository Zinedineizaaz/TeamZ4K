<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ProductPolicy
{
    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Product $product): bool
    {
        // LOGIKA POLICY:
        // Cek role user. Jika 'superadmin', return true (Boleh).
        // Selain itu return false (Dilarang).
        return $user->role === 'superadmin';
    }

    // Biarkan function lain (viewAny, view, create, update) apa adanya
    // atau return true jika semua admin boleh akses.
}