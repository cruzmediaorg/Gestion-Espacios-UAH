import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import './index.css';
import { extend, isNullOrUndefined } from '@syncfusion/ej2-base';
import { useRef, useState } from 'react';
import { registerLicense } from '@syncfusion/ej2-base';
import { router } from "@inertiajs/react";
import { ScheduleComponent, ViewsDirective, ViewDirective, TimelineViews, Inject, ResourcesDirective, ResourceDirective } from '@syncfusion/ej2-react-schedule';
import {
    Drawer,
    DrawerContent,
    DrawerClose
} from "@/Components/ui/drawer"
import { ScrollArea } from "@/Components/ui/scroll-area"
import Form from '../Reservas/Form';
import { X } from 'lucide-react';
import { Button } from '@/Components/ui/button';
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogHeader,
    DialogTitle,
} from "@/Components/ui/dialog"
import ReactIf from "@/lib/ReactIf";

export default function Calendario({ auth, espacios, reservas, espaciosRaw, tipo, localizacion, localizaciones = {}, clave, usuarios }) {

    registerLicense(clave);

    const data = reservas.map(reserva => ({
        ...reserva,
        StartTime: new Date(reserva.StartTime),
        EndTime: new Date(reserva.EndTime),
    }));
    const extendedData = extend([], data, null, true);
    const [startTime, setStartTime] = useState('07:00');
    const [endTime, setEndTime] = useState('22:00');
    const [startHour, setStartHour] = useState(startTime);
    const [endHour, setEndHour] = useState(endTime);
    const [selectedDate, setSelectedDate] = useState(new Date());
    const [openDrawer, setOpenDrawer] = useState(false);
    const [espaciosDrawer, setEspaciosDrawer] = useState(espacios);
    const [fechaDrawer, setFechaDrawer] = useState(new Date());
    const [horaInicioDrawer, setHoraInicioDrawer] = useState('07:00');
    const [horaFinDrawer, setHoraFinDrawer] = useState('22:00');
    const [mostrarDialogInfo, setMostrarDialogInfo] = useState(false);
    const [reservaDialogData, setReservaDialogData] = useState(null);

    let scheduleObj = useRef(null);

    const getCodigoEspacio = (value) => {
        return value.resourceData[value.resource.textField];
    };
    const getTipoEspacio = (value) => {
        return value.resourceData.type;
    };
    const getCapacidadEspacio = (value) => {
        return value.resourceData.capacity;
    };
    const isReadOnly = (endDate) => {
        return (endDate < new Date());
    };
    const resourceHeaderTemplate = (props) => {
        return (
            <div className="template-wrap">
                <div className="room-name flex items-center justify-center text-md font-bold">{getCodigoEspacio(props)}</div>
                <div className="room-type flex justify-center items-center text-center">{getTipoEspacio(props)}</div>
                <div className="room-capacity flex justify-center items-center">{getCapacidadEspacio(props)} pax</div>
            </div>
        );
    };
    const onActionBegin = (args) => {
        if (args.requestType === 'eventCreate' || args.requestType === 'eventChange') {
            let data = args.data instanceof Array ? args.data[0] : args.data;
            args.cancel = !scheduleObj.current.isSlotAvailable(data);
        }
    };
    const onEventRendered = (args) => {
        let data = args.data;
        if (isReadOnly(data.EndTime)) {
            args.element.setAttribute('aria-readonly', 'true');
            args.element.classList.add('e-read-only');
        }
    };
    const onRenderCell = (args) => {
        if (args.element.classList.contains('e-work-cells')) {
            if (!scheduleObj.current.isSlotAvailable(args.date)) {
                args.element.setAttribute('aria-readonly', 'true');
                args.element.classList.add('e-read-only-cells');
            }
        }
        if (args.elementType === 'emptyCells' && args.element.classList.contains('e-resource-left-td')) {
            let target = args.element.querySelector('.e-resource-text');
            target.innerHTML = '<div class="name flex justify-center bg-uahBlue text-white">Espacio</div><div class="type flex justify-center bg-uahBlue text-white">Tipo</div><div class="capacity flex justify-center bg-uahBlue text-white">Capacidad</div>';
        }
    };
    const onPopupOpen = (args) => {
        let data = args.data;

       if (args.type === 'QuickInfo') {
            console.log(args);
            if (args.data.Id)
            {
                args.cancel = true;
                setReservaDialogData(args.data);
                setMostrarDialogInfo(true);
            } else 
            {
     // dejamos en el dialog solo el espacio que se ha seleccionado
     args.cancel = true;
     let espaciosFiltrados = espaciosRaw.filter(espacio => espacio.id === args.data.RoomId);
     setEspaciosDrawer(espaciosFiltrados);     
     setFechaDrawer(args.data.StartTime)
     setHoraInicioDrawer(args.data.StartTime.toLocaleTimeString().slice(0, 5));
     setHoraFinDrawer(args.data.EndTime.toLocaleTimeString().slice(0, 5));   
     setOpenDrawer(true);
            }

          
        }
    };

    const filterByTipoEspacio = (tipoEspacio) => {
        if (localizacion)
            router.get('/calendario', { tipo: tipoEspacio, localizacion: localizacion }, { replace: true });
        else
            router.get('/calendario', { tipo: tipoEspacio }, { replace: true });
    }

    const filterByLocalizacion = (localizacion) => {
        if (tipo)
            router.get('/calendario', { tipo: tipo, localizacion: localizacion }, { replace: true });
        else
            router.get('/calendario', { localizacion: localizacion }, { replace: true });
    }

    const eventTemplate = (props) => {
        let className = '';
        switch (props.Status) {
            case 'aprobada':
                className = 'bg-green-500';
                break;
            case 'pendiente':
                className = 'bg-yellow-500';
                break;
            case 'cancelada':
                className = 'bg-red-500';
                break;
            case 'rechazada':
                    className = 'bg-red-500';
                    break;
            default:
                className = 'bg-black';
        }
        return (
            <div className={`${className} pl-2 -ml-2`}>
                <div className="w-72 m-0">{props.Subject}</div>
                <div className="font-bold">{props.StartTime.toLocaleTimeString().slice(0, 5)}h. - {props.EndTime.toLocaleTimeString().slice(0, 5)}h.</div>
            </div>
        );
    };

    return (
        <AuthenticatedLayout user={auth.user}>


{/* Dialogo info */}
{mostrarDialogInfo &&
                <Dialog open={mostrarDialogInfo} onOpenChange={() => { setMostrarDialogInfo(false) }}>
                    <DialogContent >
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
            <div>{reservaDialogData.User}</div>
        </div>
        <div className="grid gap-2">
            <div className="font-bold">Fecha:</div>
            <div>{reservaDialogData.Dia}</div>
        </div>
        <div className="grid gap-2">
            <div className="font-bold">Hora de inicio:</div>
            <div>{reservaDialogData.HoraInicio}</div>
        </div>
        <div className="grid gap-2">
            <div className="font-bold">Hora de fin:</div>
            <div>{reservaDialogData.HoraFin}</div>
        </div>
        <div className="grid gap-2">
            <div className="font-bold">Espacio:</div>
            <div>
                {reservaDialogData.Espacio}
            </div>
        </div>
        <div className="grid gap-2">
            <div className="font-bold">Estado:</div>
            <div className="uppercase font-bold">{reservaDialogData.Status}</div>
        </div>
        <div className="grid gap-2 col-span-2">
            <div className="font-bold">Comentarios:</div>
            <div>{reservaDialogData.Comentario}</div>
        </div>
    </div>

    <div className="grid gap-4 py-4">
        <Button
            onClick={() => { setMostrarDialogInfo(false) }}
            variant="outline" className="w-full">Cerrar</Button>
            {reservaDialogData.SePuedeEditar}
            <ReactIf condition={reservaDialogData.SePuedeEditar}>
        <Button
            onClick={() => { router.get('/reservas/' + reservaDialogData.ReservaId + '/gestionar') }}
            variant="blue" className="w-full">Gestionar</Button>
    </ReactIf>
    </div>
</div>

                    </DialogContent>
                </Dialog>
            }


                {openDrawer &&
                <Drawer open={openDrawer}
                    onOpenChange={() => { router.get('/calendario') }}
                    direction='right'
                >
                    <DrawerContent className='h-screen top-0 right-0 left-auto mt-0 w-[500px] rounded-none'>
                        <ScrollArea className='h-screen'>
                            <DrawerClose className='fixed right-4'>
                                <Button variant='ghost' onClick={() => { router.get('/calendario') }}>
                                    <X size={24} />
                                </Button>
                            </DrawerClose>

                            <Form bloquearFechaYHora={true}
                                 seleccionarPrimero={true}
                                  isEdit={false} 
                                  espacios={espaciosDrawer} 
                                  usuarios={usuarios} 
                                  fecha={fechaDrawer}
                                  hora_inicio={horaInicioDrawer}
                                  hora_fin={horaFinDrawer}
                                  recursos={null} />
                        </ScrollArea>
                    </DrawerContent>
                </Drawer>
            }
            <div className="flex flex-col justify-center items-center mb-4">
                <h1 className="text-3xl font-bold text-uahBlue">Calendario de Reservas</h1>
                <div className="flex w-full gap-2 justify-center items-center">
                    <select className="form-select mt-4 block w-1/4"
                        value={tipo}
                        onChange={(e) => {
                            filterByTipoEspacio(e.target.value);
                        }}>
                        <option value="all">Todos</option>
                        <option value="laboratorio">Laboratorio</option>
                        <option value="aula">Aula</option>
                        <option value="Sala de Reuniones">Sala Reuniones</option>
                        <option value="despacho">Despacho</option>
                        <option value="sala de trabajo">Sala de trabajo</option>
                    </select>
                    <select className="form-select mt-4 block w-1/4"
                        value={localizacion}
                        onChange={(e) => {
                            filterByLocalizacion(e.target.value);
                        }}>
                        <option value="all">Todas</option>
                        {Object.keys(localizaciones).map((key) => (
                            <option key={key} value={key}>{localizaciones[key]}</option>
                        ))}
                    </select>
                </div>
            </div>
            <div className='schedule-control-section'>
                <div className='col-lg-12 control-section'>
                    <div className='control-wrapper'>
                        <ScheduleComponent
                            cssClass='timeline-resource'
                            ref={scheduleObj}
                            width='100%'
                            height='auto'
                            startHour={startHour}
                            endHour={endHour}
                            enablePersistence={true}
                            workHours={{ start: '07:00', end: '21:00' }}
                            timeScale={{ interval: 60, slotCount: 1 }}
                            resourceHeaderTemplate={resourceHeaderTemplate}
                            eventSettings={{
                                dataSource: extendedData,
                                fields: {
                                    id: 'Id', subject: { title: 'Summary', name: 'Subject' },
                                    location: { title: 'Location', name: 'Location' },
                                    description: { title: 'Comments', name: 'Description' },
                                    startTime: { title: 'From', name: 'StartTime' },
                                    endTime: { title: 'To', name: 'EndTime' }
                                },
                                template: eventTemplate
                            }}
                            eventRendered={onEventRendered}
                            popupOpen={onPopupOpen}
                            actionBegin={onActionBegin}
                            renderCell={onRenderCell}
                            timezone='UTC'
                            group={{ enableCompactView: true, resources: ['MeetingRoom'] }}>
                            <ResourcesDirective>
                                <ResourceDirective field='RoomId' title='Room Type' name='MeetingRoom' allowMultiple={true} dataSource={espacios} textField='text' idField='id' colorField='color' />
                            </ResourcesDirective>
                            <ViewsDirective>
                                <ViewDirective option='TimelineDay' dateFormat="d-MM-y" />
                                <ViewDirective option='TimelineWeek' />
                            </ViewsDirective>
                            <Inject services={[TimelineViews]} />
                        </ScheduleComponent>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
