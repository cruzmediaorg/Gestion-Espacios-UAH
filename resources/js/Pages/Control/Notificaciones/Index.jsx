import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { columns } from '@/Components/tables/notificaciones/columns';
import { DataTable } from '@/Components/tables/notificaciones/data-table';
import { Button } from '@/Components/ui/button';
import { router } from '@inertiajs/react';

export default function Index({ auth, notifications }) {

    return (
        <AuthenticatedLayout
            user={auth.user}
        >
            <div className="h-full overflow-y-scroll">
                <div className="">
                    <DataTable columns={columns} data={notifications} />
                </div>
            </div>
        </AuthenticatedLayout >
    );
}
