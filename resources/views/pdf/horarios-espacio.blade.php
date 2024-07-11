<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Horarios del Espacio</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-4xl mx-auto bg-white shadow-lg rounded-lg overflow-hidden">
        <div class="p-6">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-3xl font-bold text-gray-800">Horarios del Espacio</h1>
                <img src="https://secuah.web.uah.es/2017/wp-content/uploads/2017/02/image4.png" alt="logo" class="w-40">
            </div>
            
            <div class="mb-6">
                <h2 class="text-2xl font-semibold text-gray-700">{{ $espacio->nombre }}</h2>
                <p class="text-lg text-gray-600">Período: {{ $periodo }}</p>
            </div>
            
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="px-4 py-2 text-left text-gray-700">Fecha</th>
                        <th class="px-4 py-2 text-left text-gray-700">Hora Inicio</th>
                        <th class="px-4 py-2 text-left text-gray-700">Hora Fin</th>
                        <th class="px-4 py-2 text-left text-gray-700">Asignado a</th>
                        <th class="px-4 py-2 text-left text-gray-700">Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($espacio->reservas as $reserva)
                        <tr class="border-b border-gray-200 hover:bg-gray-50">
                            <td class="px-4 py-2">{{ $reserva->fecha }}</td>
                            <td class="px-4 py-2">{{ $reserva->hora_inicio }}</td>
                            <td class="px-4 py-2">{{ $reserva->hora_fin }}</td>
                            <td class="px-4 py-2">{{ $reserva->curso }}</td>
                            <td class="px-4 py-2">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full uppercase
                                    {{ $reserva->estado === 'aprobada' ? 'bg-green-100 text-green-800' : 
                                       ($reserva->estado === 'pendiente' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                    {{ $reserva->estado }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>