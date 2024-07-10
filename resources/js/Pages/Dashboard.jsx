import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link } from '@inertiajs/react';
import { format } from 'date-fns';
import { es } from 'date-fns/locale';


export default function Dashboard({ auth, proximasReservas, reservasRecientes, notificacionesSinLeer }) {
    const today = new Date();
    
    const reservasHoy = proximasReservas.filter(reserva => 
        new Date(reserva.fecha).toDateString() === today.toDateString()
    );

    const reservasFuturas = proximasReservas.filter(reserva => 
        new Date(reserva.fecha) > today
    );

    return (
        <AuthenticatedLayout user={auth.user}>
            <Head title="Dashboard" />

            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div className="px-4 pt-4 text-gray-900">
                            <h3 className="text-lg font-semibold mb-4">Hola, {auth.user.name}</h3>
                        </div>
                    </div>

                    <div className="p-6 bg-white overflow-hidden shadow-sm sm:rounded-lg mt-4">
                        {notificacionesSinLeer > 0 && (
                            <div className="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-4">
                                <p>Tienes {notificacionesSinLeer} notificaciones pendientes</p>
                                <Link href="/notificaciones" className="mt-2 inline-block bg-yellow-500 text-white px-4 py-2 rounded">
                                    Ver notificaciones
                                </Link>
                            </div>
                        )}

                        <div className="space-y-8">
                            <TimelineSection title="Próximas reservas" items={reservasFuturas} />
                            
                            <TimelineSection 
                                title={`Hoy ${format(today, "EEEE, d 'de' MMMM 'de' yyyy", { locale: es })}`} 
                                items={reservasHoy}
                                emptyMessage="Para hoy no hay nada"
                            />
                            
                            <TimelineSection title="Reservas pasadas" items={reservasRecientes} />
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}

function TimelineSection({ title, items, emptyMessage = "No hay reservas en esta sección." }) {
    return (
        <div className="relative">
            <div className="absolute left-4 top-0 bottom-0 w-0.5 bg-gray-200"></div>
            <h4 className="text-md font-semibold mb-4 pl-8 relative">
                <span className="absolute left-[14px] top-1/2 -translate-y-1/2 w-2 h-2 bg-blue-500 rounded-full"></span>
                {title}
            </h4>
            {items.length > 0 ? (
                <ul className="space-y-4 pl-8">
                    {items.map((reserva, index) => (
                        <li key={index} className="relative">
                            <span className="absolute -left-6 top-1/2 -translate-y-1/2 w-2 h-2 bg-gray-400 rounded-full"></span>
                            <div className="bg-gray-50 p-3 rounded-lg">
                                <p className="font-semibold">Reserva #{reserva.id} {reserva.reservable.nombreConLocalizacion} ({reserva.curso})</p>
                                <p className="text-sm text-gray-600">{reserva.reservable.tipoEspacioName}</p>
                                <p className="text-sm text-gray-500">{reserva.human_readable_date}</p>
                                <Link 
                                    href={`/reservas/${reserva.id}`} 
                                    className="mt-2 inline-block bg-blue-500 text-white text-sm px-3 py-1 rounded hover:bg-blue-600 transition"
                                >
                                    Ver reserva
                                </Link>
                            </div>
                        </li>
                    ))}
                </ul>
            ) : (
                <p className="pl-8 text-gray-500">{emptyMessage}</p>
            )}
        </div>
    );
}