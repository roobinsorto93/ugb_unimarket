<?php

namespace App\Http\Controllers;

use App\Models\Publicacion;
use App\Models\Mensaje; // ← Agregar esta línea
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PublicacionController extends Controller
{
    public function index(Request $request)
    {
        $publicaciones = Publicacion::with('user')
            ->filtrar($request)
            ->latest()
            ->paginate(10);

        // Contar mensajes no leídos para el usuario autenticado
        $nuevosMensajes = Mensaje::where('receptor_id', Auth::id())
            ->where('leido', false)
            ->count();

        return view('publicaciones.index', [
            'publicaciones' => $publicaciones,
            'categoriaActual' => $request->categoria,
            'sedeActual' => $request->sede ?? 'ambas',
            'searchActual' => $request->search,
            'nuevosMensajes' => $nuevosMensajes, // ← Pasar a la vista
        ]);
    }

    public function create()
    {
        return view('publicaciones.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'categoria' => 'required|in:Comida,Apuntes,Servicios',
            'titulo' => 'required|string|max:150',
            'descripcion' => 'required|string',
            'precio' => 'nullable|numeric|min:0|max:999999.99',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $validated;
        $data['user_id'] = Auth::id();
        if ($request->hasFile('imagen')) {
            $data['imagen'] = $request->file('imagen')->store('publicaciones', 'public');
        }
        Publicacion::create($data);
        return redirect()->route('dashboard')->with('success', 'Publicación creada.');
    }

    public function edit(Publicacion $publicacion)
    {
        if (Auth::id() !== $publicacion->user_id) abort(403);
        return view('publicaciones.edit', compact('publicacion'));
    }

    public function update(Request $request, Publicacion $publicacion)
    {
        if (Auth::id() !== $publicacion->user_id) abort(403);

        $validated = $request->validate([
            'categoria' => 'required|in:Comida,Apuntes,Servicios',
            'titulo' => 'required|string|max:150',
            'descripcion' => 'required|string',
            'precio' => 'nullable|numeric|min:0|max:999999.99',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('imagen')) {
            if ($publicacion->imagen) Storage::disk('public')->delete($publicacion->imagen);
            $validated['imagen'] = $request->file('imagen')->store('publicaciones', 'public');
        }

        $publicacion->update($validated);
        return redirect()->route('dashboard')->with('success', 'Publicación actualizada.');
    }

    public function destroy(Publicacion $publicacion)
    {
        if (Auth::id() !== $publicacion->user_id) abort(403);
        if ($publicacion->imagen) Storage::disk('public')->delete($publicacion->imagen);
        $publicacion->delete();
        return back()->with('success', 'Publicación eliminada.');
    }
}