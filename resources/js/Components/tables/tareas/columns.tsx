
import { ColumnDef } from "@tanstack/react-table"
import { Button } from "@/Components/ui/button"
import Checkbox from "@/Components/Checkbox"
import { router } from "@inertiajs/react"
import {Badge} from "../../ui/badge";
export type Tarea = {
    id: string
    fecha_inicio: string
    fecha_fin: string
    fecha_ejecucion: string
    estado: string
    resultado: string
}

export const columns: ColumnDef<Tarea>[] = [
    {
        id: "select",
        header: ({ table }) => (
            <Checkbox
                checked={
                    table.getIsAllPageRowsSelected() ||
                    (table.getIsSomePageRowsSelected() && "indeterminate")
                }
                onChange={(value) => table.toggleAllPageRowsSelected(!!value)}
                aria-label="Select all rows"
            />
        ),
        cell: ({ row }) => (
            <Checkbox
                checked={row.getIsSelected()}
                onChange={(value) => row.toggleSelected(!!value)}
                aria-label="Select row"
            />
        ),
    },
    {
        header: 'ID',
        accessorKey: 'id',

    },

    {
        header: 'Fecha de inicio',
        accessorKey: 'hora_inicio',
        cell: ({ row }) => {
            return <span>{row.original.fecha_inicio}</span>
        }
    },
    {
        header: 'Fecha de fin',
        accessorKey: 'hora_fin',
        cell: ({ row }) => {
            return <span>{row.original.fecha_fin}</span>
        }
    },
    {
        header: 'Fecha de ejecución',
        accessorKey: 'hora_ejecucion',
        cell: ({ row }) => {
            return <span>{row.original.fecha_ejecucion}</span>
        }
    },
    {
        header: 'Estado',
        accessorKey: 'estado',
        cell: ({ row }) => {
            return (
                <Badge variant={row.original.estado} className="uppercase">
                    {row.original.estado}
                </Badge>
            )
        }
    },
    {
        header: 'Resultado',
        accessorKey: 'resultado'
    },
]
