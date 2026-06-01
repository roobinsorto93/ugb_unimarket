@extends('layouts.app')
@section('content')
<div class="max-w-2xl mx-auto bg-white p-8 rounded-2xl shadow-lg">
    <h2 class="text-2xl font-bold mb-4">Mensaje</h2>
    <p><strong>De:</strong> {{ $mensaje->emisor->name }}</p>
    <p><strong>Publicación:</strong> <a href="{{ route('dashboard') }}?search={{ urlencode($mensaje->publicacion->titulo) }}" class="text-blue-600">{{ $mensaje->publicacion->titulo }}</a></p>
    <hr class="my-3">
    <div class="bg-gray-100 p-4 rounded">{{ $mensaje->contenido }}</div>
    <p class="text-gray-400 text-sm mt-2">Recibido: {{ $mensaje->created_at->format('d/m/Y H:i') }}</p>
    <div class="mt-4 flex space-x-2">
        <a href="{{ route('mensajes.reply', $mensaje) }}" class="bg-green-500 text-white px-4 py-2 rounded-lg">Responder</a>
        <a href="{{ route('mensajes.inbox') }}" class="bg-gray-400 text-white px-4 py-2 rounded-lg">Volver</a>
    </div>
</div>
@endsection