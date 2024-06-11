import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout"
import './index.css';
import { extend, isNullOrUndefined } from '@syncfusion/ej2-base';
import { useEffect, useRef, useState } from 'react';
import { registerLicense } from '@syncfusion/ej2-base';
import { router } from "@inertiajs/react";
import { ScheduleComponent, ViewsDirective, ViewDirective, TimelineViews, Inject, ResourcesDirective, ResourceDirective, Resize, DragAndDrop } from '@syncfusion/ej2-react-schedule';
export default function Calendario({ auth, espacios, reservas, tipo, localizacion, localizaciones = {}, clave }) {

    registerLicense(clave);
    const data = extend([], reservas, null, true);
    const [startTime, setStartTime] = useState('08:00');
    const [endTime, setEndTime] = useState('22:00');
    const [startHour, setStartHour] = useState(startTime);
    const [endHour, setEndHour] = useState(endTime);
    const [selectedDate, setSelectedDate] = useState(new Date());

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
        return (endDate < new Date(2021, 6, 31, 0, 0));
    };
    const resourceHeaderTemplate = (props) => {
        return (<div className="template-wrap">
            <div className="room-name flex items-center justify-center text-md font-bold">{getCodigoEspacio(props)}</div>
            <div className="room-type flex justify-center items-center  text-center">{getTipoEspacio(props)}</div>
            <div className="room-capacity flex justify-center items-center">{getCapacidadEspacio(props)} pax</div>
        </div>);
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
            if (args.date < new Date(2021, 6, 31, 0, 0)) {
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
        if (args.type === 'QuickInfo' || args.type === 'Editor' || args.type === 'RecurrenceAlert' || args.type === 'DeleteAlert') {
            let target = (args.type === 'RecurrenceAlert' ||
                args.type === 'DeleteAlert') ? args.element[0] : args.target;
            if (!isNullOrUndefined(target) && target.classList.contains('e-work-cells')) {
                if ((target.classList.contains('e-read-only-cells')) ||
                    (!scheduleObj.current.isSlotAvailable(data))) {
                    args.cancel = true;
                }
            }
            else if (!isNullOrUndefined(target) && target.classList.contains('e-appointment') &&
                (isReadOnly(data.EndTime))) {
                args.cancel = true;
            }
        }
    };

    const filterByTipoEspacio = (tipoEspacio) => {
        if (localizacion)
            router.get('/calendario', { tipo: tipoEspacio, localizacion: localizacion }, { replace: true })
        else
            router.get('/calendario', { tipo: tipoEspacio }, { replace: true })
    }

    const filterByLocalizacion = (localizacion) => {
        if (tipo)
            router.get('/calendario', { tipo: tipo, localizacion: localizacion }, { replace: true })
        else
            router.get('/calendario', { localizacion: localizacion }, { replace: true })
    }




    return (
        <AuthenticatedLayout
            user={auth.user}

        >
            <div className="flex flex-col justify-center items-center mb-4">
                <h1 className="text-3xl font-bold text-uahBlue">Calendario de Reservas</h1>
                <div className="flex w-full  gap-2 justify-center items-center">

                    <select className="form-select mt-4 block w-1/4"
                        value={tipo}
                        onChange={(e) => {
                            filterByTipoEspacio(e.target.value);
                        }
                        }>
                        <option value="all">Todos</option>
                        <option value="laboratorio">Laboratorio</option>
                        <option value="aula">Aula</option>
                        <option value="biblioteca">Biblioteca</option>
                        <option value="auditorio">Auditorio</option>
                        <option value="sala de reuniones">Sala de reuniones</option>
                    </select>

                    <select className="form-select mt-4 block w-1/4"
                        value={localizacion}
                        onChange={(e) => {
                            filterByLocalizacion(e.target.value);
                        }
                        }>
                        <option value="all">Todas</option>
                        {Object.keys(localizaciones).map((key) => (
                            <option key={key} value={key}>{localizaciones[key]}</option>
                        ))}
                    </select>
                </div>



            </div>
            < div className='schedule-control-section' >
                <div className='col-lg-12 control-section'>
                    <div className='control-wrapper'>
                        <ScheduleComponent
                            cssClass='timeline-resource'
                            ref={scheduleObj}
                            width='100%'
                            height='auto'
                            startHour={startHour}
                            endHour={endHour}
                            selectedDate={selectedDate}
                            workHours={{ start: '08:00', end: '18:00' }}
                            timeScale={{ interval: 30, slotCount: 1 }}
                            resourceHeaderTemplate={resourceHeaderTemplate}
                            eventSettings={{
                                dataSource: data,
                                fields: {
                                    id: 'Id', subject: { title: 'Summary', name: 'Subject' },
                                    location: { title: 'Location', name: 'Location' },
                                    description: { title: 'Comments', name: 'Description' },
                                    startTime: { title: 'From', name: 'StartTime' },
                                    endTime: { title: 'To', name: 'EndTime' }
                                }
                            }}
                            eventRendered={onEventRendered}
                            popupOpen={onPopupOpen}
                            actionBegin={onActionBegin}
                            renderCell={onRenderCell}
                            group={{
                                enableCompactView: false, resources: ['MeetingRoom']
                            }}>
                            <ResourcesDirective>
                                <ResourceDirective field='RoomId' title='Room Type' name='MeetingRoom' allowMultiple={true} dataSource={espacios} textField='text' idField='id' colorField='color' />
                            </ResourcesDirective>
                            <ViewsDirective>
                                <ViewDirective option='TimelineDay' dateFormat="d-MM-y" />
                                <ViewDirective option='TimelineWeek' />
                            </ViewsDirective>
                            <Inject services={[TimelineViews, Resize, DragAndDrop]} />
                        </ScheduleComponent>
                    </div>
                </div>

            </div >
        </AuthenticatedLayout >
    )
}