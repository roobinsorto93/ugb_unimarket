<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\Publicacion;
use App\Policies\PublicacionPolicy;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Publicacion::class => PublicacionPolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();
    }
}