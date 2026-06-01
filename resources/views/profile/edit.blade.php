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

        <div class="mb-4">
            <label class="block font-bold">Nombre completo</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="w-full border rounded-lg p-2">
            @error('name') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label class="block font-bold">Sede</label>
            <select name="sede" required class="w-full border rounded-lg p-2">
                <option value="San Miguel" {{ $user->sede == 'San Miguel' ? 'selected' : '' }}>San Miguel</option>
                <option value="Usulutan" {{ $user->sede == 'Usulutan' ? 'selected' : '' }}>Usulután</option>
            </select>
            @error('sede') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label class="block font-bold">Foto de perfil</label>
            @if($user->foto_perfil)
                <img src="{{ Storage::url($user->foto_perfil) }}" class="h-20 w-20 rounded-full object-cover mb-2">
            @endif
            <div class="relative mt-2">
                <input type="file" name="foto_perfil" id="foto_perfil" accept="image/jpeg,image/png,image/jpg" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                <button type="button" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg cursor-pointer pointer-events-none">
                    📁 Seleccionar archivo
                </button>
                <span id="nombreArchivo" class="ml-2 text-gray-500">Ningún archivo seleccionado</span>
            </div>
            <p class="text-xs text-gray-500 mt-1">Formatos permitidos: JPG, JPEG, PNG. Tamaño máximo: 2MB.</p>
            @error('foto_perfil') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
        </div>

        <hr class="my-4">

        <h3 class="text-lg font-bold mb-3">Cambiar contraseña</h3>
        <div class="mb-3">
            <label class="block">Contraseña actual (requerido para cambios)</label>
            <input type="password" name="current_password" class="w-full border rounded-lg p-2">
            @error('current_password') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
        </div>
        <div class="mb-3">
            <label class="block">Nueva contraseña</label>
            <input type="password" name="new_password" class="w-full border rounded-lg p-2">
        </div>
        <div class="mb-3">
            <label class="block">Confirmar nueva contraseña</label>
            <input type="password" name="new_password_confirmation" class="w-full border rounded-lg p-2">
        </div>
        @error('new_password') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror

        <div class="flex justify-between items-center mt-6">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg">Guardar cambios</button>
            <a href="{{ route('dashboard') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg">Volver al inicio</a>
        </div>
    </form>

    <!-- Botón Mis mensajes con contador (sin modificar controlador) -->
    @php
        $nuevos = \App\Models\Mensaje::where('receptor_id', Auth::id())->where('leido', false)->count();
    @endphp
    <div class="mt-6 text-center">
        <a href="{{ route('mensajes.inbox') }}" class="inline-block bg-purple-500 hover:bg-purple-600 text-white px-4 py-2 rounded-lg w-full">
            <i class="fas fa-envelope"></i> Mis mensajes
            @if($nuevos > 0)
                <span class="bg-red-500 text-white text-xs rounded-full px-2 py-1 ml-2">{{ $nuevos }}</span>
            @endif
        </a>
    </div>

    <!-- Eliminar cuenta -->
    <hr class="my-6">
    <div class="bg-red-50 p-4 rounded-lg">
        <h3 class="text-red-700 font-bold">Zona peligrosa</h3>
        <p class="text-sm text-red-600 mb-3">Eliminar tu cuenta borrará todas tus publicaciones, calificaciones y datos. Esta acción no se puede deshacer.</p>
        <form method="POST" action="{{ route('profile.destroy') }}" onsubmit="return confirm('¿Estás seguro? No se puede deshacer.');">
            @csrf
            @method('DELETE')
            <div class="mb-3">
                <label class="block text-sm">Confirma tu contraseña</label>
                <input type="password" name="password" required class="border rounded-lg p-2 w-full md:w-64">
                @error('password') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
            </div>
            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg">Eliminar mi cuenta</button>
        </form>
    </div>
</div>

<script>
    const input = document.getElementById('foto_perfil');
    const spanNombre = document.getElementById('nombreArchivo');
    if (input) {
        input.addEventListener('change', function(e) {
            const fileName = e.target.files[0] ? e.target.files[0].name : 'Ningún archivo seleccionado';
            spanNombre.innerText = fileName;
        });
    }
</script>
@endsection