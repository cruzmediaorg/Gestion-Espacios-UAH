import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { columns } from '@/Components/tables/usuarios/columns';
import { DataTable } from '@/Components/tables/usuarios/data-table';
import { Button } from '@/Components/ui/button';

export default function Index({ auth, users }) {

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={<div className='flex justify-between items-center'> <h2 className="font-semibold text-xl text-gray-800 leading-tight">Usuarios</h2><Button variant="blue">
                Crear
            </Button></div>}
        >
            <div className="h-full overflow-y-scroll">
                <div className="">
                    <DataTable columns={columns} data={users} />
                </div>
            </div>
        </AuthenticatedLayout >
    );
}