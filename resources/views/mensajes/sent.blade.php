@extends('layouts.app')
@section('content')
<div class="max-w-4xl mx-auto bg-white p-8 rounded-2xl shadow-lg">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">Mensajes enviados</h2>
        <div class="space-x-2">
            <a href="{{ route('mensajes.inbox') }}" class="bg-purple-500 text-white px-4 py-2 rounded-lg">Recibidos</a>
            <a href="{{ route('mensajes.sent') }}" class="bg-blue-500 text-white px-4 py-2 rounded-lg {{ request()->routeIs('mensajes.sent') ? 'opacity-100' : 'opacity-70' }}">Enviados</a>
        </div>
    </div>

    @forelse($mensajes as $m)
        <div class="border-b py-3">
            <p><strong>Para:</strong> {{ $m->receptor->name }} ({{ $m->receptor->sede }})</p>
            <p><strong>Publicación:</strong> {{ $m->publicacion->titulo }}</p>
            <p class="text-gray-500">{{ $m->created_at->diffForHumans() }}</p>
            <p>{{ Str::limit($m->contenido, 80) }}</p>
        </div>
    @empty
        <p>No has enviado mensajes aún.</p>
    @endforelse
    {{ $mensajes->links() }}
    <div class="mt-4"><a href="{{ route('dashboard') }}" class="text-blue-600">← Volver al inicio</a></div>
</div>
@endsection