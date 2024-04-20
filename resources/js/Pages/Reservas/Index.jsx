import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { columns } from '@/Components/tables/reservas/columns';
import { DataTable } from '@/Components/tables/reservas/data-table';
import { Button } from '@/Components/ui/button';
import { router } from '@inertiajs/react';
import {
    Drawer,
    DrawerContent,
    DrawerClose
} from "@/Components/ui/drawer"
import { ScrollArea } from "@/Components/ui/scroll-area"
import Form from './Form';
import { X } from 'lucide-react';


export default function Index({ auth, reservas, openDrawer = false, isEdit = false, reserva = {}, espacios = {}, usuarios = {}, recursos = {} }) {

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={<div className='flex justify-between items-center'> <h2 className="font-semibold text-xl text-gray-800 leading-tight">Reserva</h2><Button
                onClick={() => {
                    router.get('/reservas/create')
                }
                }
                variant="blue">
                Nueva reserva
            </Button></div>}
        >
            <div className="h-full overflow-y-scroll">
                <div className="">
                    <DataTable columns={columns} data={reservas} />
                </div>
            </div>

            {openDrawer &&
                <Drawer open={openDrawer} direction='right' >
                    <DrawerContent className='h-screen top-0 right-0 left-auto mt-0 w-[500px] rounded-none'>
                        <ScrollArea className='h-screen'>
                            <DrawerClose className='fixed right-4'>
                                <Button variant='ghost' onClick={() => { router.get('/reservas') }}>
                                    <X size={24} />
                                </Button>
                            </DrawerClose>

                            <Form isEdit={isEdit} reserva={reserva} espacios={espacios} usuarios={usuarios} recursos={recursos} />
                        </ScrollArea>
                    </DrawerContent>
                </Drawer>
            }


        </AuthenticatedLayout >
    );
}