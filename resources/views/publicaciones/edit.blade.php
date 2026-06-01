@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-8 rounded-2xl shadow-lg">
    <h2 class="text-2xl font-bold mb-6">Editar perfil</h2>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <!-- Campos del formulario... -->
        <div class="flex justify-between items-center mt-6">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg">Guardar cambios</button>
            <a href="{{ route('dashboard') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg">Volver al inicio</a>
        </div>
    </form>

    <!-- Enlace al buzón de mensajes -->
    <div class="mt-6 text-center">
        <a href="{{ route('mensajes.inbox') }}" class="inline-block bg-purple-500 hover:bg-purple-600 text-white px-4 py-2 rounded-lg w-full">
            <i class="fas fa-envelope"></i> Mis mensajes
        </a>
    </div>

    <!-- Eliminar cuenta -->
    <hr class="my-6">
    <div class="bg-red-50 p-4 rounded-lg">
        ...
    </div>
</div>
@endsection