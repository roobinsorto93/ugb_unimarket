@extends('layouts.app')
@section('content')
<div class="max-w-2xl mx-auto bg-white p-8 rounded-2xl shadow-lg">
    <h2 class="text-2xl font-bold mb-6">Nueva publicación</h2>
    <form method="POST" action="{{ route('publicaciones.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="mb-4"><label class="block font-bold">Categoría</label><select name="categoria" class="w-full border rounded-lg p-2"><option value="Comida">Comida</option><option value="Apuntes">Apuntes</option><option value="Servicios">Servicios</option></select></div>
        <div class="mb-4"><label class="block font-bold">Título</label><input type="text" name="titulo" value="{{ old('titulo') }}" class="w-full border rounded-lg p-2"></div>
        <div class="mb-4"><label class="block font-bold">Descripción</label><textarea name="descripcion" rows="4" class="w-full border rounded-lg p-2">{{ old('descripcion') }}</textarea></div>
        <div class="mb-4"><label class="block font-bold">Precio (opcional)</label><input type="number" name="precio" step="0.01" placeholder="Ej: 10.00" value="{{ old('precio') }}" class="w-full border rounded-lg p-2"></div>
        <div class="mb-4"><label class="block font-bold">Imagen (opcional)</label><div class="relative"><input type="file" name="imagen" id="imagen" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"><button type="button" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg cursor-pointer pointer-events-none">📁 Seleccionar archivo</button><span id="nombreArchivo" class="ml-2 text-gray-500">Ningún archivo seleccionado</span></div></div>
        <div class="flex justify-between"><a href="{{ route('dashboard') }}" class="bg-gray-400 text-white px-4 py-2 rounded-lg">Cancelar</a><button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg">Publicar</button></div>
    </form>
</div>
<script>document.getElementById('imagen').addEventListener('change',function(e){var f=e.target.files[0]?e.target.files[0].name:'Ningún archivo seleccionado';document.getElementById('nombreArchivo').innerText=f;});</script>
@endsection