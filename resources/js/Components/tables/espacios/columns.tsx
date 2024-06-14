
import { ColumnDef } from "@tanstack/react-table"
import { Button } from "@/Components/ui/button"
import { Badge } from "@/Components/ui/badge"
import Checkbox from "@/Components/Checkbox"
import { router } from "@inertiajs/react"
export type Espacio = {
    id: string
    nombre: string
    tipo: {
        id: string
        nombre: string
    }
    localizacion: {
        id: string
        nombre: string
    }
}

export const columns: ColumnDef<Espacio>[] = [
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
        accessorKey: 'tipo',
        accessorFn: (row) => row.tipo.nombre,
        cell: (row) => {
            return (
                <div className="flex items-center justify-center gap-2">
                    <Badge>{row.row.original.tipo.nombre}</Badge>
                </div>
            )
        }
    },
    {
        header: 'Localización',
        accessorKey: 'localizacion',
        accessorFn: (row) => row.localizacion.nombre,
        cell: (row) => {
            return (
                <div className="flex items-center justify-center gap-2">
                    {row.row.original.localizacion.nombre}
                </div>
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
                            router.get(route('espacios.edit', { id: row.row.original.id }))
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
