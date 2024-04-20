
import { ColumnDef } from "@tanstack/react-table"
import { Button } from "@/Components/ui/button"
import { ArrowUpDown } from "lucide-react"
import { Badge } from "@/Components/ui/badge"
import Checkbox from "@/Components/Checkbox"
import { router } from "@inertiajs/react"
export type Espacio = {
    id: string
    nombre: string
    tipo: string
    localizacion: string
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
        header: 'Nombre',
        accessorKey: 'nombre',
        cell: (row) => {
            return (
                <div className="flex items-center gap-2">
                    {row.row.original.nombre}
                </div>
            )
        }
    },

    {
        header: 'Acciones',
        accessorKey: 'actions',
        cell: (row) => {
            return (
                <div className="flex justify-center gap-2">
                    <Button
                        variant="default"
                        onClick={() => {
                            router.get(route('grados.asignaturas.edit', { id: row.row.original.pivot.id }))
                        }}
                    >
                        Editar
                    </Button>
                    <Button
                        variant="destructive"
                        onClick={() => {
                            router.delete(route('grados.asignaturas.destroy', { id: row.row.original.pivot.id }))
                        }}
                    >
                        Eliminar
                    </Button>
                </div>
            )
        },
    },
]