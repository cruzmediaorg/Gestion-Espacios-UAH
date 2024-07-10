import React from 'react';
import { Head } from '@inertiajs/react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { format } from 'date-fns';
import { es } from 'date-fns/locale';

export default function Show({ auth, reserva }) {
    return (
        <AuthenticatedLayout user={auth.user}>
            <Head title={`Reserva - ${reserva.reservable.nombreConLocalizacion}`} />

            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div className="p-6 text-gray-900">
                            <h2 className="text-2xl font-semibold mb-6">Detalles de la Reserva</h2>

                            <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <h3 className="text-lg font-semibold mb-3">Información de la Reserva</h3>
                                    <p><strong>Reserva #{reserva.id} - {reserva.curso}</strong></p>
                                    <p><strong>Fecha:</strong> {format(new Date(reserva.fecha), "d 'de' MMMM 'de' yyyy", { locale: es })}</p>
                                    <p><strong>Hora de inicio:</strong>{reserva.hora_inicio} </p>
                                    <p><strong>Hora fin:</strong> {reserva.hora_fin}</p>
                                    <p><strong>Estado:</strong> <span className='uppercase'>{reserva.estado}</span></p>
                                    <p><strong>Comentario:</strong> {reserva.comentario}</p>
                                </div>

                                <div>
                                    <h3 className="text-lg font-semibold mb-3">Información del Espacio</h3>
                                    <p><strong>Nombre:</strong> {reserva.reservable.nombreConLocalizacion}</p>
                                    <p><strong>Capacidad:</strong> {reserva.reservable.capacidad} personas</p>
                                    <h4 className="font-semibold mt-3 mb-2">Equipamientos:</h4>
                                    <ul className="list-disc list-inside">
                                        {reserva.reservable.equipamientos.map((equipo, index) => (
                                            <li key={index}>
                                              
                                                {equipo.equipamiento.nombre} ({equipo.cantidad})
                                                </li>
                                        ))}
                                    </ul>
                                </div>
                            </div>

                        
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}