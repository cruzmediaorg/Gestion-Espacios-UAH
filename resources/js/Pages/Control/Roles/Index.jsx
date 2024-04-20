import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { columns } from '@/Components/tables/roles/columns';
import { DataTable } from '@/Components/tables/roles/data-table';
import { Link } from '@inertiajs/react';

export default function Index({ auth, roles }) {

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={<div className='flex justify-between items-center'> <h2 className="font-semibold text-xl text-gray-800 leading-tight">Roles</h2>
                <Link className="bg-uahBlue text-white px-5 py-2" href={route('roles.create')}>
                    Crear
                </Link></div>}
        >
            <div className="h-full overflow-y-scroll">
                <div className="">
                    <DataTable columns={columns} data={roles} />
                </div>
            </div>
        </AuthenticatedLayout >
    );
}