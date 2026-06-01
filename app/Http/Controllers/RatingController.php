<?php

namespace App\Http\Controllers;

use App\Models\Publicacion;
use App\Models\Calificacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    public function store(Request $request, Publicacion $publicacion)
    {
        $request->validate(['valor' => 'required|integer|min:1|max:5']);

        if ($publicacion->user_id === Auth::id()) {
            return back()->with('error', 'No puedes calificar tu propia publicación.');
        }

        $existing = Calificacion::where('publicacion_id', $publicacion->id)
                                ->where('user_id', Auth::id())->first();
        if ($existing) {
            return back()->with('error', 'Ya calificaste esta publicación.');
        }

        Calificacion::create([
            'publicacion_id' => $publicacion->id,
            'user_id' => Auth::id(),
            'valor' => $request->valor,
        ]);

        return back()->with('success', 'Gracias por tu calificación.');
    }
}