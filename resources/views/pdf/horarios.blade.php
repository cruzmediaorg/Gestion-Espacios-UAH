<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Horarios de clase | Reservas</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-6 bg-white shadow-lg rounded-lg">
        <div class="w-full flex flex-col justify-center items-center mb-6">
            <h1 class="text-3xl font-bold mb-4 text-gray-800">Horarios de clase | Reservas</h1>
            <img src="https://secuah.web.uah.es/2017/wp-content/uploads/2017/02/image4.png" alt="logo" class="w-48 mb-4">
        </div>

        <div class="flex justify-between items-start mb-6">
            <div class="space-y-1">
                <p class="font-semibold text-gray-700">Curso: <span class="font-normal">{{ $curso->nombre }}</span></p>
                <p class="font-semibold text-gray-700">Periodo: <span class="font-normal">{{ $curso->periodo->nombre }}</span></p>
                <p class="font-semibold text-gray-700">Docente(s): <span class="font-normal">{{ $curso->docentes->pluck('name')->implode(', ') }}</span></p>
            </div>
            <div>
                <p class="font-semibold text-gray-700">Fecha de impresión: <span class="font-normal">{{ now()->format('d/m/Y H:i') }}</span></p>
            </div>
        </div>

        <table class="min-w-full bg-white border border-gray-300">
            <thead>
                <tr class="bg-gray-200">
                    <th class="py-2 px-4 border-b text-left text-gray-700">Fecha</th>
                    <th class="py-2 px-4 border-b text-left text-gray-700">Horario</th>
                    <th class="py-2 px-4 border-b text-left text-gray-700">Espacio</th>
                    <th class="py-2 px-4 border-b text-left text-gray-700">Curso</th>
                    <th class="py-2 px-4 border-b text-left text-gray-700">Estado</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($curso->reservas as $reserva)
                    <tr class="hover:bg-gray-50">
                        <td class="py-2 px-4 border-b">{{ $reserva->dia }}</td>
                        <td class="py-2 px-4 border-b">{{ $reserva->hora_inicio }} - {{ $reserva->hora_fin }}</td>
                        <td class="py-2 px-4 border-b">{{ $reserva->reservas[0]->nombre }}</td>
                        <td class="py-2 px-4 border-b">{{ $curso->periodo->nombre }}</td>
                        <td class="py-2 px-4 border-b">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full uppercase
                                {{ $reserva->reservas[0]->estado === 'aprobada' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $reserva->reservas[0]->estado }}
                            </span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>