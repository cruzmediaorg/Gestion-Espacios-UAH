import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { columns } from '@/Components/tables/reservas/columns';
import { DataTable } from '@/Components/tables/reservas/data-table';
import { Button } from '@/Components/ui/button';
import { router } from '@inertiajs/react';
import {
    Drawer,
    DrawerContent,
    DrawerClose
} from "@/Components/ui/drawer"
import { ScrollArea } from "@/Components/ui/scroll-area"
import Form from './Form';
import { RefreshCcw, X } from 'lucide-react';
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogHeader,
    DialogTitle,
} from "@/Components/ui/dialog"


import ReactIf from "@/lib/ReactIf.jsx";
import { useState } from 'react';



export default function Index({ auth, reservas, openDrawer = false, isEdit = false, reserva = {}, espacios = {}, usuarios = {}, recursos = {}, openGestionarDialog = false }) {

    function cambiarEstado(id, estado) {
        router.put(route('reservas.gestionar.store', id), { estado: estado });
    }

    const [open, setOpen] = useState(false);
    

    function generarReservas() {

        let datos = {
            'parametros': {
                'cursos': 'todos',
            }
        }

        //crear_reservas_sin_slots
        router.post(route('tareas.ejecutar', 4), datos);
    }


    return (
        <AuthenticatedLayout
            user={auth.user}
            header={<div className='flex justify-between items-center'> <h2 className="font-semibold text-xl text-gray-800 leading-tight">Reservas 
            ({reservas.length})
            </h2>
            <div className="flex space-x-4">
            <ReactIf condition={auth.permisos.includes('Generar reservas')}>
            <Button
                onClick={() => {
                    setOpen(true)
                }
                }
                className="flex gap-2 items-center"
                variant="outline">
                Generar reservas <RefreshCcw size={12} />
            </Button>
            </ReactIf>
            <Button
                onClick={() => {
                    router.get('/reservas/create')
                }
                }
                variant="blue">
                Nueva reserva
            </Button>
            </div>
            </div>
            
        }
        >


        <Dialog open={open} onOpenChange={() => setOpen(false)}>
            <DialogContent>
                <DialogHeader>
                    <DialogTitle>Generar reservas automaticas</DialogTitle>
                    <DialogDescription>
                        Se generarán automáticamente las reservas para todos los cursos que aún no tengan un espacio asignado. 
                        <br />
                        <strong>Este proceso dará prioridad a los cursos con más estudiantes para la selección de cursos.</strong>
                    </DialogDescription>
                </DialogHeader>
                <div className="grid gap-4 py-4">
                    <Button onClick={() => setOpen(false)} variant="outline">Cancelar</Button>
                    <Button onClick={() =>
                        generarReservas()
                    } variant="blue">Iniciar</Button>
                </div>
            </DialogContent>
        </Dialog>


            <div className="h-full overflow-y-scroll">
                <div className="">
                    <DataTable auth={auth} columns={columns(auth)} data={reservas} />
                </div>
            </div>

            {openDrawer &&
                <Drawer open={openDrawer}
                    onOpenChange={() => { router.get('/reservas') }}
                    direction='right'
                >
                    <DrawerContent className='h-screen top-0 right-0 left-auto mt-0 w-[500px] rounded-none'>
                        <ScrollArea className='h-screen'>
                            <DrawerClose className='fixed right-4'>
                                <Button variant='ghost' onClick={() => { router.get('/reservas') }}>
                                    <X size={24} />
                                </Button>
                            </DrawerClose>

                            <Form isEdit={isEdit} reserva={reserva} espacios={espacios} usuarios={usuarios} recursos={recursos} />
                        </ScrollArea>
                    </DrawerContent>
                </Drawer>
            }

            {openGestionarDialog &&
                <Dialog open={openGestionarDialog} onOpenChange={() => { router.get('/reservas') }}>
                    <DialogContent className="sm:max-w-[425px]">
                        <DialogHeader>
                            <DialogTitle>Gestionar la reserva</DialogTitle>
                            <DialogDescription>
                                Cambia el estado de la reserva.
                            </DialogDescription>
                        </DialogHeader>
                        <div className="grid gap-4 py-4">
                            <ReactIf condition={auth.permisos.includes('Aprobar reservas') && reserva.estado !== 'aprobada'}>
                                <Button
                                    onClick={() => { cambiarEstado(reserva.id, 'aprobada') }}
                                    variant="green" className="w-full">Aprobar</Button>
                            </ReactIf>

                            <ReactIf condition={auth.permisos.includes('Rechazar reservas') && reserva.estado !== 'rechazada'}>
                                <Button
                                    onClick={() => { cambiarEstado(reserva.id, 'rechazada') }}
                                    variant="destructive" className="w-full">Rechazar</Button>
                            </ReactIf>

                            <ReactIf
                                condition={auth.permisos.includes('Rechazar reservas') && reserva.estado !== 'cancelada' || auth.user.id === reserva.asignado_a.id}>

                                <Button
                                    onClick={() => { cambiarEstado(reserva.id, 'cancelada') }}
                                    variant="destructive" className="w-full">Cancelar reserva</Button>
                            </ReactIf>

                            <ReactIf
                                condition={auth.permisos.includes('Gestionar reservas') && reserva.estado !== 'pendiente'}>

                                <Button
                                    onClick={() => { cambiarEstado(reserva.id, 'pendiente') }}
                                    variant="outline" className="w-full">Marcar como pendiente</Button>
                            </ReactIf>

                        </div>
                    </DialogContent>


                </Dialog>

            }

        </AuthenticatedLayout >
    );
}
