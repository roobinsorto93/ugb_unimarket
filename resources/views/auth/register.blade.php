@extends('layouts.app')
@section('content')
<div class="flex justify-center items-center min-h-[80vh]">
    <div class="bg-white rounded-2xl shadow-2xl p-8 w-full max-w-md">
        <div class="text-center mb-6">
            <img src="{{ asset('images/logo-ugb.png') }}" class="h-20 mx-auto" alt="Logo UGB">
            <h2 class="text-3xl font-bold text-gray-800">Registro</h2>
            <p class="text-gray-500">Únete a la comunidad UGB</p>
        </div>

        <!-- Mostrar errores generales -->
        @if(session('error'))
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        <!-- Mostrar errores de validación -->
        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="mb-3">
                <label class="block font-bold">Nombre completo</label>
                <input type="text" name="name" value="{{ old('name') }}" required
                       class="w-full border rounded-lg p-2 @error('name') border-red-500 @enderror">
                @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-3">
                <label class="block font-bold">Correo (@ugb.edu.sv)</label>
                <input type="email" name="email" value="{{ old('email') }}" required
                       class="w-full border rounded-lg p-2 @error('email') border-red-500 @enderror">
                @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-3">
                <label class="block font-bold">Sede</label>
                <select name="sede" required class="w-full border rounded-lg p-2">
                    <option value="San Miguel" {{ old('sede') == 'San Miguel' ? 'selected' : '' }}>San Miguel</option>
                    <option value="Usulutan" {{ old('sede') == 'Usulutan' ? 'selected' : '' }}>Usulután</option>
                </select>
                @error('sede') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-3">
                <label class="block font-bold">Contraseña</label>
                <input type="password" name="password" required
                       class="w-full border rounded-lg p-2 @error('password') border-red-500 @enderror">
                @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label class="block font-bold">Confirmar contraseña</label>
                <input type="password" name="password_confirmation" required class="w-full border rounded-lg p-2">
            </div>

            <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white py-2 rounded-lg">
                Registrarse
            </button>
        </form>

        <p class="text-center mt-4">
            ¿Ya tienes cuenta? <a href="{{ route('login') }}" class="text-blue-600 hover:underline">Inicia sesión</a>
        </p>
    </div>
</div>
@endsection