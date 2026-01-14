<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
// PENTING: Import 2 baris ini
use App\Models\User;
use App\Policies\UserPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Daftar Policy ada disini
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        
        // DAFTARKAN DISINI:
        User::class => UserPolicy::class,
    ];

    public function boot()
    {
        $this->registerPolicies();

        //
    }
}