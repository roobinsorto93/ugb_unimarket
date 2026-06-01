@extends('layouts.app')
@section('content')
<div class="max-w-2xl mx-auto bg-white p-8 rounded-2xl shadow-lg">
    <h2 class="text-2xl font-bold mb-4">Responder mensaje</h2>
    <p><strong>Para:</strong> {{ $mensaje->emisor->name }}</p>
    <p><strong>Sobre publicación:</strong> {{ $mensaje->publicacion->titulo }}</p>
    <p><strong>Mensaje original:</strong></p>
    <div class="bg-gray-100 p-3 rounded mb-4">“{{ $mensaje->contenido }}”</div>
    <form method="POST" action="{{ route('enviar.mensaje') }}">
        @csrf
        <input type="hidden" name="receptor_id" value="{{ $mensaje->emisor->id }}">
        <input type="hidden" name="publicacion_id" value="{{ $mensaje->publicacion->id }}">
        <div class="mb-4">
            <label class="block font-bold">Tu respuesta</label>
            <textarea name="contenido" rows="5" class="w-full border rounded p-2" required></textarea>
        </div>
        <div class="flex justify-between">
            <a href="{{ route('mensajes.inbox') }}" class="bg-gray-400 text-white px-4 py-2 rounded-lg">Cancelar</a>
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg">Enviar respuesta</button>
        </div>
    </form>
</div>
@endsection