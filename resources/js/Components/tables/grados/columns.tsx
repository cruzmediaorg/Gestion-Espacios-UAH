
import { ColumnDef } from "@tanstack/react-table"
import { Button } from "@/Components/ui/button"
import Checkbox from "@/Components/Checkbox"
import { router } from "@inertiajs/react"
import { Badge } from "@/Components/ui/badge"
export type Grado = {
    id: string
    name: string
    tipoGrado: {
        id: string
        nombre: string
    }
}

export const columns: ColumnDef<Grado>[] = [
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
        header: 'Nombre',
        accessorKey: 'nombre',
    },
    {
        header: 'Tipo',
        accessorKey: 'tipoGrado',
        accessorFn: (row) => row.tipoGrado?.nombre,
        cell: (row) => {
            return (
                <Badge>{row.row.original.tipoGrado?.nombre}</Badge>
            )
        }
    },

    // actions
    {
        header: 'Acciones',
        accessorKey: 'actions',
        cell: (row) => {
            return (
                <div className="flex justify-center gap-2">
                    <Button
                        variant="default"
                        onClick={() => {
                            router.get(route('grados.edit', { id: row.row.original.id }))
                        }}
                    >
                        Editar
                    </Button>
                    <Button
                        variant="destructive"
                        onClick={() => {
                            router.delete(route('grados.destroy', { id: row.row.original.id }))
                        }}
                    >
                        Eliminar
                    </Button>
                </div>
            )
        },
    },
]