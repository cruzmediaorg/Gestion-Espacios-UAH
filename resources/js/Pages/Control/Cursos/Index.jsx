import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { columns } from '@/Components/tables/cursos/columns';
import { DataTable } from '@/Components/tables/cursos/data-table';


export default function Index({ auth, cursos, periodos }) {

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={<div className='flex justify-between items-center'> <h2 className="font-semibold text-xl text-gray-800 leading-tight">Cursos</h2>
            </div>}
        >
            <div className="h-full overflow-y-scroll">
                <div className="">
                    <DataTable columns={columns} data={cursos} periodos={periodos} />
                </div>
            </div>
        </AuthenticatedLayout >
    );
}
