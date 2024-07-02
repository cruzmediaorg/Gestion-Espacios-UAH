import { useForm } from '@inertiajs/react'
import { Label } from '@/Components/ui/label';
import * as React from "react"
import {
    Command,
    CommandEmpty,
    CommandGroup,
    CommandInput,
    CommandItem,
} from "@/Components/ui/command"
import {
    Popover,
    PopoverContent,
    PopoverTrigger,
} from "@/Components/ui/popover"
import { Check, ChevronsUpDown } from "lucide-react"
import { cn } from "@/lib/utils"
import { Button } from "@/Components/ui/button"
import { CommandList } from 'cmdk';

import { format } from "date-fns"
import { Calendar as CalendarIcon } from "lucide-react"

import { Calendar } from "@/Components/ui/calendar"

export default function Form({ isEdit = false, reserva = {}, espacios = {}, recursos = {}, usuarios = {} }) {

    const [openReservableType, setOpenReservableType] = React.useState(false)
    const [openReservableList, setOpenReservableList] = React.useState(false)
    const [openHorarioInicio, setOpenHorarioInicio] = React.useState(false)
    const [openHorarioFin, setOpenHorarioFin] = React.useState(false)

    const [selectedEspacio, setSelectedEspacio] = React.useState(null);

    const reservasTypes = [
        'Clase Práctica',
        'Clase Teórica',
        'TFG/TFM',
        'Reunión',
        'Examen',
        'Conferencia',
        'Consejo de Departamento',
        'Otro',
    ];

    const reservableTypes = [
        {
            value: 'App\\Models\\Espacio',
            label: 'Espacio'
        },
        {
            value: 'App\\Models\\Equipamiento',
            label: 'Equipamientos'
        }
    ];

    const { data, setData, put, post, processing, errors } = useForm({
        reservable_id: isEdit ? reserva.reservable_id : '',
        reservable_type: isEdit ? reserva.reservable_type : reservableTypes[0].value,
        asignado_a: isEdit ? reserva.asignado_a.id : '',
        fecha: isEdit ? reserva.fecha : '',
        hora_inicio: reserva.hora_inicio || '',
        hora_fin: reserva.hora_fin || '',
        tipo_reserva: isEdit ? reserva.tipo_reserva : reservasTypes[0],
    })

    function submit(e) {
        e.preventDefault()

        if (isEdit) {
            put(route('reservas.update', reserva.id))
        } else {
            post(route('reservas.store'))
        }
    }

    const horas = [
        '08:00', '09:00', '10:00', '11:00', '12:00',
        '13:00', '14:00', '15:00', '16:00', '17:00',
        '18:00', '19:00', '20:00', '21:00', '22:00',
    ];

    const horasDisponiblesInicio = () => {
        if (selectedEspacio) {
            const horariosOcupados = selectedEspacio.horarios_ocupados;
            const fecha = new Date(data.fecha).toISOString().split('T')[0];
            const horasOcupadas = horariosOcupados.filter(horario => horario.fecha === fecha);
            return horas.filter(hora => !horasOcupadas.some(horario => hora >= horario.hora_inicio && hora < horario.hora_fin));
        } else {
            return horas;
        }
    }

    const horasDisponiblesFin = () => {
        if (selectedEspacio && data.hora_inicio) {
            let horasFin = horas.filter(hora => hora > data.hora_inicio);

            if (selectedEspacio.horarios_ocupados?.length > 0) {
                const horariosOcupados = selectedEspacio.horarios_ocupados;
                const fecha = new Date(data.fecha).toISOString().split('T')[0];
                const horasOcupadas = horariosOcupados.filter(horario => horario.fecha === fecha);
                horasFin = horasFin.filter(hora => !horasOcupadas.some(horario => hora > horario.hora_inicio && hora <= horario.hora_fin));
            }

            return horasFin;
        }
    }

    const horariosOcupadosPorFecha = () => {
        if (selectedEspacio && selectedEspacio.horarios_ocupados?.length > 0 && data.fecha) {
            return selectedEspacio.horarios_ocupados.filter(horario => horario.fecha === new Date(data.fecha).toISOString().split('T')[0]);
        }
    }


    return (
        <div className="p-5">
            <h2 className="font-semibold text-xl text-gray-800 leading-tight">{isEdit ? 'Editar' : 'Nueva'} reserva</h2>
            <hr className="my-5" />
            {/* Horarios Ocupados Display */}
            {horariosOcupadosPorFecha()?.length > 0 && data.reservable_type === 'App\\Models\\Espacio' && (
                <div>
                    <h3 className="text-lg font-medium text-gray-700">Horarios ocupados:</h3>
                    <ul className='divide-y'>
                        {horariosOcupadosPorFecha()?.map((horario, index) => (
                            <li key={index} className='py-2'>
                                <span className='font-semibold'>{horario.fecha}</span> -<span className='text-red-500'> {horario.hora_inicio} a {horario.hora_fin}</span>
                            </li>
                        ))}

                    </ul>
                </div>
            )}
            <form onSubmit={submit}>
                <div className="flex flex-col gap-2 w-full">
                    <Label>Reservable</Label>
                    <Popover open={openReservableType} onOpenChange={setOpenReservableType}>
                        <PopoverTrigger asChild>
                            <Button variant="outline" role="combobox" aria-expanded={openReservableType} className="w-full max-w-[400px] justify-between">
                                {reservableTypes.find(t => t.value === data.reservable_type)?.label || "Seleccionar tipo de reservable"}
                                <ChevronsUpDown className="ml-2 h-4 w-4 shrink-0 opacity-50" />
                            </Button>
                        </PopoverTrigger>
                        <PopoverContent className="w-[200px] left-0 p-0">
                            <Command>
                                <CommandInput placeholder="Buscar..." />
                                <CommandEmpty>No se encontraron resultados</CommandEmpty>
                                <CommandGroup>
                                    <CommandList>
                                        {reservableTypes.map((type) => (
                                            <CommandItem
                                                key={type.value}
                                                value={type.value}
                                                onSelect={() => {
                                                    setData('reservable_type', type.value);
                                                    setOpenReservableType(false);
                                                }}
                                            >
                                                <Check className={cn("mr-2 h-4 w-4", data.reservable_type === type.value ? "opacity-100" : "opacity-0")} />
                                                {type.label}
                                            </CommandItem>
                                        ))}
                                    </CommandList>
                                </CommandGroup>
                            </Command>
                        </PopoverContent>
                    </Popover>
                    <Popover open={openReservableList} onOpenChange={setOpenReservableList}>
                        <PopoverTrigger asChild>
                            <Button variant="outline" role="combobox" aria-expanded={openReservableList} className="w-full max-w-[400px] justify-between">
                                {data.reservable_id ? (data.reservable_type === 'App\\Models\\Espacio' ? espacios.find(e => e.id === data.reservable_id)?.nombre : recursos.length > 0 ? recursos.find(r => r.id === data.reservable_id)?.nombre : 'Seleccionar reservable') : 'Seleccionar reservable'}
                                <ChevronsUpDown className="ml-2 h-4 w-4 shrink-0 opacity-50" />
                            </Button>
                        </PopoverTrigger>
                        <PopoverContent className="w-full p-0">
                            <Command>
                                <CommandInput placeholder="Buscar..." />
                                <CommandEmpty>No se encontraron resultados</CommandEmpty>
                                <CommandGroup>
                                    <CommandList>
                                        {data.reservable_type === 'App\\Models\\Espacio' ? espacios.map((espacio) => (
                                            <CommandItem
                                                key={espacio.id}
                                                value={espacio.id}
                                                onSelect={() => {
                                                    const selectedEspacio = espacios.find(e => e.id === espacio.id);
                                                    setData('reservable_id', espacio.id);
                                                    setSelectedEspacio(selectedEspacio);
                                                    setOpenReservableList(false);
                                                }}
                                            >
                                                <Check className={cn("mr-2 h-4 w-4", data.reservable_id === espacio.id ? "opacity-100 " : "opacity-0")} />
                                                {espacio.nombre}
                                            </CommandItem>
                                        )) : recursos.length > 0 ? recursos.map((recurso) => (
                                            <CommandItem
                                                key={recurso.id}
                                                value={recurso.id}
                                                onSelect={() => {
                                                    setData('reservable_id', recurso.id);
                                                    setOpenReservableList(false);
                                                }}
                                            >
                                                <Check className={cn("mr-2 h-4 w-4", data.reservable_id === recurso.id ? "opacity-100 " : "opacity-0")} />
                                                {recurso.nombre}
                                            </CommandItem>
                                        )) : <CommandItem>No hay recursos disponibles</CommandItem>}
                                    </CommandList>
                                </CommandGroup>
                            </Command>
                        </PopoverContent>
                    </Popover>
                    {
                        errors.reservable_id && <span className="text-red-500">{errors.reservable_id}</span>
                    }

                    <Label>A nombre de:</Label>
                    <Popover>
                        <PopoverTrigger asChild>
                            <Button
                                variant={"outline"}
                                className={cn(
                                    "w-[280px] justify-start text-left font-normal",
                                    !data.asignado_a && "text-muted-foreground"
                                )}
                            >
                                {data.asignado_a ? usuarios.find(u => u.id === data.asignado_a)?.name : <span>Selecciona un usuario</span>}
                            </Button>
                        </PopoverTrigger>
                        <PopoverContent className="w-auto p-0">
                            <Command>
                                <CommandInput placeholder="Buscar..." />
                                <CommandEmpty>No se encontraron resultados</CommandEmpty>
                                <CommandGroup>
                                    <CommandList>
                                        {usuarios.map((usuario) => (
                                            <CommandItem
                                                key={usuario.id}
                                                value={usuario.id}
                                                onSelect={() => {
                                                    setData('asignado_a', usuario.id);
                                                }}
                                            >
                                                <Check className={cn("mr-2 h-4 w-4", data.asignado_a === usuario.id ? "opacity-100 " : "opacity-0")} />
                                                {usuario.name}
                                            </CommandItem>
                                        ))}
                                    </CommandList>
                                </CommandGroup>
                            </Command>
                        </PopoverContent>
                    </Popover>

                    {
                        errors.asignado_a && <span className="text-red-500">{errors.asignado_a}</span>
                    }

                    <Label>Fecha</Label>

                    <Popover>
                        <PopoverTrigger asChild>
                            <Button
                                variant={"outline"}
                                className={cn(
                                    "w-[280px] justify-start text-left font-normal",
                                    !data.fecha && "text-muted-foreground"
                                )}
                            >
                                <CalendarIcon className="mr-2 h-4 w-4" />
                                {data.fecha ? format(new Date(data.fecha), "PPP") : <span>Selecciona una fecha</span>}
                            </Button>
                        </PopoverTrigger>
                        <PopoverContent className="w-auto p-0">
                            <div className="flex m-1">
                                <div className="flex-1"></div>
                                <Button
                                    variant="outline"
                                    onClick={() => {
                                        setData("fecha", new Date().toISOString());
                                    }}
                                >
                                    Hoy
                                </Button>
                            </div>
                            <Calendar
                                mode="single"
                                selected={data.fecha ? new Date(data.fecha) : new Date()}
                                onSelect={(date) => {
                                    setData("fecha", new Date(Date.UTC(date.getFullYear(), date.getMonth(), date.getDate())).toISOString());
                                    // cerrar

                                }}
                                initialFocus
                            />
                        </PopoverContent>
                    </Popover>

                    {
                        errors.fecha && <span className="text-red-500">{errors.fecha}</span>
                    }

                    {data.reservable_id && data.fecha && (
                        <div>
                            <Label>Hora de inicio</Label>
                            <Popover open={openHorarioInicio} onOpenChange={setOpenHorarioInicio}>
                                <PopoverTrigger asChild>
                                    <Button variant="outline" role="combobox" aria-expanded={openHorarioInicio} className="w-full max-w-[400px] justify-between">
                                        {data.hora_inicio ? data.hora_inicio : 'Seleccionar hora de inicio'}
                                        <ChevronsUpDown className="ml-2 h-4 w-4 shrink-0 opacity-50" />
                                    </Button>
                                </PopoverTrigger>
                                <PopoverContent className="w-full p-0">
                                    <Command>
                                        <CommandInput placeholder="Buscar..." />
                                        <CommandEmpty>No se encontraron resultados</CommandEmpty>
                                        <CommandGroup>
                                            <CommandList>
                                                {horasDisponiblesInicio().map((hora) => (
                                                    <CommandItem
                                                        key={hora}
                                                        value={hora}
                                                        onSelect={() => {
                                                            setData('hora_inicio', hora);
                                                            setOpenHorarioInicio(false);
                                                        }}
                                                    >
                                                        <Check className={cn("mr-2 h-4 w-4", data.hora_inicio === hora ? "opacity-100 " : "opacity-0")} />
                                                        {hora}
                                                    </CommandItem>
                                                ))}
                                            </CommandList>
                                        </CommandGroup>
                                    </Command>
                                </PopoverContent>
                            </Popover>

                            <div>
                                <Label>Hora de fin</Label>
                                <Popover open={openHorarioFin} onOpenChange={setOpenHorarioFin}>
                                    <PopoverTrigger asChild>
                                        <Button variant="outline" role="combobox" aria-expanded={openHorarioFin} className="w-full max-w-[400px] justify-between">
                                            {data.hora_fin ? data.hora_fin : 'Seleccionar hora de fin'}
                                            <ChevronsUpDown className="ml-2 h-4 w-4 shrink-0 opacity-50" />
                                        </Button>
                                    </PopoverTrigger>
                                    <PopoverContent className="w-full p-0">
                                        <Command>
                                            <CommandInput placeholder="Buscar..." />
                                            <CommandEmpty>No se encontraron resultados</CommandEmpty>
                                            <CommandGroup>
                                                <CommandList>
                                                    {horasDisponiblesFin()?.map((hora) => (
                                                        <CommandItem
                                                            key={hora}
                                                            value={hora}
                                                            onSelect={() => {
                                                                setData('hora_fin', hora);
                                                                setOpenHorarioFin(false);
                                                            }}
                                                        >
                                                            <Check className={cn("mr-2 h-4 w-4", data.hora_fin === hora ? "opacity-100 " : "opacity-0")} />
                                                            {hora}
                                                        </CommandItem>
                                                    ))}
                                                </CommandList>
                                            </CommandGroup>
                                        </Command>
                                    </PopoverContent>
                                </Popover>
                            </div>
                        </div>
                    )}

                    {
                        (errors.hora_inicio || errors.hora_fin) && <span className="text-red-500">{errors.hora_inicio || errors.hora_fin}</span>
                    }

                    <Label className="mt-2">Tipo de reserva</Label>
                    <div className="grid grid-cols-2 gap-2">
                        {reservasTypes.map((type, index) => (
                            <Button
                                type="button"
                                key={index}
                                variant={data.tipo_reserva === type ? 'blue' : 'outline'}
                                onClick={() => setData('tipo_reserva', type)}
                            >
                                {type}
                            </Button>
                        ))}
                    </div>
                    <Button type="submit" variant="blue" loading={processing}> {isEdit ? 'Guardar cambios' : 'Crear reserva'}</Button>
                </div>
            </form>
        </div>
    )
}
