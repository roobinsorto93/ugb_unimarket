<?php

namespace App\Http\Controllers;

use App\Models\Mensaje;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    // Mostrar formulario de edición de perfil
    public function edit()
    {
        return view('profile.edit', ['user' => Auth::user()]);
    }

    // Actualizar perfil (nombre, sede, contraseña, foto)
    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'sede' => ['required', Rule::in(['San Miguel', 'Usulutan'])],
            'foto_perfil' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'current_password' => 'nullable|required_with:new_password|current_password',
            'new_password' => 'nullable|min:6|confirmed',
        ]);

        $user->name = $validated['name'];
        $user->sede = $validated['sede'];

        if ($request->filled('new_password')) {
            $user->password = Hash::make($validated['new_password']);
        }

        if ($request->hasFile('foto_perfil')) {
            if ($user->foto_perfil) {
                Storage::disk('public')->delete($user->foto_perfil);
            }
            $user->foto_perfil = $request->file('foto_perfil')->store('perfiles', 'public');
        }

        $user->save();
        return redirect()->route('profile.edit')->with('success', 'Perfil actualizado.');
    }

    // Subir solo foto de perfil (desde el dashboard)
    public function updatePhoto(Request $request)
    {
        $request->validate([
            'foto_perfil' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $user = Auth::user();
        if ($user->foto_perfil) {
            Storage::disk('public')->delete($user->foto_perfil);
        }
        $user->foto_perfil = $request->file('foto_perfil')->store('perfiles', 'public');
        $user->save();

        return back()->with('success', 'Foto de perfil actualizada.');
    }

    // Eliminar cuenta propia
    public function destroy(Request $request)
    {
        $request->validate(['password' => ['required', 'current_password']]);

        $user = Auth::user();
        if ($user->foto_perfil) {
            Storage::disk('public')->delete($user->foto_perfil);
        }
        $user->delete();

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/')->with('success', 'Cuenta eliminada.');
    }

    /**
     * Mostrar los últimos mensajes recibidos en el perfil.
     */
    public function messages()
    {
        $mensajes = Mensaje::where('receptor_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->take(5) // últimos 5 mensajes
            ->get();

        return view('profile.mensajes', compact('mensajes'));
    }
}