@extends('layouts.app')
@section('content')
<div class="max-w-4xl mx-auto bg-white p-8 rounded-2xl shadow-lg">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">Mis mensajes</h2>
        <div class="space-x-2">
            <a href="{{ route('mensajes.inbox') }}" class="bg-purple-500 text-white px-4 py-2 rounded-lg {{ request()->routeIs('mensajes.inbox') ? 'opacity-100' : 'opacity-70' }}">Recibidos</a>
            <a href="{{ route('mensajes.sent') }}" class="bg-blue-500 text-white px-4 py-2 rounded-lg">Enviados</a>
        </div>
    </div>

    @forelse($mensajes as $m)
        <div class="border-b py-3 flex justify-between items-center">
            <div>
                <p><strong>De:</strong> {{ $m->emisor->name }} ({{ $m->emisor->sede }})</p>
                <p><strong>Publicación:</strong> {{ $m->publicacion->titulo }}</p>
                <p class="text-gray-500">{{ $m->created_at->diffForHumans() }}</p>
                <p class="{{ $m->leido ? 'text-gray-600' : 'font-bold text-blue-600' }}">
                    {{ Str::limit($m->contenido, 80) }}
                </p>
            </div>
            <div class="flex space-x-2">
                <a href="{{ route('mensajes.show', $m) }}" class="bg-blue-500 text-white px-3 py-1 rounded">Ver</a>
                <a href="{{ route('mensajes.reply', $m) }}" class="bg-green-500 text-white px-3 py-1 rounded">Responder</a>
            </div>
        </div>
    @empty
        <p>No hay mensajes recibidos.</p>
    @endforelse
    {{ $mensajes->links() }}
    <div class="mt-4"><a href="{{ route('dashboard') }}" class="text-blue-600">← Volver al inicio</a></div>
</div>
@endsection