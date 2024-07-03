
import { ColumnDef } from "@tanstack/react-table"
import { Button } from "@/Components/ui/button"
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
    curso: Curso
}

type Reservable = {
    id: string
    nombre: string
}

type User = {
    id: string
    name: string
}

type Curso = {
    id: string
    nombre: string
}

function puedeGestionar(auth, original: TData) {

    if (auth.user.id === original.asignado_a.id) {
        return true
    }

    if (auth.permisos.includes('Gestionar reservas')) {
        return true
    }

    // console.log('No puede gestionar', auth, original)
    return false
}

function puedeEditar(auth, original: TData) {
    // Si es el mismo usuario que reservó
    if (auth.user.id === original.asignado_a.id) {
        return true
    }

    // Si tiene permisos de gestionar reservas
    return !!auth.permisos.includes('Gestionar reservas');

}

export const columns = (auth) => [


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
        header: 'Curso',
        accessorKey: 'curso',
        cell: (row) => {
            return (
                <div className="flex items-center gap-2">
                    {row.row.original.curso?.nombre || '-'}
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
                    {puedeEditar(auth, row.row.original) && (
                        <Button
                            variant="default"
                            disabled={row.row.original.estado === 'cancelada' || row.row.original.estado === 'cerrada'}
                            onClick={() => {
                                router.get(route('reservas.edit', { id: row.row.original.id }))
                            }}
                        >
                            Editar
                        </Button>
                    )}
                    {puedeGestionar(auth, row.row.original) && (
                        <Button
                            disabled={row.row.original.estado === 'cancelada' && !auth.permisos.includes('Gestionar reservas') || row.row.original.estado === 'cerrada'}
                            variant="blue"
                            onClick={() => {
                                router.get(route('reservas.gestionar', { id: row.row.original.id }))
                            }}
                        >
                            Gestionar
                        </Button>
                    )}

                </div>
            )
        },
    },
]
