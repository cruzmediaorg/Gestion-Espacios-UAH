import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { columns } from '@/Components/tables/tipostareas/columns';
import { DataTable } from '@/Components/tables/tipostareas/data-table';


export default function Index({ auth, tiposTareas }) {

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={<div className='flex justify-between items-center'> <h2 className="font-semibold text-xl text-gray-800 leading-tight">Tipos Tareas</h2>
            </div>}
        >
            <div className="h-full overflow-y-scroll">
                <div className="">
                    <DataTable columns={columns} data={tiposTareas} />
                </div>
            </div>
        </AuthenticatedLayout >
    );
}