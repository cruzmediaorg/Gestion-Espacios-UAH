import React, { useState } from 'react';
import { Calendar, momentLocalizer } from 'react-big-calendar';
import moment from 'moment';
import 'moment/locale/es';
import 'react-big-calendar/lib/css/react-big-calendar.css';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import {
    Drawer,
    DrawerContent,
    DrawerClose
} from "@/Components/ui/drawer";
import { ScrollArea } from "@/Components/ui/scroll-area";
import Form from '../../Reservas/Form';
import { Download, Edit, X } from 'lucide-react';
import { Button } from '@/Components/ui/button';
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
} from "@/Components/ui/dialog";
import { router, useForm } from '@inertiajs/react';
import { Select, SelectContent, SelectItem, SelectValue } from '@/Components/ui/select';
import { SelectTrigger } from '@radix-ui/react-select';

const localizer = momentLocalizer(moment);

export default function Vista({ auth, espacio, usuarios }) {
    const [openDrawer, setOpenDrawer] = useState(false);
    const [fechaDrawer, setFechaDrawer] = useState(new Date());
    const [horaInicioDrawer, setHoraInicioDrawer] = useState('07:00');
    const [horaFinDrawer, setHoraFinDrawer] = useState('22:00');
    const [mostrarDialogInfo, setMostrarDialogInfo] = useState(false);
    const [reservaDialogData, setReservaDialogData] = useState(null);
    const [openPdfDialog, setOpenPdfDialog] = useState(false);
    const [selectedPeriod, setSelectedPeriod] = useState('');

    const { data, setData, post, processing } = useForm({
        periodo: '',
    });

    const handleDownloadPdf = () => {
        setOpenPdfDialog(true);
    };

    const getPdfUrl = () => {
        const periodValue = selectedPeriod === '2024-2025 C1' ? '1' : '2';
        return `/control/espacios/${espacio.id}/${periodValue}/download-pdf`;
    };


    const convertirEventos = (horariosOcupados) => {
        return horariosOcupados.map(horario => ({
            ...horario,
            start: new Date(`${horario.fecha}T${horario.hora_inicio}`),
            end: new Date(`${horario.fecha}T${horario.hora_fin}`),
            title: 'Ocupado',
        }));
    };

    const eventos = convertirEventos(espacio.horarios_ocupados);

    const eventStyleGetter = (event, start, end, isSelected) => {
        return {
            style: {
                backgroundColor: 'red',
                borderRadius: '0px',
                opacity: 0.8,
                color: 'white',
                border: '0px',
                display: 'block'
            }
        };
    };

    const handleSelectSlot = (slotInfo) => {
        setFechaDrawer(slotInfo.start);
        setHoraInicioDrawer(moment(slotInfo.start).format('HH:mm'));
        setHoraFinDrawer(moment(slotInfo.end).format('HH:mm'));
        setOpenDrawer(true);
    };

    const handleSelectEvent = (event) => {
        setReservaDialogData(event);
        setMostrarDialogInfo(true);
    };

    return (
        <AuthenticatedLayout
            user={auth.user}
        >
            <div className="pb-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div className="p-6 bg-white border-b border-gray-200">
                        <h3 className="text-lg font-semibold mb-4">Detalles del Espacio</h3>
                            <div className="grid grid-cols-2 gap-4">
                                <div>
                                    <p><strong>Nombre:</strong> {espacio.nombre}</p>
                                    <p><strong>Tipo de Espacio:</strong> {espacio.tipo.nombre}</p>
                                    <p><strong>Localización:</strong> {espacio.localizacion.nombre}</p>
                                    <p><strong>Capacidad:</strong> {espacio.capacidad} personas</p>
                                </div>
                          
                            </div>
                            <div className="my-4 flex space-x-4">
                                <Button 
                                    onClick={() => router.get(route('espacios.edit', espacio.id))}
                                    variant="outline"
                                >
                                    <Edit className="mr-2 h-4 w-4" /> Editar Espacio
                                </Button>
                                <Button 
                                    onClick={handleDownloadPdf}
                                    variant="outline"
                                >
                                    <Download className="mr-2 h-4 w-4" /> Descargar PDF
                                </Button>
                            </div>
                       
                            <Calendar
                                localizer={localizer}
                                locale='es'
                                events={eventos}
                                startAccessor="start"
                                min={new Date(2021, 0, 1, 6, 0, 0)}
                                endAccessor="end"
                                style={{ height: 500 }}
                                eventPropGetter={eventStyleGetter}
                                views={['week', 'day']}
                                defaultView='week'
                                selectable={true}
                                onSelectSlot={handleSelectSlot}
                                onSelectEvent={handleSelectEvent}
                                messages={{
                                    next: 'Siguiente',
                                    previous: 'Anterior',
                                    today: 'Hoy',
                                    month: 'Mes',
                                    week: 'Semana',
                                    day: 'Día',
                                    showMore: total => `+${total} más`,
                                }}
                            />
                        </div>
                    </div>
                </div>
            </div>

            {openDrawer &&
                <Drawer open={openDrawer} onOpenChange={setOpenDrawer} position='right'>
                    <DrawerContent className='h-screen top-0 right-0 left-auto mt-0 w-[500px] rounded-none'>
                        <ScrollArea className='h-screen'>
                            <DrawerClose className='fixed right-4'>
                                <Button variant='ghost' onClick={() => setOpenDrawer(false)}>
                                    <X size={24} />
                                </Button>
                            </DrawerClose>

                            <Form 
                                bloquearFechaYHora={true}
                                seleccionarPrimero={true}
                                isEdit={false} 
                                espacios={[espacio]} 
                                usuarios={usuarios} 
                                fecha={fechaDrawer}
                                hora_inicio={horaInicioDrawer}
                                hora_fin={horaFinDrawer}
                                recursos={null} 
                            />
                        </ScrollArea>
                    </DrawerContent>
                </Drawer>
            }

            {mostrarDialogInfo &&
                <Dialog open={mostrarDialogInfo} onOpenChange={() => setMostrarDialogInfo(false)}>
                    <DialogContent>
                        <DialogHeader>
                            <DialogTitle>Información de la reserva</DialogTitle>
                            <DialogDescription>
                                Detalles de la reserva.
                            </DialogDescription>
                        </DialogHeader>

                        <div className="grid gap-4 py-4">
                            <div className="grid grid-cols-2 gap-4">
                                <div className="grid gap-2">
                                    <div className="font-bold">Reservado por:</div>

                                    <div>{reservaDialogData.asignado_a}</div>
                                </div>
                                <div className="grid gap-2">
                                    <div className="font-bold">Fecha:</div>
                                    <div>{moment(reservaDialogData.fecha).format('DD/MM/YYYY')}</div>
                                </div>
                                <div className="grid gap-2">
                                    <div className="font-bold">Hora de inicio:</div>
                                    <div>{reservaDialogData.hora_inicio}</div>
                                </div>
                                <div className="grid gap-2">
                                    <div className="font-bold">Hora de fin:</div>
                                    <div>{reservaDialogData.hora_fin}</div>
                                </div>
                                <div className="grid gap-2">
                                    <div className="font-bold">Espacio:</div>
                                    <div>{espacio.nombre}</div>
                                </div>
                                <div className="grid gap-2">
                                    <div className="font-bold">Estado:</div>
                                    <div className="uppercase font-bold">{reservaDialogData.estado}</div>
                                </div>
                                <div className="grid gap-2 col-span-2">
                                    <div className="font-bold">Comentarios:</div>
                                    <div>{reservaDialogData.comentarios}</div>
                                </div>
                            </div>
                        </div>

                        <Button
                            onClick={() => setMostrarDialogInfo(false)}
                            variant="outline" className="w-full mt-4">
                            Cerrar
                        </Button>
                    </DialogContent>
                </Dialog>
            }

<Dialog open={openPdfDialog} onOpenChange={setOpenPdfDialog}>
                <DialogContent>
                    <DialogHeader>
                        <DialogTitle>Descargar PDF de Horarios</DialogTitle>
                        <DialogDescription>
                            Seleccione el período para generar el PDF de horarios.
                        </DialogDescription>
                    </DialogHeader>
                    <Select
                    className="w-full "
                        onValueChange={(value) => {
                            setSelectedPeriod(value);
                        }
                        }
                        value={selectedPeriod}
                    >
                        <SelectTrigger className="w-full border py-2 rounded-md border-black">
                            <SelectValue placeholder="Seleccione un período" />
                        </SelectTrigger>
                        <SelectContent>
                            <SelectItem value="2024-2025 C1">2024-2025 C1</SelectItem>
                            <SelectItem value="2024-2025 C2">2024-2025 C2</SelectItem>
                        </SelectContent>
                    </Select>
                    <DialogFooter>
                        <Button onClick={() => setOpenPdfDialog(false)} variant="outline">Cancelar</Button>
                           <a 
                            href={getPdfUrl()} 
                            target="_blank" 
                            rel="noopener noreferrer"
                            className={`inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-primary text-primary-foreground hover:bg-primary/90 h-10 px-4 py-2 ${!selectedPeriod ? 'pointer-events-none opacity-50' : ''}`}
                            onClick={() => setOpenPdfDialog(false)}
                        >
                            Descargar PDF
                        </a>
                    </DialogFooter>
                </DialogContent>
            </Dialog>
        </AuthenticatedLayout>
    );
}