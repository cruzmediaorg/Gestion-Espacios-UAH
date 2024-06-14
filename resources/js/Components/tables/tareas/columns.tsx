
import { ColumnDef } from "@tanstack/react-table"
import { Button } from "@/Components/ui/button"
import Checkbox from "@/Components/Checkbox"
import { router } from "@inertiajs/react"
export type Curso = {
    id: string
    nombre: string,
    periodo: string,
    asignatura: string,
    dias: string,
    hora_inicio: string,
    hora_fin: string,
    cantidad_horas: string,
    alumnos_matriculados: string,
}

export const columns: ColumnDef<Curso>[] = [
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
    },
    {
        header: 'Fecha de fin',
        accessorKey: 'hora_fin',
    },
    {
        header: 'Resultado',
        accessorKey: 'resultado'
    },
]
