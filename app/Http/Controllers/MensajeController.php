<?php

namespace App\Http\Controllers;

use App\Models\Mensaje;
use App\Models\Publicacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MensajeController extends Controller
{
    // Buzón de entrada (recibidos)
    public function inbox()
    {
        $mensajes = Mensaje::where('receptor_id', Auth::id())
            ->with('emisor', 'publicacion')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('mensajes.inbox', compact('mensajes'));
    }

    // Buzón de enviados
    public function sent()
    {
        $mensajes = Mensaje::where('emisor_id', Auth::id())
            ->with('receptor', 'publicacion')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('mensajes.sent', compact('mensajes'));
    }

    // Mostrar detalle de un mensaje (recibido o enviado)
    public function show(Mensaje $mensaje)
    {
        if ($mensaje->receptor_id != Auth::id() && $mensaje->emisor_id != Auth::id()) {
            abort(403);
        }
        if ($mensaje->receptor_id == Auth::id() && !$mensaje->leido) {
            $mensaje->leido = true;
            $mensaje->save();
        }
        return view('mensajes.show', compact('mensaje'));
    }

    // Mostrar formulario para responder un mensaje
    public function reply(Mensaje $mensaje)
    {
        if ($mensaje->receptor_id != Auth::id()) {
            abort(403);
        }
        return view('mensajes.reply', compact('mensaje'));
    }

    // Guardar nuevo mensaje (desde compra o respuesta)
    public function store(Request $request)
    {
        $request->validate([
            'contenido' => 'required|string|min:3',
            'receptor_id' => 'required|exists:users,id',
            'publicacion_id' => 'required|exists:publicaciones,id',
        ]);

        Mensaje::create([
            'publicacion_id' => $request->publicacion_id,
            'emisor_id' => Auth::id(),
            'receptor_id' => $request->receptor_id,
            'contenido' => $request->contenido,
            'leido' => false,
        ]);

        return redirect()->route('mensajes.inbox')->with('success', 'Mensaje enviado.');
    }

    // Mostrar formulario para nuevo mensaje desde botón "Comprar"
    public function create(Publicacion $publicacion)
    {
        if ($publicacion->user_id == Auth::id()) {
            return back()->with('error', 'No puedes enviarte un mensaje a ti mismo.');
        }
        return view('mensajes.enviar', compact('publicacion'));
    }
}