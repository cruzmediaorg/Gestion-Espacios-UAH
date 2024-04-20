
import { ColumnDef } from "@tanstack/react-table"
import { Button } from "@/Components/ui/button"
import Checkbox from "@/Components/Checkbox"
import { router } from "@inertiajs/react"
export type Rol = {
    id: string
    name: string
}

export const columns: ColumnDef<Rol>[] = [
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
                            router.get(route('roles.edit', { id: row.row.original.id }))
                        }}
                    >
                        Editar
                    </Button>
                    <Button
                        variant="destructive"
                        onClick={() => {
                            router.delete(route('roles.destroy', { id: row.row.original.id }))
                        }}
                    >
                        Eliminar
                    </Button>
                </div>
            )
        },
    },
]