@extends('layouts.app')

@section('content')
<div class="flex flex-col lg:flex-row gap-8">
    <!-- Panel izquierdo -->
    <div class="lg:w-1/3 space-y-6">
        <div class="bg-white p-6 rounded-2xl shadow-md text-center">
            @if(Auth::user()->foto_perfil)
                <img src="{{ Storage::url(Auth::user()->foto_perfil) }}" class="w-28 h-28 rounded-full mx-auto object-cover border-4 border-blue-400">
            @else
                <div class="w-28 h-28 rounded-full bg-gray-300 mx-auto flex items-center justify-center text-4xl"><i class="fas fa-user"></i></div>
            @endif
            <h3 class="text-xl font-bold mt-3">{{ Auth::user()->name }}</h3>
            <p class="text-gray-500">{{ Auth::user()->sede }}</p>
            <div class="mt-4">
                <a href="{{ route('profile.edit') }}" class="inline-block bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg w-full">Editar perfil</a>
            </div>
            <!-- Botón Mis mensajes con contador -->
            <div class="mt-2">
                <a href="{{ route('mensajes.inbox') }}" class="inline-block bg-purple-500 hover:bg-purple-600 text-white px-4 py-2 rounded-lg w-full">
                    <i class="fas fa-envelope"></i> Mis mensajes
                    @if(isset($nuevosMensajes) && $nuevosMensajes > 0)
                        <span class="bg-red-500 text-white text-xs rounded-full px-2 py-1 ml-2">{{ $nuevosMensajes }}</span>
                    @endif
                </a>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-md text-center">
            <a href="{{ route('publicaciones.create') }}" class="block bg-green-500 hover:bg-green-600 text-white py-3 rounded-lg">+ Crear anuncio</a>
        </div>
    </div>

    <!-- Panel derecho -->
    <div class="lg:w-2/3">
        <h2 class="text-2xl font-bold mb-4">📢 Mural de anuncios</h2>

        <!-- Filtros y búsqueda -->
        <div class="bg-white p-4 rounded-lg shadow mb-6">
            <form method="GET" action="{{ route('dashboard') }}" class="flex flex-wrap gap-3">
                <input type="text" name="search" placeholder="Buscar..." value="{{ $searchActual ?? '' }}" class="flex-1 border rounded-lg p-2">
                <select name="categoria" class="border rounded-lg p-2">
                    <option value="">Todas</option>
                    <option value="Comida" {{ ($categoriaActual ?? '') == 'Comida' ? 'selected' : '' }}>Comida</option>
                    <option value="Apuntes" {{ ($categoriaActual ?? '') == 'Apuntes' ? 'selected' : '' }}>Apuntes</option>
                    <option value="Servicios" {{ ($categoriaActual ?? '') == 'Servicios' ? 'selected' : '' }}>Servicios</option>
                </select>
                <select name="sede" class="border rounded-lg p-2">
                    <option value="ambas" {{ ($sedeActual ?? 'ambas') == 'ambas' ? 'selected' : '' }}>Ambas sedes</option>
                    <option value="San Miguel" {{ ($sedeActual ?? '') == 'San Miguel' ? 'selected' : '' }}>San Miguel</option>
                    <option value="Usulutan" {{ ($sedeActual ?? '') == 'Usulutan' ? 'selected' : '' }}>Usulután</option>
                </select>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg">Filtrar</button>
                <a href="{{ route('dashboard') }}" class="bg-gray-400 text-white px-4 py-2 rounded-lg">Limpiar</a>
            </form>
        </div>

        @forelse($publicaciones as $pub)
        <div class="bg-white rounded-2xl shadow-lg mb-6 overflow-hidden card-hover">
            @if($pub->imagen) <img src="{{ Storage::url($pub->imagen) }}" class="w-full h-64 object-cover"> @endif
            <div class="p-5">
                <div class="flex justify-between items-start">
                    <div>
                        <span class="inline-block px-3 py-1 text-sm rounded-full bg-blue-100 text-blue-700">{{ $pub->categoria }}</span>
                        <h3 class="text-2xl font-bold mt-2">{{ $pub->titulo }}</h3>
                    </div>
                    @if($pub->user_id == Auth::id())
                        <div class="flex space-x-2">
                            <a href="{{ route('publicaciones.edit', $pub) }}" class="text-yellow-500"><i class="fas fa-edit"></i></a>
                            <form method="POST" action="{{ route('publicaciones.destroy', $pub) }}" onsubmit="return confirm('¿Eliminar?')">
                                @csrf @method('DELETE')
                                <button class="text-red-500"><i class="fas fa-trash-alt"></i></button>
                            </form>
                        </div>
                    @endif
                </div>
                <p class="text-gray-700 mt-3">{{ $pub->descripcion }}</p>
                @if($pub->precio)
                    <div class="mt-2 text-lg font-bold text-green-700">💰 Precio: ${{ number_format($pub->precio, 2) }}</div>
                @endif

                <!-- === CALIFICACIONES (estrellas) === -->
                <div class="mt-3 flex justify-between items-center border-t pt-3">
                    <div class="flex items-center">
                        @php
                            $prom = $pub->promedioCalificacion();
                            $total = $pub->totalCalificaciones();
                            $userRating = $pub->calificaciones()->where('user_id', Auth::id())->first();
                        @endphp
                        @for($i = 1; $i <= 5; $i++)
                            @if($prom >= $i)
                                <i class="fas fa-star text-yellow-400"></i>
                            @elseif($prom > $i-1 && $prom < $i)
                                <i class="fas fa-star-half-alt text-yellow-400"></i>
                            @else
                                <i class="far fa-star text-yellow-400"></i>
                            @endif
                        @endfor
                        <span class="ml-1 text-sm text-gray-600">({{ $total }} valoraciones)</span>
                    </div>
                    @if(Auth::id() !== $pub->user_id && !$userRating)
                        <form action="{{ route('publicaciones.calificar', $pub) }}" method="POST" class="flex space-x-2">
                            @csrf
                            <select name="valor" class="border rounded px-2 py-1 text-sm">
                                <option value="1">1⭐</option>
                                <option value="2">2⭐</option>
                                <option value="3">3⭐</option>
                                <option value="4">4⭐</option>
                                <option value="5">5⭐</option>
                            </select>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white text-xs px-3 py-1 rounded">Calificar</button>
                        </form>
                    @elseif($userRating)
                        <span class="text-green-600 text-sm">✔️ Calificado: {{ $userRating->valor }} estrella(s)</span>
                    @endif
                </div>

                <!-- Botón comprar/contactar (solo si no es el dueño) -->
                @if(Auth::id() !== $pub->user_id)
                    <div class="mt-3">
                        <a href="{{ route('comprar.form', $pub) }}" class="inline-block bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">
                            <i class="fas fa-shopping-cart"></i> Comprar / Contactar
                        </a>
                    </div>
                @endif

                <div class="mt-2 text-sm text-gray-400">
                    📌 {{ $pub->user->name }} ({{ $pub->user->sede }}) • {{ $pub->created_at->diffForHumans() }}
                </div>
            </div>
        </div>
        @empty
            <div class="bg-white p-8 text-center text-gray-500">No hay publicaciones aún. ¡Sé el primero!</div>
        @endforelse

        <div class="mt-4">{{ $publicaciones->appends(request()->query())->links() }}</div>
    </div>
</div>
@endsection