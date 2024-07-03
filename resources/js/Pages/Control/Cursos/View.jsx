/* React and Inertia imports */
import {router, useForm} from '@inertiajs/react';
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
    Dialog,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
} from "@/Components/ui/dialog"

/* Conditional Rendering */
import ReactIf from "@/lib/ReactIf.jsx";

import {Badge} from "@/Components/ui/badge";

export default function Create({ auth, curso, asignaturas }) {

    // Composables
    const { toast } = useToast();

    const [isAddDialogOpen, setIsAddDialogOpen] = useState(false);
    const [isEditDialogOpen, setIsEditDialogOpen] = useState(false);
    const [currentSlot, setCurrentSlot] = useState(null);
    const [slotData, setSlotData] = useState({ fecha: new Date().toISOString().split('T')[0], horaInicio: '', horaFin: '' });
    const [errors, setErrors] = useState({});
    const horas = [];

    for (let i = 7; i <= 21; i++) {
        horas.push(`${i}:00`);

        if (i < 21) {
            horas.push(`${i}:30`);
        }
    }

    const mostrarBotonGenerarReservas = () => {
        if (curso.slots.length > 0) {
            return curso.slots.some(slot => slot.reservas.length < 1);
        }

        return false;
    }

    const handleAddSlot = () => {
        // Lógica para agregar el slot
        const newSlot = {
            fecha: slotData.fecha,
            horaInicio: slotData.horaInicio,
            horaFin: slotData.horaFin,
            curso_id: curso.id,
        };

        console.log(newSlot);

        router.post(route('cursos.slot.store'), { ...newSlot }, {
            onSuccess: () => {
                toast({
                    title: 'Horario agregado correctamente',
                    variant: 'success'
                });
                setIsAddDialogOpen(false);
                window.location.reload();
            },
            onError: (error) => {
                setErrors(error);
                toast({
                    title: 'Ocurrió un error al agregar el horario',
                    variant: 'error'
                });
            }
        });
    };

    const handleEditSlot = () => {
        // Lógica para editar el slot
        const updatedSlot = {
            fecha: slotData.fecha,
            horaInicio: slotData.horaInicio,
            horaFin: slotData.horaFin,
            curso_id: curso.id,
        };

        router.put(route('cursos.slot.update', currentSlot.id), { ...updatedSlot }, {
            onSuccess: () => {
                toast({
                    title: 'Horario actualizado correctamente',
                    variant: 'success'
                });
                setIsEditDialogOpen(false);
                window.location.reload();
            },
            onError: () => {
                toast({
                    title: 'Ocurrió un error al actualizar el horario',
                    variant: 'error'
                });
            }
        });
    };

    const handleDeleteSlot = (slotId) => {
        // Lógica para eliminar el slot
        router.delete(route('cursos.slot.destroy', slotId), {
            onSuccess: () => {
                toast({
                    title: 'Horario eliminado correctamente',
                    variant: 'success'
                });
                // window.location.reload();
            },
            onError: () => {
                toast({
                    title: 'Ocurrió un error al eliminar el horario',
                    variant: 'error'
                });
            }
        });
    };


    function generarReservas() {
       router.get(route('cursos.reservas.generar', curso.id), {
            onSuccess: () => {
                toast({
                    title: 'Reservas generadas correctamente',
                    variant: 'success'
                });
                setTimeout(() => {
                   router.reload();
                }, 1000);
            },
            onError: () => {
                toast({
                    title: 'Ocurrió un error al generar las reservas',
                    variant: 'error'
                });
            }
        });

    }

    function convertirHora(hora) {
        console.log(hora);
       //input: 09:30:00
        //output: 9:30
        // si tiene un 0 al inicio, lo elimina...
        const [h, m, s] = hora.split(':');
        return `${parseInt(h)}:${m}`;



    }

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={<div className='flex items-center gap-2 '>
                <h2 className="font-semibold text-xl text-gray-800">{curso.nombre}</h2>
                <Badge>{curso.periodo.nombre}</Badge>
            </div>}
        >
            {/*    Información del Curso
            - Nombre
            - Periodo
            - Docente(s)
            - Total de Alumnos
         */}

            <div className="flex w-full mt-4 gap-4 bg-white p-5 rounded-md">
                <div className="flex flex-col gap-2 w-full">
                    <Label>Asignatura</Label>
                    <p className='uppercase font-bold'>{curso.nombre}</p>
                </div>
                <div className="flex flex-col gap-2 w-full">
                    <Label>Periodo</Label>
                    <p className='uppercase font-bold'>{curso.periodo.nombre}</p>
                </div>
                <div className="flex flex-col gap-2 w-full">
                    <Label>Docente(s)</Label>
                    <p className='uppercase font-bold'>
                        {curso.docentes.map((docente, index) => (
                            <span key={index} className="text-gray-800">{docente.name} </span>
                        ))}
                    </p>
                </div>
                <div className="flex flex-col gap-2 w-full">
                    <Label>Total de Alumnos</Label>
                    <p className='uppercase font-bold'>{curso.alumnos_matriculados}</p>
                </div>
            </div>

            <div className="flex w-full mt-8 border-t pt-5 gap-4 ">
                <div className="flex flex-col gap-2 w-full ">
                    <div className='justify-between w-full flex'>
                        <h2 className="font-semibold text-xl text-gray-800">Horarios de clase</h2>
                        <div className='flex gap-2'>
                            <Button variant='outline' onClick={() => setIsAddDialogOpen(true)}>Agregar
                            Horario</Button>

                            <ReactIf condition={mostrarBotonGenerarReservas()}>
                            <Button variant='blue'
                                    onClick={generarReservas}
                            >Generar reservas
                            </Button>
                            </ReactIf>
                        </div>
                    </div>
                    <div className="grid grid-cols-4 gap-2">
                        {curso.slots.map((slot, index) => (
                            <div key={index} className="flex flex-col gap-2 p-5 rounded-md bg-white">
                                <p className="text-gray-800 font-semibold">{new Date(slot.dia).toLocaleDateString("es-ES", {
                                    timeZone: 'Europe/Madrid', })}</p>
                                <p className="text-gray-800">{slot.hora_inicio} - {slot.hora_fin}</p>
                                {
                                    slot.reservas?.map((reserva, index) => (
                                        <div key={index} className="flex flex-col gap-2 p-5 rounded-md bg-gray-100">
                                            <p className="text-gray-800 font-semibold">Espacio {reserva.nombre} reservado
                                                #{reserva.id}</p>
                                            <hr className="border-gray-300"/>
                                            <p className="text-gray-800 text-sm font-bold">Hora de
                                                inicio: {reserva.hora_inicio}</p>
                                            <p className="text-gray-800 text-sm font-bold">Hora de
                                                fin: {reserva.hora_fin}</p>

                                            <Badge className='uppercase w-fit'
                                                   variant={reserva.estado}>{reserva.estado}</Badge>
                                        </div>
                                    ))
                                }




                                <ReactIf condition={slot.reservas.length < 1}>

                                    {/*
                                Boton (reservar espacio) (Si no hay)
                                */}

                                    <Button variant='blue' onClick={() => {
                                        router.push(route('cursos.slot.reservar', slot.id));
                                    }}>Reservar Espacio</Button>


                                    {/*
                               Boton (editar horario)
                                */}
                                    <div className="flex justify-between items-center gap-2">
                                        <Button variant='outline'  className='w-full' onClick={() => {
                                            setCurrentSlot(slot);
                                            setSlotData({
                                                fecha: new Date(slot.dia).toISOString().split('T')[0],
                                                horaInicio: convertirHora(slot.hora_inicio),
                                                horaFin: convertirHora(slot.hora_fin),
                                            });
                                            setIsEditDialogOpen(true);
                                        }}>Editar</Button>
                                        <Button variant='destructive'
                                                onClick={() => handleDeleteSlot(slot.id)}>Eliminar</Button>
                                    </div>
                                </ReactIf>
                            </div>
                        ))}
                    </div>
                </div>
            </div>

            <Dialog open={isAddDialogOpen} onOpenChange={setIsAddDialogOpen}>
                <DialogContent className="sm:max-w-[425px]">
                    <DialogHeader>
                        <DialogTitle>Agregar Horario</DialogTitle>
                        <DialogDescription>Rellena los campos para agregar un nuevo horario.</DialogDescription>
                    </DialogHeader>
                    <div className="grid gap-4 py-4">
                        <div>
                            <Label>Fecha:</Label>
                            <Input
                                type="date"
                                name="fecha"
                                value={slotData.fecha}
                                onChange={(e) => setSlotData({...slotData, fecha: e.target.value})}
                                className="w-full p-2 border border-gray-300 rounded-md"
                            />
                        </div>
                        <div>
                            <Label>Hora de inicio:</Label>
                            <select name="horaInicio" value={slotData.horaInicio}
                                    onChange={(e) => setSlotData({...slotData, horaInicio: e.target.value})}
                                    className="w-full p-2 border border-gray-300 rounded-md">
                                <option value="">Selecciona una hora</option>
                                {horas.map((hora, index) => (
                                    <option key={index} value={hora}>{hora}</option>
                                ))}
                            </select>

                            {
                                errors.horaInicio && (
                                    <p className="text-red-500 text-sm">{errors.horaInicio}</p>
                                )
                            }
                        </div>
                        <div>
                            <Label>Hora fin:</Label>
                            <select name="horaFin" value={slotData.horaFin}
                                    onChange={(e) => setSlotData({...slotData, horaFin: e.target.value})}
                                    className="w-full p-2 border border-gray-300 rounded-md">
                                <option value="">Selecciona una hora</option>
                                {horas.map((hora, index) => (
                                    <option key={index} value={hora}>{hora}</option>
                                ))}
                            </select>
                        </div>
                    </div>
                    <DialogFooter>
                        <Button type="button" onClick={handleAddSlot}>Agregar Horario</Button>
                    </DialogFooter>
                </DialogContent>
            </Dialog>

            <Dialog open={isEditDialogOpen} onOpenChange={setIsEditDialogOpen}>
                <DialogContent className="sm:max-w-[425px]">
                    <DialogHeader>
                        <DialogTitle>Editar Horario</DialogTitle>
                        <DialogDescription>Modifica los campos para editar el horario.</DialogDescription>
                    </DialogHeader>
                    <div className="grid gap-4 py-4">
                        <div>
                            <Label>Fecha:</Label>
                            <Input
                                type="date"
                                name="fecha"
                                value={slotData.fecha}
                                onChange={(e) => setSlotData({...slotData, fecha: e.target.value})}
                                className="w-full p-2 border border-gray-300 rounded-md"
                            />
                        </div>
                        <div>
                            <Label>Hora de inicio:</Label>
                            <select name="horaInicio" value={slotData.horaInicio}
                                    onChange={(e) => setSlotData({...slotData, horaInicio: e.target.value})}
                                    className="w-full p-2 border border-gray-300 rounded-md">
                                <option value="">Selecciona una hora</option>
                                {horas.map((hora, index) => (
                                    <option key={index} value={hora}>{hora}</option>
                                ))}
                            </select>
                        </div>
                        <div>
                            <Label>Hora fin:</Label>
                            <select name="horaFin" value={slotData.horaFin}
                                    onChange={(e) => setSlotData({...slotData, horaFin: e.target.value})}
                                    className="w-full p-2 border border-gray-300 rounded-md">
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

        </AuthenticatedLayout>
    );
}
