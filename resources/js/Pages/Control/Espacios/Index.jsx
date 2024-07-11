import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { columns } from '@/Components/tables/espacios/columns';
import { DataTable } from '@/Components/tables/espacios/data-table';
import { Button } from '@/Components/ui/button';
import { router } from '@inertiajs/react';

export default function Index({ auth, espacios, tiposEspacios, localizaciones }) {

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={<div className='flex justify-between items-center'> <h2 className="font-semibold text-xl text-gray-800 leading-tight">Espacios</h2><Button
                type="button"
                onClick={() => router.get(route('espacios.create'))}
                variant="blue">
                Crear
            </Button></div>}
        >
            <div className="h-full overflow-y-scroll">
                <div className="">
                    <DataTable columns={columns(auth)} data={espacios} tiposEspacios={tiposEspacios} localizaciones={localizaciones} />
                </div>
            </div>
        </AuthenticatedLayout >
    );
}