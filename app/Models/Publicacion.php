<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Publicacion extends Model
{
    use HasFactory;

    protected $table = 'publicaciones';

    protected $fillable = [
        'user_id', 'categoria', 'titulo', 'descripcion', 'precio', 'imagen'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function calificaciones()
    {
        return $this->hasMany(Calificacion::class);
    }

    public function mensajes()
    {
        return $this->hasMany(Mensaje::class);
    }

    public function promedioCalificacion()
    {
        return $this->calificaciones()->avg('valor');
    }

    public function totalCalificaciones()
    {
        return $this->calificaciones()->count();
    }

    public function scopeFiltrar($query, $request)
    {
        if ($request->filled('categoria')) {
            $query->where('categoria', $request->categoria);
        }
        if ($request->filled('sede') && $request->sede !== 'ambas') {
            $query->whereHas('user', function($q) use ($request) {
                $q->where('sede', $request->sede);
            });
        }
        if ($request->filled('search')) {
            $search = '%' . $request->search . '%';
            $query->where(function($q) use ($search) {
                $q->where('titulo', 'LIKE', $search)
                  ->orWhere('descripcion', 'LIKE', $search);
            });
        }
        return $query;
    }
}