"use client"
import { Button } from "@/Components/ui/button"
import {
    ColumnDef,
    SortingState,
    flexRender,
    getCoreRowModel,
    getPaginationRowModel,
    ColumnFiltersState,
    getFilteredRowModel,
    useReactTable,
    getSortedRowModel,
} from "@tanstack/react-table"


import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from "@/Components/ui/table"


import React, { useState } from "react"
import { ChevronLeft, ChevronRight, BellOff } from "lucide-react"
import {router} from "@inertiajs/react";
import ReactIf from "@/lib/ReactIf"

interface DataTableProps<TData, TValue> {
    columns: ColumnDef<TData, TValue>[]
    data: TData[],
}

export function DataTable<TData, TValue>({
    columns,
    data,
}: DataTableProps<TData, TValue>) {
    const [sorting, setSorting] = useState<SortingState>([])
    const [columnFilters, setColumnFilters] = useState<ColumnFiltersState>([])
    const [rowSelection, setRowSelection] = useState({})

    const table = useReactTable({
        data,
        columns,
        getCoreRowModel: getCoreRowModel(),
        getPaginationRowModel: getPaginationRowModel(),
        onSortingChange: setSorting,
        getSortedRowModel: getSortedRowModel(),
        onColumnFiltersChange: setColumnFilters,
        getFilteredRowModel: getFilteredRowModel(),
        onRowSelectionChange: setRowSelection,
        state: {
            sorting,
            columnFilters,
            rowSelection,
        },
    })

    function markAllAsRead() {
        router.post(route("notificaciones.marcar-todas-como-leidas"))
    }

    return (
        <div>
            <div className="flex items-center justify-between w-full gap-2 p-2">
            <h2 className="text-xl font-bold">Notificaciones</h2>
              <ReactIf condition={table.getRowModel().rows?.length > 0 && table.getRowModel().rows.some((row) => !row.original.read_at)}>
                <div className="flex items-center gap-2">
                    <Button onClick={markAllAsRead}>Marcar todas como leídas</Button>
                </div>
                </ReactIf>


            </div>
            <ReactIf condition={table.getRowModel().rows?.length > 0}>
                <div className=" border bg-white">
                    <Table>
                        <TableHeader>
                            {table.getHeaderGroups().map((headerGroup) => (
                                <TableRow key={headerGroup.id}>
                                    {headerGroup.headers.map((header) => {
                                        return (
                                            <TableHead key={header.id}>
                                                {header.isPlaceholder
                                                    ? null
                                                    : flexRender(
                                                        header.column.columnDef.header,
                                                        header.getContext()
                                                    )}
                                            </TableHead>
                                        )
                                    })}
                                </TableRow>
                            ))}
                        </TableHeader>
                        <TableBody>
                            {table.getRowModel().rows?.length ? (
                                table.getRowModel().rows.map((row) => (
                                    <TableRow
                                        key={row.id}
                                        data-state={row.getIsSelected() && "selected"}
                                    >
                                        {row.getVisibleCells().map((cell) => (
                                            <TableCell key={cell.id}>
                                                {flexRender(cell.column.columnDef.cell, cell.getContext())}
                                            </TableCell>
                                        ))}
                                    </TableRow>
                                ))
                            ) : (
                                <TableRow>
                                    <TableCell colSpan={columns.length} className="h-24 text-center">
                                        No se encontraron resultados.
                                    </TableCell>
                                </TableRow>
                            )}
                        </TableBody>
                    </Table>
                </div>
                <div className="flex items-center justify-end space-x-2 py-4 gap-2">
                    <Button
                        variant="outline"
                        onClick={() => table.previousPage()}
                        disabled={!table.getCanPreviousPage()}
                    >
                        <ChevronLeft/>
                        Anterior
                    </Button>
                    <Button
                        variant="outline"
                        onClick={() => table.nextPage()}
                        disabled={!table.getCanNextPage()}
                    >
                        Siguiente
                        <ChevronRight/>
                    </Button>
                </div>
            </ReactIf>

            <ReactIf condition={table.getRowModel().rows?.length === 0}>
                <div className="flex items-center justify-center h-64 flex-col gap-4">
                    <BellOff className="w-24 h-24 text-gray-400"/>
                    <p className="text-gray-500">No hay notificaciones</p>
                </div>
            </ReactIf>

        </div>
    )
}
