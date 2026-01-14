<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * ATURAN: Siapa yang boleh menghapus user?
     * $currentUser = Orang yang lagi login (Si Eksekutor)
     * $targetUser  = Orang yang mau dihapus (Si Korban)
     */
    public function delete(User $currentUser, User $targetUser)
    {
        // SYARAT 1: Eksekutor harus Superadmin (Police)
        // SYARAT 2: Korban harus User biasa (bukan sesama admin)
        
        return $currentUser->role === 'superadmin' && $targetUser->role === 'user';
    }
}