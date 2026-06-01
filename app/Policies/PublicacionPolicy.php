<?php

namespace App\Policies;

use App\Models\Publicacion;
use App\Models\User;

class PublicacionPolicy
{
    public function update(User $user, Publicacion $publicacion)
    {
        // Depuración: muestra los IDs en pantalla (después comenta o elimina)
        dump('Usuario ID: ' . $user->id);
        dump('Publicación user_id: ' . $publicacion->user_id);
        
        return $user->id === $publicacion->user_id;
    }

    public function delete(User $user, Publicacion $publicacion)
    {
        return $user->id === $publicacion->user_id;
    }
}