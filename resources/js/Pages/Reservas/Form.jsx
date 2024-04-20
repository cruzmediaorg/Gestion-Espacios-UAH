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
    const [openHorario, setOpenHorario] = React.useState(false)

    const [selectedEspacio, setSelectedEspacio] = React.useState(null);

    const reservableTypes = [
        {
            value: 'App\\Models\\Espacio',
            label: 'Espacio'
        },
        {
            value: 'App\\Models\\Recurso',
            label: 'Recurso'
        }
    ];


    const { data, setData, put, post, processing, errors } = useForm({
        reservable_id: isEdit ? reserva.reservable_id : '',
        reservable_type: isEdit ? reserva.reservable_type : reservableTypes[0].value,
        asignado_a: isEdit ? reserva.asignado_a.id : '',
        fecha: isEdit ? reserva.fecha : '',
        horas: reserva.horas || ''
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
        '08:00 - 09:00',
        '09:00 - 10:00',
        '10:00 - 11:00',
        '11:00 - 12:00',
        '12:00 - 13:00',
        '13:00 - 14:00',
        '14:00 - 15:00',
        '15:00 - 16:00',
        '16:00 - 17:00',
        '17:00 - 18:00',
        '18:00 - 19:00',
        '19:00 - 20:00',
        '20:00 - 21:00',
        '21:00 - 22:00',
    ];

    const horasDisponibles = () => {
        if (selectedEspacio) {
            const horariosOcupados = selectedEspacio.horarios_ocupados;

            const fecha = format(data.fecha, 'yyyy-MM-dd');

            const horasOcupadas = horariosOcupados.filter(horario => horario.fecha === fecha);

            let nuevasHoras = horas.filter(hora => {
                // Si no hay horarios ocupados, todas las horas están disponibles
                if (horasOcupadas.length === 0) {
                    return true;
                }
                // Si hay horarios ocupados, filtramos las horas que no estén ocupadas
                return !horasOcupadas.some(horario => {
                    // Si la hora de inicio está entre las horas ocupadas, la hora no está disponible
                    if (hora.split(' - ')[0] >= horario.hora_inicio && hora.split(' - ')[0] < horario.hora_fin) {
                        return true;
                    }
                    // Si la hora de fin está entre las horas ocupadas, la hora no está disponible
                    if (hora.split(' - ')[1] > horario.hora_inicio && hora.split(' - ')[1] <= horario.hora_fin) {
                        return true;
                    }
                    return false;
                });
            }
            );

            return nuevasHoras;
        } else {
            return horas;
        }
    }


    return (<div className="p-5">

        <h2 className="font-semibold text-xl text-gray-800 leading-tight">{isEdit ? 'Editar' : 'Nueva'} reserva</h2>

        <hr className="my-5" />
        {/* Horarios Ocupados Display */}
        {selectedEspacio && data.reservable_type === 'App\\Models\\Espacio' && (
            <div>
                <h3 className="text-lg font-medium text-gray-700">Horarios ocupados:</h3>
                <ul className='divide-y'>
                    {selectedEspacio.horarios_ocupados.length > 0 ? selectedEspacio.horarios_ocupados.map((horario, index) => (
                        <li key={index} className="flex flex-col">
                            <span className='font-bold text-red-700'>• {horario.fecha} - [{horario.hora_inicio} - {horario.hora_fin}]</span>
                        </li>
                    )) : <li>No hay horarios ocupados</li>}
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
                            {data.fecha ? format(data.fecha, "PPP") : <span>Selecciona una fecha</span>}
                        </Button>
                    </PopoverTrigger>
                    <PopoverContent className="w-auto p-0">
                        <Calendar
                            mode="single"
                            selected={data.fecha}
                            onSelect={(date) => {
                                setData("fecha", date);
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
                        <Popover open={openHorario} onOpenChange={setOpenHorario}>
                            <PopoverTrigger asChild>
                                <Button variant="outline" role="combobox" aria-expanded={openHorario} className="w-full max-w-[400px] justify-between">
                                    {data.horas ? data.horas : 'Seleccionar horario'}
                                    <ChevronsUpDown className="ml-2 h-4 w-4 shrink-0 opacity-50" />
                                </Button>
                            </PopoverTrigger>
                            <PopoverContent className="w-full p-0">
                                <Command>
                                    <CommandInput placeholder="Buscar..." />
                                    <CommandEmpty>No se encontraron resultados</CommandEmpty>
                                    <CommandGroup>
                                        <CommandList>
                                            {horasDisponibles().map((hora) => (
                                                <CommandItem
                                                    key={hora}
                                                    value={hora}
                                                    onSelect={() => {
                                                        setData('horas', hora);
                                                        setOpenHorario(false);
                                                    }}
                                                >
                                                    <Check className={cn("mr-2 h-4 w-4", data.horas === hora ? "opacity-100 " : "opacity-0")} />
                                                    {hora}
                                                </CommandItem>
                                            ))}
                                        </CommandList>
                                    </CommandGroup>
                                </Command>
                            </PopoverContent>
                        </Popover>
                    </div>
                )}

                {
                    errors.horas && <span className="text-red-500">{errors.horas}</span>
                }
                <Button type="submit" variant="blue" loading={processing}> {isEdit ? 'Guardar cambios' : 'Crear reserva'}</Button>
            </div>
        </form>
    </div>)
}
