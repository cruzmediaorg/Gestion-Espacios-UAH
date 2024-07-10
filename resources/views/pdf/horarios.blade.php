<head>
<script src="https://cdn.tailwindcss.com"></script>

</head>
<div class="container mx-auto p-6">
  <div class="w-full flex flex-col justify-center  items-center">
  <h1 class="text-2xl font-bold mb-4">Horarios de clase | Reservas</h1>
    <img src="https://secuah.web.uah.es/2017/wp-content/uploads/2017/02/image4.png" alt="logo" class=" w-48 mb-4">
  </div>

    <div class="flex justify-between items-center mb-4">
        <div>
            <p class="font-bold">Curso: {{ $curso->nombre }}</p>
            <p class="font-bold">Periodo: {{ $curso->periodo->nombre }}</p>
            <p class="font-bold">Docente(s): {{ $curso->docentes->pluck('name')->implode(', ') }}</p>
        </div>
        <div>
            <p class="font-bold">Fecha de impresión: {{ now() }}</p>
        </div>
    </div>

    <table class="min-w-full bg-white border border-gray-300">
        <thead>
            <tr class="bg-gray-100">
                <th class="py-2 px-4 border-b ">Fecha</th>
                <th class="py-2 px-4 border-b">Horario</th>
                <th class="py-2 px-4 border-b">Espacio</th>
                <th class="py-2 px-4 border-b">Curso</th>
                <th class="py-2 px-4 border-b">Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($curso->reservas as $reserva)
                <tr>
                <td class="py-2 px-4 border-b ">{{ $reserva->dia }} </td>

                    <td class="py-2 px-4 border-b">{{ $reserva->hora_inicio }} - {{ $reserva->hora_fin }}</td>
                    <td class="py-2 px-4 border-b">{{ $reserva->reservas[0]->nombre}}</td>

                    <td class="py-2 px-4 border-b">{{ $curso->periodo->nombre }}</td>
                    <td class="py-2 px-4 border-b uppercase" style="color: {{ $reserva->reservas[0]->estado == 'aprobada' ? 'green' : 'red' }}">
                       {{$reserva->reservas[0]->estado}}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

</div>