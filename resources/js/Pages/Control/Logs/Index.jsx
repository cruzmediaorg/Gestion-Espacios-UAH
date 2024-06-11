import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { columns } from '@/Components/tables/logs/columns';
import { DataTable } from '@/Components/tables/logs/data-table';
import { Button } from '@/Components/ui/button';
import { router } from '@inertiajs/react';

export default function Index({ auth, logs }) {

    return (
        <AuthenticatedLayout
            user={auth.user}
        >
            <div className="h-full overflow-y-scroll">
                <div className="">
                    <DataTable columns={columns} data={logs} />
                </div>
            </div>
        </AuthenticatedLayout >
    );
}
