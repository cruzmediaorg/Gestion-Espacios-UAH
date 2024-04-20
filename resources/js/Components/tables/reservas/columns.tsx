
import { ColumnDef } from "@tanstack/react-table"
import { Button } from "@/Components/ui/button"
import { ArrowUpDown } from "lucide-react"
import { Badge } from "@/Components/ui/badge"
import Checkbox from "@/Components/Checkbox"
import { router } from "@inertiajs/react"
export type Reserva = {
    id: string
    reservable: Reservable
    asignado_a: User
    fecha: string
    hora_inicio: string
    hora_fin: string
    estado: string
}

type Reservable = {
    id: string
    nombre: string
}

type User = {
    id: string
    name: string
}

export const columns: ColumnDef<Reserva>[] = [
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
        header: 'Espacio',
        accessorKey: 'reservable',
        accessorFn: (row) => row.reservable.nombre,
        cell: (row) => {
            return (
                <div className="flex items-center gap-2 w-40 text-xs overflow-hidden">
                    {row.getValue()}
                </div>
            )
        }
    },
    {
        header: 'Reservado por',
        accessorKey: 'asignado_a',
        cell: (row) => {
            return (
                <div className="flex items-center gap-2">
                    {row.getValue().name}
                </div>
            )
        }
    },
    {
        header: 'Fecha',
        accessorKey: 'fecha',
        cell: (row) => {
            return (
                <div className="flex flex-col items-center gap-1">
                    <p>{row.getValue()} </p><span className="font-bold">({row.row.original.hora_inicio} - {row.row.original.hora_fin})</span>
                </div>
            )
        }
    },
    {
        header: 'Estado',
        accessorKey: 'estado',
        cell: (row) => {
            return (
                <Badge variant={row.getValue()} className="uppercase">{row.getValue()}</Badge>
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
                            router.get(route('reservas.edit', { id: row.row.original.id }))
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