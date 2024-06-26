import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.jsx';
import { columns } from '@/Components/tables/tareas/columns.tsx';
import { DataTable } from '@/Components/tables/tareas/data-table.tsx';
import { router } from '@inertiajs/react';

export default function Index({ auth, tipoTarea, tareas }) {

    const lanzarTarea = (id) => () => {
        tipoTarea.parametros_requeridos !== null ? router.get(route('tareas.create', id)) :
            router.post(route('tareas.ejecutar', id));
    }

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={<div className='flex justify-between items-center'> <h2 className="font-semibold text-xl text-gray-800 leading-tight">{tipoTarea.nombre}</h2>
                <button className="bg-uahBlue text-white px-5 py-2"
                    onClick={lanzarTarea(tipoTarea.id)}>
                    Crear
                </button></div>}
        >
            <div className="h-full overflow-y-scroll">
                <div className="">
                    <DataTable columns={columns} data={tareas} />
                </div>
            </div>
        </AuthenticatedLayout >
    );
}
