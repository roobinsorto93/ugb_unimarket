<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Calificacion extends Model
{
    protected $table = 'calificaciones';  // ← Especifica el nombre correcto de la tabla

    protected $fillable = ['publicacion_id', 'user_id', 'valor'];

    public function publicacion()
    {
        return $this->belongsTo(Publicacion::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}