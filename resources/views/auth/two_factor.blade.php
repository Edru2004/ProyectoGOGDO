<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificación de Seguridad - GDO</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#0f1a14] flex items-center justify-center min-h-screen">
    <div class="bg-[#1a2e23] p-8 rounded-3xl shadow-2xl w-full max-w-md border border-[#2d4a3a]">
        <div class="text-center mb-6">
            <h2 class="text-white text-2xl font-bold">Verificación de 2 Pasos</h2>
            <p class="text-gray-400 mt-2">Ingresa el código que enviamos a tu correo</p>
        </div>

        <form action="{{ route('verify.store') }}" method="POST" class="space-y-6">
            @csrf
            <div>
                <input type="text" name="two_factor_code" placeholder="Ej: 123456" required
                    class="w-full px-4 py-3 rounded-xl bg-[#0f1a14] border border-[#2d4a3a] text-white text-center text-2xl tracking-widest focus:outline-none focus:border-green-500">
                @if($errors->has('two_factor_code'))
                    <p class="text-red-500 text-sm mt-2 text-center">{{ $errors->first('two_factor_code') }}</p>
                @endif
            </div>

            <button type="submit" 
                class="w-full py-3 px-4 bg-[#2d4a3a] hover:bg-green-700 text-white font-bold rounded-full transition duration-300 uppercase tracking-wider">
                Verificar Código
            </button>
        </form>

        <div class="mt-6 text-center">
            <a href="{{ route('estudiante.login') }}" class="text-gray-500 text-sm hover:underline">Cancelar e ir al inicio</a>
        </div>
    </div>
</body>
</html>