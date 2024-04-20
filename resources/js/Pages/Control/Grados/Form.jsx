import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { useState } from 'react';
import { router, useForm } from '@inertiajs/react'

import { Input } from '@/Components/ui/input';
import { Button } from '@/Components/ui/button';
import { Label } from '@/Components/ui/label';
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
} from "@/Components/ui/dialog"
import {
    Popover,
    PopoverContent,
    PopoverTrigger,
} from "@/Components/ui/popover"

import { Check, ChevronsUpDown } from 'lucide-react';
import { cn } from "@/lib/utils"

import { CommandList } from 'cmdk';

import {
    Command,
    CommandEmpty,
    CommandGroup,
    CommandInput,
    CommandItem,
} from "@/Components/ui/command"

import { DataTable } from '@/Components/tables/grados/asignaturas/data-table';
import { columns } from '@/Components/tables/grados/asignaturas/columns';


export default function Edit({ auth, grado, tiposGrados = {}, asignaturas = {}, isEdit = false, isAsignaturaGradoEdit = false, AsignaturaGrado = {} }) {

    const { data, setData, put, post, processing, errors } = useForm({
        nombre: isEdit ? grado.nombre : '',
        tipoGrado_id: isEdit ? grado.tipoGrado.id : ''
    })

    const { data: nuevaAsignatura, setData: setNuevaAsignatura, put: putNuevaAsignatura, post: postNuevaAsignatura, processing: processingNuevaAsignatura, errors: errorsNuevaAsignatura } = useForm({
        asignatura_id: '',
        grado_id: grado.id
    })

    const { data: dataAsignatura, setData: setDataAsignatura, put: putAsignatura, post: postAsignatura, processing: processingAsignaturaGrado, errors: errorsAsignaturaGrado } = useForm({
        asignatura_id: isAsignaturaGradoEdit ? AsignaturaGrado.asignatura_id : '',
        grado_id: grado.id
    })

    const [openAsignaturas, setOpenAsignaturas] = useState(false)

    function submit(e) {
        e.preventDefault()
        if (isEdit) {
            put(route('grados.update', grado.id))
        } else {
            post(route('grados.store'))
        }
    }

    function submitNuevaAsignatura(e) {
        e.preventDefault()
        postNuevaAsignatura(route('grados.asignaturas.store', grado.id))

        setTimeout(() => {
            router.get(route('grados.edit', grado.id))
        }, 200)
    }

    function submitAsignatura(e) {
        e.preventDefault()
        putAsignatura(route('grados.asignaturas.update', AsignaturaGrado.id))
    }


    return (
        <AuthenticatedLayout
            user={auth.user}
            header={<div className='flex justify-between items-center'>
                <h2 className="font-semibold text-xl text-gray-800 leading-tight"> {isEdit ? 'Editar' : 'Crear'} grado</h2></div>}
        >
            <div className="h-full overflow-y-scroll">
                <div className="py-4">
                    <form onSubmit={submit}>
                        <div className="flex flex-col gap-2 w-full">
                            <Label>Nombre</Label>
                            <Input type="text" value={data.nombre} onChange={e => setData('nombre', e.target.value)} />
                            {
                                errors.nombre && <span className="text-red-600">{errors.nombre}</span>
                            }

                            <Label>Tipo de grado</Label>
                            <select
                                value={data.tipoGrado_id}
                                onChange={e => setData('tipoGrado_id', e.target.value)}
                                className="border border-gray-300 rounded-md w-full p-2"
                            >
                                <option value="">Seleccione...</option>
                                {tiposGrados.map(tipo => (
                                    <option key={tipo.id} value={tipo.id}>{tipo.nombre}</option>
                                ))}
                            </select>
                            {
                                errors.tipoGrado_id && <span className="text-red-600">{errors.tipoGrado_id}</span>
                            }

                            <Button type="submit" disabled={processing}>
                                {isEdit ? 'Guardar cambios' : 'Crear'}
                            </Button>
                        </div>
                    </form>
                    <hr className="my-4" />
                    {isEdit && (
                        < div >
                            <div className="flex justify-between items-center">
                                <h2 className="font-semibold text-xl text-gray-800 leading-tight">Asignaturas</h2>
                                <Dialog>
                                    <DialogTrigger>
                                        <Button variant='blue'>
                                            Agregar asignatura
                                        </Button>
                                    </DialogTrigger>
                                    <DialogContent>
                                        <DialogHeader>
                                            <DialogTitle>Agregar nueva asignatura</DialogTitle>
                                            <DialogDescription>
                                                <form className='flex flex-col gap-4' onSubmit={submitNuevaAsignatura}>
                                                    <Label>Asignatura</Label>
                                                    <Popover open={openAsignaturas} onOpenChange={setOpenAsignaturas}>
                                                        <PopoverTrigger asChild><Button variant="outline" role="combobox" aria-expanded={openAsignaturas} className="w-full max-w-[400px] justify-between">
                                                            {asignaturas.find(l => l.id === nuevaAsignatura?.asignatura_id)?.nombre || 'Selecciona una asignatura'}
                                                            <ChevronsUpDown className="ml-2 h-4 w-4 shrink-0 opacity-50" />
                                                        </Button>
                                                        </PopoverTrigger>
                                                        <PopoverContent>
                                                            <Command>
                                                                <CommandInput placeholder="Buscar..." />
                                                                <CommandEmpty>No se encontraron resultados</CommandEmpty>
                                                                <CommandGroup>
                                                                    <CommandList>
                                                                        {asignaturas.map((item) => (
                                                                            <CommandItem
                                                                                key={item.id}
                                                                                value={item.id}
                                                                                onSelect={() => {
                                                                                    setNuevaAsignatura('asignatura_id', item.id)
                                                                                    setOpenAsignaturas(false)
                                                                                }}
                                                                            >
                                                                                <Check className={cn("mr-2 h-4 w-4", nuevaAsignatura?.asignatura_id === item.id ? "opacity-100 " : "opacity-0")} />
                                                                                {item.nombre}
                                                                            </CommandItem>
                                                                        ))}
                                                                    </CommandList>
                                                                </CommandGroup>
                                                            </Command>
                                                        </PopoverContent>
                                                    </Popover>

                                                    <Button type="submit" disabled={processingNuevaAsignatura}>
                                                        Guardar cambios
                                                    </Button>
                                                </form>
                                            </DialogDescription>
                                        </DialogHeader>
                                    </DialogContent>
                                </Dialog>

                            </div>
                            <DataTable columns={columns} data={grado.asignaturas} />
                        </div>
                    )
                    }


                    {isAsignaturaGradoEdit && (
                        <Dialog open={isAsignaturaGradoEdit} onOpenChange={() => { router.get(route('grados.edit', grado.id)) }}>

                            <DialogContent>
                                <DialogHeader>
                                    <DialogTitle>Editar asignatura/grado</DialogTitle>
                                </DialogHeader>
                                <DialogDescription>
                                    <form onSubmit={submitAsignatura}>
                                        <Label>Asignatura</Label>
                                        <select
                                            value={dataAsignatura.asignatura_id}
                                            onChange={e => setDataAsignatura('asignatura_id', e.target.value)}
                                            className="border border-gray-300 rounded-md w-full p-2"
                                        >
                                            <option value="">Seleccione...</option>
                                            {asignaturas.map(asignatura => (
                                                <option key={asignatura.id} value={asignatura.id}>{asignatura.nombre}</option>
                                            ))}
                                        </select>

                                        {
                                            errors.asignatura_id && <span className="text-red-600">{errors.asignatura_id}</span>
                                        }





                                        <Button type="submit" className='mt-2' disabled={processingAsignaturaGrado}>
                                            Guardar cambios
                                        </Button>
                                    </form>
                                </DialogDescription>
                            </DialogContent>
                        </Dialog>
                    )
                    }
                </div>
            </div >
        </ AuthenticatedLayout >
    );
}