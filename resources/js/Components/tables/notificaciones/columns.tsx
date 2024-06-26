
import { Button } from "@/Components/ui/button"
import { router } from "@inertiajs/react"
import { ColumnDef } from "@tanstack/react-table"
import {BellOff, Bell} from "lucide-react";

export type Notificacion = {
    id: string,
    data: {
        message: string,
    }
}

export const columns: ColumnDef<Notificacion>[] = [

    {
        header: 'Notificación',
        accessorKey: 'data',
        cell: (row) => {
            return <div className="flex items-center">
                <span className="ml-2 ">
                    {row.row.original.data.message}
                    <p className="text-xs text-gray-400"> {new Date(row.row.original.created_at).toLocaleString()}</p>
                </span>
            </div>
        }
    },
    // mark as read
    {
        header: '',
        accessorKey: 'read_at',
        cell: (row) => {
            return <div className="flex items-center">
                <Button variant={"ghost"} onClick={() => {
                    router.post(route('notificaciones.marcar-como-leida', { id: row.row.original.id }))
                }
                }> {row.row.original.read_at ? <Bell size={24}/> : <BellOff size={24}/> } </Button>
            </div>
        }
    },



]
