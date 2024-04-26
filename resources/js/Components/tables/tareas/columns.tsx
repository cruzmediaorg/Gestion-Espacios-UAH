
import { ColumnDef } from "@tanstack/react-table"
import { Button } from "@/Components/ui/button"
import Checkbox from "@/Components/Checkbox"
import { router } from "@inertiajs/react"
export type Tarea = {
    id: string
    nombre: string,
    fecha_inicio: string,
    fecha_fin: string,
    estado: string,
    resultado: string,
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
        accessorKey: 'fecha_inicio',
    },
    {
        header: 'Fecha de fin',
        accessorKey: 'fecha_fin',
    },
    {
        header: 'Estado',
        accessorKey: 'estado',
    },
    {
        header: 'Resultado',
        accessorKey: 'resultado'
    },



]