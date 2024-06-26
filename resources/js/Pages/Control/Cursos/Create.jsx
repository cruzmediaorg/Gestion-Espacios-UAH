/* React and Inertia imports */
import { useForm } from '@inertiajs/react';
import React, { useEffect, useState } from 'react';
import { CommandList } from 'cmdk';
import { cn } from "@/lib/utils.js";

/* Layouts */
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';

/* Components */
import { Input } from '@/Components/ui/input';
import { Button } from '@/Components/ui/button';
import { Label } from '@/Components/ui/label';
import { useToast } from "@/Components/ui/use-toast";
import {
    Command,
    CommandEmpty,
    CommandGroup,
    CommandInput,
    CommandItem,
} from "@/Components/ui/command";
import {
    Popover,
    PopoverContent,
    PopoverTrigger,
} from "@/Components/ui/popover";
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
} from "@/Components/ui/dialog"

/* Conditional Rendering */
import ReactIf from "@/lib/ReactIf.jsx";

/* Icons */
import { Check, ChevronsUpDown, PencilIcon, XIcon } from "lucide-react";

export default function Create({ auth, docentes, asignaturas }) {

    // Composables
    const { toast } = useToast();

    // States
    const [openSelectDocente, setOpenSelectDocente] = useState(false);
    const [openSelectAsignatura, setOpenSelectAsignatura] = useState(false);
    const [slots, setSlots] = useState([]); // Estado para almacenar los slots generados
    const [fechaInicioPeriodo, setFechaInicioPeriodo] = useState('2024-09-09');
    const [editDialogOpen, setEditDialogOpen] = useState(false);
    const [currentSlotIndex, setCurrentSlotIndex] = useState(null);
    const [editData, setEditData] = useState({ fecha: '', horaInicio: '', horaFin: '' });
    const [diasSaltados, setDiasSaltados] = useState([]); // Estado para almacenar los días festivos que se han saltado
    const [isConfirmDialogOpen, setIsConfirmDialogOpen] = useState(false);

    // Forms
    const { data, setData, post, processing, errors } = useForm({
        dias: [],
        docentes: [],
        hora_inicio: '',
        hora_fin: '',
        cantidad_horas: 0,
        total_clases: 0,
        alumnos_matriculados: 0,
        slots: [],
        fecha_inicio_periodo: null,
    });

    const horas = [];

    for (let i = 7; i <= 21; i++) {
        horas.push(`${i}:00`);

        if (i < 21) {
            horas.push(`${i}:30`);
        }
    }

    const dias = [
        { label: 'Lunes', value: 'L' },
        { label: 'Martes', value: 'M' },
        { label: 'Miercoles', value: 'X' },
        { label: 'Jueves', value: 'J' },
        { label: 'Viernes', value: 'V' },
        { label: 'Sabado', value: 'S' },
        { label: 'Domingo', value: 'D' },
    ];

    const diasNoLaborablesPorFestivos = [
        '2024-10-12', // Día Nacional de España
        '2024-11-01', // Día de todos los santos
        '2024-11-09', // Día de la Almudena
        '2024-12-06', // Día de la constitución
        '2024-12-09', // Día de la Inmaculada Concepción
        '2024-12-25', // Navidad
    ];

    /*********
     * Methods
     *********/
    const handleHoraChange = (e, field) => {
        const value = e.target.value;
        setData(field, value);
    };

    const validateHoras = () => {
        const horaInicio = parseTime(data.hora_inicio);
        const horaFin = parseTime(data.hora_fin);

        if (horaInicio && horaFin && horaInicio >= horaFin) {
            toast({
                title: 'La hora de inicio debe ser menor a la hora fin.',
                variant: 'error'
            });
            setData('hora_fin', '');
        } else {
            calculateCantidadHoras();
        }
    };

    const parseTime = (time) => {
        if (!time) return null;
        const [hours, minutes] = time.split(':').map(Number);
        return hours + minutes / 60;
    };

    const calculateCantidadHoras = () => {
        const horaInicio = parseTime(data.hora_inicio);
        const horaFin = parseTime(data.hora_fin);
        const diasSeleccionados = data.dias.length;

        if (horaInicio && horaFin && diasSeleccionados > 0) {
            const horasPorDia = horaFin - horaInicio;
            const totalHoras = horasPorDia * diasSeleccionados;
            setData('cantidad_horas', totalHoras);
        } else {
            setData('cantidad_horas', 0);
        }
    };

    const handleDocenteSelect = (id) => {
        if (data.docentes.includes(id)) {
            setData('docentes', data.docentes.filter(docenteId => docenteId !== id));
        } else {
            setData('docentes', [...data.docentes, id]);
        }
    };
    const generarSlots = () => {

        if (!validarSlots()) {
            return;
        }

        const slotsGenerados = [];
        const fechaInicio = new Date(fechaInicioPeriodo);
        const diaSemanaValores = ['D', 'L', 'M', 'X', 'J', 'V', 'S']; // 0: Domingo, 1: Lunes, ..., 6: Sábado
        let clasesRestantes = data.total_clases;
        const newDiasSaltados = []; // Array temporal para almacenar los días festivos saltados

        while (clasesRestantes > 0) {
            for (const dia of data.dias) {
                if (clasesRestantes === 0) break;

                let fechaClase = new Date(fechaInicio);
                const diaIndice = diaSemanaValores.indexOf(dia);

                // Mover la fechaClase al siguiente día correcto
                while (fechaClase.getDay() !== diaIndice) {
                    fechaClase.setDate(fechaClase.getDate() + 1);
                }

                // Saltar días festivos y continuar hasta encontrar un día válido
                while (diasNoLaborablesPorFestivos.includes(fechaClase.toISOString().split('T')[0])) {
                    newDiasSaltados.push(new Date(fechaClase)); // Agregar el día festivo al array temporal
                    fechaClase.setDate(fechaClase.getDate() + 7); // Ir al siguiente día de la semana en la próxima semana
                }

                slotsGenerados.push({
                    dia,
                    fecha: new Date(fechaClase),
                    horaInicio: data.hora_inicio,
                    horaFin: data.hora_fin,
                });

                clasesRestantes--;
            }
            fechaInicio.setDate(fechaInicio.getDate() + 7);
        }

        setSlots(slotsGenerados);
        setData('slots', slotsGenerados);
        setDiasSaltados(newDiasSaltados); // Actualizar el estado con el nuevo array de días festivos saltados
    };

    const validarSlots = () => {

        // Si no se ha especificado la fecha de inicio del periodo
        if (!fechaInicioPeriodo) {
            toast({
                title: 'Debes seleccionar la fecha de inicio del periodo',
                variant: 'error'
            });
            return false;
        }

        // Si no se ha seleccionado ningún día
        if (data.dias.length === 0) {
            toast({
                title: 'Debes seleccionar al menos un día',
                variant: 'error'
            });
            return false;
        }

        // Si no se ha especificado la hora de inicio o fin
        if (!data.hora_inicio || !data.hora_fin) {
            toast({
                title: 'Debes seleccionar la hora de inicio y fin',
                variant: 'error'
            });

            return false;
        }

        // Si no se ha especificado el total de clases en el periodo
        if (data.total_clases === 0) {
            toast({
                title: 'Debes ingresar el total de clases en el periodo',
                variant: 'error'
            });
            return false;
        }

        // Si hay más días seleccionados que clases en el periodo
        if (data.dias.length > data.total_clases) {
            toast({
                title: 'El total de clases en el periodo debe ser mayor o igual a la cantidad de días seleccionados',
                variant: 'error'
            });
            return false;
        }

        return true;
    }

    const validarSlotEdicion = () => {
        // Validar que los campos no estén vacíos
        if (!editData.fecha || !editData.horaInicio || !editData.horaFin) {
            toast({
                title: 'Debes completar todos los campos',
                variant: 'error'
            });
            return false;
        }
        // Validar que la hora de inicio sea menor a la hora fin
        const horaInicio = parseTime(editData.horaInicio);
        const horaFin = parseTime(editData.horaFin);
        if (horaInicio >= horaFin) {
            toast({
                title: 'La hora de inicio debe ser menor a la hora fin',
                variant: 'error'
            });
            return false;
        }

        // Validar que la hora de inicio y fin no estén en un rango de horas del mismo día seleccionado
        const dia = slots[currentSlotIndex].dia;
        const fecha = new Date(editData.fecha);
        const horaInicioEdit = parseTime(editData.horaInicio);
        const horaFinEdit = parseTime(editData.horaFin);

        for (const slot of slots) {
            if (slot.dia === dia && slot.fecha.toISOString().split('T')[0] === fecha.toISOString().split('T')[0]) {

                // Si es el mismo slot que se está editando, se salta la validación
                if (slot.fecha.toISOString().split('T')[0] === slots[currentSlotIndex].fecha.toISOString().split('T')[0] && slot.horaInicio === slots[currentSlotIndex].horaInicio && slot.horaFin === slots[currentSlotIndex].horaFin) {
                    continue;
                }

                const horaInicioSlot = parseTime(slot.horaInicio);
                const horaFinSlot = parseTime(slot.horaFin);

                if (horaInicioEdit >= horaInicioSlot && horaInicioEdit < horaFinSlot) {
                    toast({
                        title: 'El bloque de clase se superpone con otro bloque de clase',
                        variant: 'error'
                    });
                    return false;
                }

                if (horaFinEdit > horaInicioSlot && horaFinEdit <= horaFinSlot) {
                    toast({
                        title: 'El bloque de clase se superpone con otro bloque de clase',
                        variant: 'error'
                    });
                    return false;
                }
            }
        }

        return true;
    }

    const eliminarSlot = (index) => {
        const nuevosSlots = [...slots];
        nuevosSlots.splice(index, 1);
        setSlots(nuevosSlots);
    };
    const openEditDialog = (index) => {
        setCurrentSlotIndex(index);
        const slot = slots[index];
        setEditData({ fecha: slot.fecha.toISOString().split('T')[0], horaInicio: slot.horaInicio, horaFin: slot.horaFin });
        setEditDialogOpen(true);
    };

    const handleEditSlot = () => {
        if (!validarSlotEdicion()) {
            return;
        }

        const updatedSlots = [...slots];
        const nuevaFecha = new Date(editData.fecha);
        const diaSemanaValores = ['D', 'L', 'M', 'X', 'J', 'V', 'S'];
        const nuevoDia = diaSemanaValores[nuevaFecha.getDay()];

        updatedSlots[currentSlotIndex] = {
            ...updatedSlots[currentSlotIndex],
            dia: nuevoDia,
            fecha: new Date(editData.fecha),
            horaInicio: editData.horaInicio,
            horaFin: editData.horaFin,
        };
        setSlots(updatedSlots);
        setEditDialogOpen(false);

        toast({
            title: 'Bloque de clase actualizado',
            variant: 'success'
        });
    };

    const borrarSlots = () => {
        setSlots([]);
        setDiasSaltados([]);
    }

    const confirmValues = () => {
        // Validar que haya informacion del curso
        if (!data.hora_inicio || !data.hora_fin || data.dias.length === 0 || data.cantidad_horas === 0 || data.total_clases === 0) {
            toast({
                title: 'Debes completar la información del curso',
                variant: 'error'
            });
            return;
        }

        // Validar que haya información de la asignatura y docentes
        if (!data.asignatura || data.docentes.length === 0) {
            toast({
                title: 'Debes seleccionar la asignatura y al menos un docente',
                variant: 'error'
            });
            return;
        }

        // Validar que haya mas de 0 alumnos matriculados
        if (data.alumnos_matriculados === 0) {
            toast({
                title: 'El número de alumnos matriculados debe ser mayor a 0',
                variant: 'error'
            });
            return;
        }
        setIsConfirmDialogOpen(true);
    }

    const handleSubmit = () => {

        if (slots.length > 0) {
            setData('slots', slots);
        }

        post(route('cursos.store'), {
            onSuccess: () => {
                toast({
                    title: 'Curso creado',
                    variant: 'success'
                });
                window.location.href = route('cursos.index');
            },
            onError: () => {
                console.log(errors);
                toast({
                    title: 'Ocurrió un error al guardar el curso',
                    variant: 'error'
                });
            }
        });
    }

    /****************
     * Watchers
     ****************/

    useEffect(() => {
        validateHoras();
    }, [data.hora_inicio, data.hora_fin]);

    useEffect(() => {
        calculateCantidadHoras();
    }, [data.dias]);

    useEffect(() => {
        setData('fecha_inicio_periodo', fechaInicioPeriodo);
    }, [fechaInicioPeriodo]);

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={<div className='flex flex-col'>
                <h2 className="font-semibold text-xl text-gray-800">Nuevo curso</h2>
                <p className="text-sm text-gray-500">Crea un nuevo curso</p>
            </div>}
        >
            <div className="h-full overflow-y-scroll">
                <div className="py-4">
                    <form onSubmit={e => {
                        e.preventDefault();
                        confirmValues();
                    }}
                        className="space-y-4"
                    >
                        <div className="bg-white p-5 rounded-md">

                            <h2 className="font-semibold text-lg text-gray-800">Horario de clase</h2>

                            <div className="grid grid-cols-1 gap-4 sm:grid-cols-2 ">
                                <div>
                                    <div>
                                        <Label>Hora de inicio:</Label>
                                        <select name="hora_inicio" value={data.hora_inicio}
                                            onChange={(e) => handleHoraChange(e, 'hora_inicio')}
                                            className="w-full p-2 border border-gray-300 rounded-md">
                                            <option value="">Selecciona una hora</option>
                                            {horas.map((hora, index) => (
                                                <option key={index} value={hora}>{hora}</option>
                                            ))}
                                        </select>
                                    </div>
                                    <div>
                                        <Label>Hora fin:</Label>
                                        <select name="hora_fin" value={data.hora_fin}
                                            onChange={(e) => handleHoraChange(e, 'hora_fin')}
                                            className="w-full p-2 border border-gray-300 rounded-md">
                                            <option value="">Selecciona una hora</option>
                                            {horas.map((hora, index) => (
                                                <option key={index} value={hora}>{hora}</option>
                                            ))}
                                        </select>
                                    </div>
                                </div>
                                <div>
                                    <Label>Días:</Label>
                                    <div className="grid grid-cols-3 gap-2">
                                        {dias.map((dia, index) => (
                                            <div key={index} className="flex items-center gap-1">
                                                <input id={dia.value}
                                                    type="checkbox" name="dias" value={dia.value} onChange={(e) => {
                                                        const value = e.target.value;
                                                        if (e.target.checked) {
                                                            setData('dias', [...data.dias, value]);
                                                        } else {
                                                            setData('dias', data.dias.filter(d => d !== value));
                                                        }
                                                    }} />
                                                <label htmlFor={dia.value} className="text-sm">{dia.label}</label>
                                            </div>
                                        ))}
                                    </div>
                                </div>
                                <div>
                                    <Label>Total de horas a la semana:</Label>
                                    <Input disabled type="text" name="cantidad_horas" value={data.cantidad_horas} />
                                </div>
                                <div>
                                    <Label>Total de clases en el periodo:</Label>
                                    <Input type="text" name="total_clases" value={data.total_clases} onChange={(e) => {
                                        setData('total_clases', e.target.value);
                                    }} />
                                </div>
                                <div>
                                    <Label>Fecha de Inicio:</Label>
                                    <Input type="date" name="fecha_inicio" value={fechaInicioPeriodo} onChange={(e) => {
                                        setFechaInicioPeriodo(e.target.value); // Actualizamos el estado de la fecha de inicio
                                    }} />
                                </div>
                            </div>
                            <ReactIf condition={data.dias.length > 0 && data.hora_inicio && data.hora_fin}>
                                <Button onClick={generarSlots} className="mt-4" type="button">
                                    Generar bloques de clase
                                </Button>
                            </ReactIf>
                            <ReactIf condition={slots.length > 0}>
                                <div className="mt-4 p-5 border rounded-md">
                                    <h3 className="font-semibold text-lg text-gray-800">Horas a reservar:</h3>
                                    <div className="grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-3">
                                        {slots.map((slot, index) => (
                                            <div key={index} className="p-4 border border-gray-300 rounded-md relative">
                                                <button
                                                    onClick={() => eliminarSlot(index)}
                                                    className="absolute top-2 right-2 text-red-500 rounded-md border border-red-500 w-6 h-6 flex items-center justify-center"
                                                >
                                                    X
                                                </button>
                                                <button
                                                    onClick={() => openEditDialog(index)}
                                                    className="absolute bottom-2 right-2 rounded-md w-6 h-6 border flex items-center justify-center p-1.5"
                                                >
                                                    <PencilIcon className="h-4 w-4" />
                                                </button>
                                                <p><strong>Fecha:</strong> {slot.fecha.toLocaleDateString()} <strong>({dias.find(d => d.value === slot.dia).label})</strong></p>
                                                <p><strong>Hora inicio:</strong> {slot.horaInicio} - {slot.horaFin}</p>
                                            </div>
                                        ))}
                                    </div>
                                    <Button variant={"outline"} onClick={borrarSlots} className="mt-4">
                                        Borrar todos <XIcon className="ml-2 h-4 w-4" />
                                    </Button>
                                </div>
                                {
                                    diasSaltados.length > 0 && (
                                        <div className="mt-4 p-5 border rounded-md">
                                            <h3 className="font-semibold text-lg text-gray-800">Días saltados por festivos:</h3>
                                            <div className="grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-3">
                                                {diasSaltados.map((dia, index) => (
                                                    <div key={index} className="p-4 border border-gray-300 rounded-md">
                                                        <p>{dia.toLocaleDateString()}</p>
                                                    </div>
                                                ))}
                                            </div>
                                        </div>
                                    )
                                }
                            </ReactIf>

                        </div>
                        <div className="bg-white p-5 rounded-md">
                            <h2 className="font-semibold text-lg text-gray-800">Información del curso</h2>

                            <div className="grid grid-cols-1 gap-4 sm:grid-cols-2 ">
                                <div>
                                    <div className="mt-4 flex flex-col gap-2">
                                        <Label>Asignatura:</Label>
                                        <Popover open={openSelectAsignatura} onOpenChange={setOpenSelectAsignatura}>
                                            <PopoverTrigger asChild>
                                                <Button variant="outline" role="combobox"
                                                    aria-expanded={openSelectAsignatura}
                                                    className="w-full max-w-[400px] justify-between rounded-sm">
                                                    {data.asignatura ? asignaturas.find(a => a.id === data.asignatura)?.nombre
                                                        : 'Selecciona una asignatura'}
                                                    <ChevronsUpDown className="ml-2 h-4 w-4 shrink-0 opacity-50" />
                                                </Button>
                                            </PopoverTrigger>
                                            <PopoverContent side="bottom">
                                                <Command>
                                                    <CommandInput placeholder="Buscar..." />
                                                    <CommandEmpty>No se encontraron resultados</CommandEmpty>
                                                    <CommandGroup>
                                                        <CommandList>
                                                            {asignaturas?.map((item) => (
                                                                <CommandItem
                                                                    key={item.id}
                                                                    value={item.id}
                                                                    onSelect={() => setData('asignatura', item.id)}
                                                                >
                                                                    <Check className={cn("mr-2 h-4 w-4", data.asignatura === item.id ? "opacity-100 " : "opacity-0")} />
                                                                    {item.nombre}
                                                                </CommandItem>
                                                            ))}
                                                        </CommandList>
                                                    </CommandGroup>
                                                </Command>
                                            </PopoverContent>
                                        </Popover>
                                    </div>
                                    <div className="mt-4 flex flex-col gap-2">
                                        <Label>Docentes:</Label>

                                        <Popover open={openSelectDocente} onOpenChange={setOpenSelectDocente}>
                                            <PopoverTrigger asChild>
                                                <Button variant="outline" role="combobox" aria-expanded={openSelectDocente} className="w-full max-w-[400px] justify-between rounded-sm">
                                                    {data.docentes.length > 0 ? `${data.docentes.length} docente(s) seleccionado(s)` : 'Selecciona docentes'}
                                                    <ChevronsUpDown className="ml-2 h-4 w-4 shrink-0 opacity-50" />
                                                </Button>
                                            </PopoverTrigger>
                                            <PopoverContent>
                                                <Command>
                                                    <CommandInput placeholder="Buscar..." />
                                                    <CommandEmpty>No se encontraron resultados</CommandEmpty>
                                                    <CommandGroup>
                                                        <CommandList>
                                                            {docentes?.map((item) => (
                                                                <CommandItem
                                                                    key={item.id}
                                                                    value={item.id}
                                                                    onSelect={() => handleDocenteSelect(item.id)}
                                                                >
                                                                    <Check className={cn("mr-2 h-4 w-4", data.docentes.includes(item.id) ? "opacity-100 " : "opacity-0")} />
                                                                    {item.name}
                                                                </CommandItem>
                                                            ))}
                                                        </CommandList>
                                                    </CommandGroup>
                                                </Command>
                                            </PopoverContent>
                                        </Popover>
                                    </div>

                                    <div className="mt-4">
                                        <Label>Alumnos matriculados:</Label>
                                        <Input type="number" name="alumnos_matriculados" value={data.alumnos_matriculados} onChange={(e) => setData('alumnos_matriculados', e.target.value)} />
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div className="flex justify-end mt-4">
                            <Button className="mr-2" processing={processing} type="submit">
                                Guardar
                            </Button>
                        </div>
                    </form>
                </div>
            </div>
            <Dialog open={editDialogOpen} onOpenChange={setEditDialogOpen}>
                <DialogContent className="sm:max-w-[425px]">
                    <DialogHeader>
                        <DialogTitle>Editar bloque de clase</DialogTitle>
                        <DialogDescription>
                            Modifica la fecha y la hora del bloque de clase. Haz clic en guardar cuando termines.
                        </DialogDescription>
                    </DialogHeader>
                    <div className="grid gap-4 py-4">
                        <div>
                            <Label>Fecha:</Label>
                            <Input
                                type="date"
                                name="fecha"
                                value={editData.fecha}
                                onChange={(e) => setEditData({ ...editData, fecha: e.target.value })}
                                className="w-full p-2 border border-gray-300 rounded-md"
                            />
                        </div>
                        <div>
                            <Label>Hora de inicio:</Label>
                            <select name="horaInicio" value={editData.horaInicio} onChange={(e) => setEditData({ ...editData, horaInicio: e.target.value })} className="w-full p-2 border border-gray-300 rounded-md">
                                <option value="">Selecciona una hora</option>
                                {horas.map((hora, index) => (
                                    <option key={index} value={hora}>{hora}</option>
                                ))}
                            </select>
                        </div>
                        <div>
                            <Label>Hora fin:</Label>
                            <select name="horaFin" value={editData.horaFin} onChange={(e) => setEditData({ ...editData, horaFin: e.target.value })} className="w-full p-2 border border-gray-300 rounded-md">
                                <option value="">Selecciona una hora</option>
                                {horas.map((hora, index) => (
                                    <option key={index} value={hora}>{hora}</option>
                                ))}
                            </select>
                        </div>
                    </div>
                    <DialogFooter>
                        <Button type="button" onClick={handleEditSlot}>Guardar cambios</Button>
                    </DialogFooter>
                </DialogContent>
            </Dialog>

            {/*    Confirm Dialog (Show a preview of everything before submitting form */}
            <Dialog open={isConfirmDialogOpen} onOpenChange={setIsConfirmDialogOpen}>
                <DialogContent >
                    <DialogHeader>
                        <DialogTitle>Confirmar datos</DialogTitle>
                        <DialogDescription>
                            Por favor, revisa los datos antes de guardar el curso.
                        </DialogDescription>
                    </DialogHeader>
                    <div className="grid gap-4 py-4">
                        <div>
                            <h3 className="font-semibold text-lg text-gray-800">Horario de clase</h3>
                            <div className="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                <div>
                                    <p><strong>Hora de inicio:</strong> {data.hora_inicio}</p>
                                    <p><strong>Hora fin:</strong> {data.hora_fin}</p>
                                </div>
                                <div>
                                    <p><strong>Días:</strong> {data.dias.map(d => dias.find(dia => dia.value === d).label).join(', ')}</p>
                                    <p><strong>Total de horas a la semana:</strong> {data.cantidad_horas}</p>
                                    <p><strong>Total de clases en el periodo:</strong> {data.total_clases}</p>
                                    <p><strong>Fecha de inicio:</strong> {fechaInicioPeriodo}</p>
                                </div>
                            </div>
                            <ReactIf condition={slots.length > 0}>
                                <div className="mt-4 p-5 border rounded-md h-48 overflow-y-scroll bg-gray-200">
                                    <h3 className="font-semibold text-lg text-gray-800">Horas a reservar:</h3>
                                    <div className="grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-3">
                                        {slots.map((slot, index) => (
                                            <div key={index} className="p-4 border border-gray-300 rounded-md relative bg-white">
                                                <p><strong>Fecha:</strong> {slot.fecha.toLocaleDateString()} <strong>({dias.find(d => d.value === slot.dia).label})</strong></p>
                                                <p><strong>Hora inicio:</strong> {slot.horaInicio} - {slot.horaFin}</p>
                                            </div>
                                        ))}
                                    </div>
                                </div>
                                {
                                    diasSaltados.length > 0 && (
                                        <div className="mt-4 p-5 border rounded-md">
                                            <h3 className="font-semibold text-lg text-gray-800">Días saltados por festivos:</h3>
                                            <div className="grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-3">
                                                {diasSaltados.map((dia, index) => (
                                                    <div key={index} className="p-4 border border-gray-300 rounded-md">
                                                        <p>{dia.toLocaleDateString()}</p>
                                                    </div>
                                                ))}
                                            </div>
                                        </div>
                                    )
                                }
                            </ReactIf>
                            <ReactIf condition={slots.length === 0}>
                                <p className="mt-4 text-white bg-red-500 px-4 py-2 rounded-md">No se han generado bloques de clase. Por lo cual, no se solicitarán reservas de aulas.</p>
                            </ReactIf>
                        </div>
                        <div>
                            <h3 className="font-semibold text-lg text-gray-800">Información del curso</h3>
                            <div className="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                <div>
                                    <p><strong>Asignatura:</strong> {asignaturas.find(a => a.id === data.asignatura)?.nombre}</p>
                                    <p><strong>Docentes:</strong> {data.docentes.map(d => docentes.find(docente => docente.id === d).name).join(', ')}</p>
                                    <p><strong>Alumnos matriculados:</strong> {data.alumnos_matriculados}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <DialogFooter>
                        <Button type="button" variant={"outline"} onClick={() => setIsConfirmDialogOpen(false)}>Modificar</Button>
                        <Button type="button" onClick={handleSubmit}>Guardar</Button>
                    </DialogFooter>
                </DialogContent>
            </Dialog>

        </AuthenticatedLayout>
    );
}
