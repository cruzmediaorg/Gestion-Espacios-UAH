
import { ColumnDef } from "@tanstack/react-table"
import { Button } from "@/Components/ui/button"
import { ArrowUpDown } from "lucide-react"
import { Badge } from "@/Components/ui/badge"
import Checkbox from "@/Components/Checkbox"
import { router } from "@inertiajs/react"
export type Log = {
    log_name: string,
    description: string,
    causer: string,
    created_at: string,
    created_at_human: string,
    more_info_url: string,
}

export const columns: ColumnDef<Log>[] = [
    {
        header: 'ID',
        accessorKey: 'id',

    },
    {
        header: 'Tipo',
        accessorKey: 'log_name',
    },
    {
        header: 'Acción',
        accessorKey: 'description',
        cell: (row) => {
            return <div className="flex items-center">
                <span className="ml-2 font-bold">{row.row.original.description}</span>
                <span className="ml-2">
                   { row.row.original.more_info_url &&
                    <a href={row.row.original.more_info_url} target="_blank" className="text-blue-500">Ver más</a>
                     }
                </span>
            </div>
        }
    },
    {
        header: 'Fecha',
        accessorKey: 'created_at_human',
        cell: (row) => {
            return <div className="flex items-center">
                <span className="ml-2 font-bold">{row.row.original.created_at_human}</span>
            </div>
        }
    },
    {
        header: 'Causante',
        accessorKey: 'causer',
    },

]
