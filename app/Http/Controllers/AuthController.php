<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\LoginLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{
    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        // Convertir email a minúsculas y eliminar espacios
        $request->merge([
            'email' => strtolower(trim($request->email)),
            'name' => trim($request->name)
        ]);

        // Validaciones
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|ends_with:@ugb.edu.sv|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'sede' => ['required', Rule::in(['San Miguel', 'Usulutan'])],
        ]);

        try {
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'sede' => $validated['sede'],
            ]);

            if ($user) {
                return redirect()->route('login')->with('success', 'Registro exitoso. Ahora inicia sesión.');
            } else {
                return back()->with('error', 'Error al crear el usuario. Intente nuevamente.');
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Error en el servidor: ' . $e->getMessage())->withInput();
        }
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email|ends_with:@ugb.edu.sv',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->remember)) {
            $request->session()->regenerate();
            $user = User::where('email', $credentials['email'])->first();
            LoginLog::create([
                'user_id' => $user->id,
                'email' => $credentials['email'],
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'success' => true,
            ]);
            return redirect()->intended(route('dashboard'));
        }

        LoginLog::create([
            'user_id' => null,
            'email' => $credentials['email'],
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'success' => false,
        ]);

        return back()->withErrors(['email' => 'Credenciales incorrectas.'])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}