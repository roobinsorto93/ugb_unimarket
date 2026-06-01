@extends('layouts.app')
@section('content')
<div class="flex justify-center items-center min-h-[80vh]">
    <div class="bg-white rounded-2xl shadow-2xl p-8 w-full max-w-md">
        <div class="text-center mb-6">
            <img src="{{ asset('images/logo-ugb.png') }}" class="h-20 mx-auto" alt="Logo UGB">
            <h2 class="text-3xl font-bold text-gray-800">Iniciar Sesión</h2>
            <p class="text-gray-500">Ingresa con tu correo @ugb.edu.sv</p>
        </div>
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">Correo institucional</label>
                <input type="email" name="email" value="{{ old('email') }}" required class="w-full border rounded-lg p-2">
                @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div class="mb-6">
                <label class="block text-gray-700 font-bold mb-2">Contraseña</label>
                <input type="password" name="password" required class="w-full border rounded-lg p-2">
            </div>
            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 rounded-lg">Ingresar</button>
        </form>
        <p class="text-center mt-4">¿Sin cuenta? <a href="{{ route('register') }}" class="text-blue-600 hover:underline">Regístrate aquí</a></p>
    </div>
</div>
@endsection