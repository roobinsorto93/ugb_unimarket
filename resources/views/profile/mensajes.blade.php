@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-8 rounded-2xl shadow-lg">
    <h2 class="text-2xl font-bold mb-4">Últimos mensajes</h2>

    @forelse($mensajes as $m)
        <div class="border-b py-2">
            <p><strong>{{ $m->emisor->name }}</strong> sobre <em>{{ $m->publicacion->titulo }}</em></p>
            <p>{{ Str::limit($m->contenido, 100) }}</p>
            <p class="text-gray-500 text-sm">{{ $m->created_at->diffForHumans() }}</p>
        </div>
    @empty
        <p>No hay mensajes recientes.</p>
    @endforelse

    <div class="mt-4">
        <a href="{{ route('mensajes.inbox') }}" class="text-blue-600">Ver todos los mensajes →</a>
    </div>
    <div class="mt-4">
        <a href="{{ route('profile.edit') }}" class="text-gray-500">← Volver al perfil</a>
    </div>
</div>
@endsection