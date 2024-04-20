
import { ColumnDef } from "@tanstack/react-table"
import { Button } from "@/Components/ui/button"
import { ArrowUpDown } from "lucide-react"
import { Badge } from "@/Components/ui/badge"
import Checkbox from "@/Components/Checkbox"
import { router } from "@inertiajs/react"
export type Usuario = {
    id: string
    name: string
    email: string
    tipo: string
    created_at: string
}

export const columns: ColumnDef<Usuario>[] = [
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
        accessorKey: 'name',
    },
    {
        accessorKey: 'email',
        header: ({ column }) => {
            return (
                <Button
                    variant="ghost"
                    onClick={() => column.toggleSorting(column.getIsSorted() === "asc")}
                >
                    Correo
                    <ArrowUpDown className="ml-2 scale-50" />
                </Button>
            )
        },
    },
    {
        header: 'Rol',
        accessorKey: 'tipo',
        cell: (row) => {
            return (
                <div className="flex items-center gap-2">
                    <Badge variant="default" className="uppercase">{row.getValue() as string}</Badge>
                </div>
            )
        }
    },
    {
        header: 'Fecha de Creación',
        accessorKey: 'created_at',
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
                            router.get(route('usuarios.edit', { id: row.row.original.id }))
                        }}
                    >
                        Editar
                    </Button>
                    <Button
                        variant="destructive"
                        onClick={() => {
                            console.log('Delete', row)
                        }}
                    >
                        Eliminar
                    </Button>
                </div>
            )
        },
    },
]