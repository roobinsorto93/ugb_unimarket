<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mural UGB</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
        }
        .btn-glow:hover {
            box-shadow: 0 0 12px rgba(66, 153, 225, 0.5);
        }
    </style>
</head>
<body>
    <div class="min-h-screen flex flex-col justify-center items-center pt-6 sm:pt-0">
        <div class="mb-6 text-center">
            <!-- Logo con ruta DIRECTA (cambia 'images' por 'image' si es necesario) -->
            <img src="{{ asset('images/logo-ugb.png') }}" alt="Logo Universidad Gerardo Barrios" class="h-20 mx-auto">
            <span class="logo-text text-2xl font-bold block mt-2" style="background: linear-gradient(45deg, #1e3c72, #2a5298); -webkit-background-clip: text; background-clip: text; color: transparent;">Universidad Gerardo Barrios</span>
        </div>
        {{ $slot }}
    </div>
</body>
</html>
