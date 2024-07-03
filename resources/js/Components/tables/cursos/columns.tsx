
import { ColumnDef } from "@tanstack/react-table"
import { Button } from "@/Components/ui/button"
import Checkbox from "@/Components/Checkbox"
import { router } from "@inertiajs/react"
export type Curso = {
    id: string
    asignatura: {
        id: string
        nombre: string
    }
    alumnos_matriculados: number
    periodo: {
        id: string
        nombre: string
    },
    docentes_count: number
}

export const columns: ColumnDef<Curso>[] = [
    // {
    //     id: "select",
    //     header: ({ table }) => (
    //         <Checkbox
    //             checked={
    //                 table.getIsAllPageRowsSelected() ||
    //                 (table.getIsSomePageRowsSelected() && "indeterminate")
    //             }
    //             onChange={(value) => table.toggleAllPageRowsSelected(!!value)}
    //             aria-label="Select all rows"
    //         />
    //     ),
    //     cell: ({ row }) => (
    //         <Checkbox
    //             checked={row.getIsSelected()}
    //             onChange={(value) => row.toggleSelected(!!value)}
    //             aria-label="Select row"
    //         />
    //     ),
    // },
    {
        header: 'Asignatura',
        accessorKey: 'asignatura',
        accessorFn: (row) => row.asignatura.nombre,
        cell: ({ row }) => (
            <div className="flex items-center">
                <div className="text-sm font-medium text-gray-900">{row.original.asignatura.nombre}</div>
                <span className="text-sm px-2 rounded-md bg-gray-200 text-black ml-2">{row.original.periodo.nombre}</span>
            </div>
        ),
    },
    {
        header: 'Alumnos matriculados',
        accessorKey: 'alumnos_matriculados',
    },
    {
        header: 'Docentes',
        accessorKey: 'docentes_count',
    },
    {
        accessorKey: 'periodo',
        header: 'Periodo',
        enableHiding: true,
        cell: ({ row }) => row.original.periodo.nombre,
        accessorFn: (row) => row.periodo.nombre,
    },
    {
        header: 'Acciones',
        accessorKey: 'actions',
        cell: ({ row }) => (
            <div className="flex items-center">
                <Button
                    onClick={() => router.visit(`/control/cursos/${row.original.id}`)}
                    className="mr-2"
                    variant="blue"
                    size="sm"
                >
                    Ver
                </Button>
                {/*<Button*/}
                {/*    onClick={() => router.visit(`/cursos/${row.original.id}/edit`)}*/}
                {/*    className="mr-2"*/}
                {/*    variant="default"*/}
                {/*    size="sm"*/}
                {/*>*/}
                {/*    Editar*/}
                {/*</Button>*/}
                {/*<Button*/}
                {/*    onClick={() => router.visit(`/cursos/${row.original.id}/delete`)}*/}
                {/*    variant="destructive"*/}
                {/*    size="sm"*/}
                {/*>*/}
                {/*    Eliminar*/}
                {/*</Button>*/}
            </div>
        ),
    },



]
