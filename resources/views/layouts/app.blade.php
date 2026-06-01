<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mural UGB</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body { background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%); min-height: 100vh; }
        .animate-fade-in { animation: fadeIn 0.6s ease-out; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(-10px); } to { opacity: 1; transform: translateY(0); } }
        .card-hover:hover { transform: scale(1.02); transition: transform 0.2s; }
        .btn-glow:hover { box-shadow: 0 0 12px rgba(66, 153, 225, 0.5); }
        .logo-text { font-weight: bold; background: linear-gradient(45deg, #1e3c72, #2a5298); -webkit-background-clip: text; background-clip: text; color: transparent; }
    </style>
</head>
<body>
    <nav class="bg-white shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center space-x-3">
                    <img src="{{ asset('images/logo-ugb.png') }}" alt="UGB Logo" class="h-10 w-10 object-contain">
                    <span class="logo-text text-xl">Universidad Gerardo Barrios</span>
                </div>
                @auth
                <div class="flex items-center space-x-4">
                    <span class="text-gray-700">{{ Auth::user()->name }} ({{ Auth::user()->sede }})</span>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg transition btn-glow">Salir</button>
                    </form>
                </div>
                @endauth
            </div>
        </div>
    </nav>
    <main class="py-8 animate-fade-in">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if(session('success')) <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-lg">{{ session('success') }}</div> @endif
            @if(session('error')) <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-lg">{{ session('error') }}</div> @endif
            @yield('content')
        </div>
    </main>
</body>
</html>