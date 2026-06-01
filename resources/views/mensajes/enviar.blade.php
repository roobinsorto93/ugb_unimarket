@extends('layouts.app')
@section('content')
<div class="max-w-2xl mx-auto bg-white p-8 rounded-2xl shadow-lg">
    <h2 class="text-2xl font-bold mb-4">Contactar al vendedor</h2>
    <p><strong>Producto:</strong> {{ $publicacion->titulo }}</p>
    <p><strong>Vendedor:</strong> {{ $publicacion->user->name }} ({{ $publicacion->user->sede }})</p>
    <hr class="my-4">
    <form method="POST" action="{{ route('enviar.mensaje') }}">
        @csrf
        <input type="hidden" name="receptor_id" value="{{ $publicacion->user_id }}">
        <input type="hidden" name="publicacion_id" value="{{ $publicacion->id }}">
        <div class="mb-4">
            <label class="block font-bold">Tu mensaje</label>
            <textarea name="contenido" rows="5" class="w-full border rounded p-2" placeholder="Escribe tu consulta o propuesta..." required></textarea>
        </div>
        <div class="flex justify-between">
            <a href="{{ route('dashboard') }}" class="bg-gray-400 text-white px-4 py-2 rounded-lg">Cancelar</a>
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg">Enviar mensaje</button>
        </div>
    </form>
</div>
@endsection