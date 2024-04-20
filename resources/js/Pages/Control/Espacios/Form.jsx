
import React from 'react';

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';

import { Input } from '@/Components/ui/input';
import { Button } from '@/Components/ui/button';
import { router, useForm } from '@inertiajs/react'
import { Label } from '@/Components/ui/label';
import { CommandList } from 'cmdk';
import {
    Command,
    CommandEmpty,
    CommandGroup,
    CommandInput,
    CommandItem,
} from "@/Components/ui/command"

import {
    Popover,
    PopoverContent,
    PopoverTrigger,
} from "@/Components/ui/popover"

import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
} from "@/Components/ui/dialog"


import { Check, ChevronsUpDown } from 'lucide-react';
import { cn } from "@/lib/utils"

import { DataTable } from '@/Components/tables/espacios/equipamientos/data-table';
import { columns } from '@/Components/tables/espacios/equipamientos/columns';


export default function Form({ auth, espacio, isEdit = false, localizaciones, tiposespacios, equipamientos = {}, isEquipamientoEspacioEdit = false, EquipamientoEspacio = {} }) {

    const [openLocalizaciones, setOpenLocalizaciones] = React.useState(false)
    const [openTiposEspacios, setOpenTiposEspacios] = React.useState(false)
    const [openEquipamientos, setOpenEquipamientos] = React.useState(false)

    const { data, setData, put, post, processing, errors } = useForm({
        nombre: isEdit ? espacio.nombre : '',
        localizacion_id: isEdit ? espacio.localizacion.id : '',
        tiposespacios_id: isEdit ? espacio.tipo.id : '',
        capacidad: isEdit ? espacio.capacidad : 0,
    })

    const { data: dataEquipamiento, setData: setDataEquipamiento, put: putEquipamiento, post: postEquipamiento, processing: processingEquipamiento, errors: errorsEquipamiento } = useForm({
        cantidad: isEquipamientoEspacioEdit ? EquipamientoEspacio.cantidad : 0,
    })

    const { data: nuevoEquipamiento, setData: setNuevoEquipamiento, put: putNuevoEquipamiento, post: postNuevoEquipamiento, processing: processingNuevoEquipamiento, errors: errorsNuevoEquipamiento } = useForm({
        cantidad: 0,
        equipamiento_id: 0,
        espacio_id: espacio ? espacio.id : 0
    })

    function submit(e) {
        e.preventDefault()
        if (isEdit) {
            put(route('espacios.update', espacio.id))
        } else {
            post(route('espacios.store'))
        }
    }

    function submitEquipamiento(e) {
        e.preventDefault()
        putEquipamiento(route('espacios.equipamiento.update', EquipamientoEspacio.id))
    }

    function submitNuevoEquipamiento(e) {
        e.preventDefault()
        postNuevoEquipamiento(route('espacios.equipamiento.store', espacio.id))

        setTimeout(() => {
            router.get(route('espacios.edit', espacio.id))
        }, 200)
    }

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={<div className='flex justify-between items-center'>
                <h2 className="font-semibold text-xl text-gray-800 leading-tight"> {isEdit ? 'Editar' : 'Crear'} espacio</h2></div>}
        >
            <div className="h-full overflow-y-scroll">
                <div className="py-4">
                    <form onSubmit={submit}>
                        <div className="flex flex-col gap-2 w-full">
                            <Label>Nombre</Label>
                            <Input type="text" value={data.nombre} onChange={e => setData('nombre', e.target.value)} />
                            <Label>Tipo de espacio</Label>

                            <Popover open={openTiposEspacios} onOpenChange={setOpenTiposEspacios}>
                                <PopoverTrigger asChild><Button variant="outline" role="combobox" aria-expanded={openTiposEspacios} className="w-full max-w-[400px] justify-between">
                                    {tiposespacios.find(t => t.id === data.tiposespacios_id)?.nombre || 'Selecciona un tipo de espacio'}
                                    <ChevronsUpDown className="ml-2 h-4 w-4 shrink-0 opacity-50" />
                                </Button>
                                </PopoverTrigger>
                                <PopoverContent>
                                    <Command>
                                        <CommandInput placeholder="Buscar..." />
                                        <CommandEmpty>No se encontraron resultados</CommandEmpty>
                                        <CommandGroup>
                                            <CommandList>
                                                {tiposespacios?.map((item) => (
                                                    <CommandItem
                                                        key={item.id}
                                                        value={item.id}
                                                        onSelect={() => {
                                                            setData('tiposespacios_id', item.id);
                                                            setOpenLocalizaciones(false);
                                                        }}
                                                    >
                                                        <Check className={cn("mr-2 h-4 w-4", data.tiposespacios_id === item.id ? "opacity-100 " : "opacity-0")} />
                                                        {item.nombre}
                                                    </CommandItem>
                                                ))}
                                            </CommandList>
                                        </CommandGroup>
                                    </Command>
                                </PopoverContent>
                            </Popover>

                            <Label>Localización</Label>

                            <Popover open={openLocalizaciones} onOpenChange={setOpenLocalizaciones}>
                                <PopoverTrigger asChild><Button variant="outline" role="combobox" aria-expanded={openLocalizaciones} className="w-full max-w-[400px] justify-between">
                                    {localizaciones.find(l => l.id === data.localizacion_id)?.nombre || 'Selecciona una localización'}
                                    <ChevronsUpDown className="ml-2 h-4 w-4 shrink-0 opacity-50" />
                                </Button>
                                </PopoverTrigger>
                                <PopoverContent>
                                    <Command>
                                        <CommandInput placeholder="Buscar..." />
                                        <CommandEmpty>No se encontraron resultados</CommandEmpty>
                                        <CommandGroup>
                                            <CommandList>
                                                {localizaciones.map((item) => (
                                                    <CommandItem
                                                        key={item.id}
                                                        value={item.id}
                                                        onSelect={() => {
                                                            setData('localizacion_id', item.id);
                                                            setOpenLocalizaciones(false);
                                                        }}
                                                    >
                                                        <Check className={cn("mr-2 h-4 w-4", data.localizacion_id === item.id ? "opacity-100 " : "opacity-0")} />
                                                        {item.nombre}
                                                    </CommandItem>
                                                ))}
                                            </CommandList>
                                        </CommandGroup>
                                    </Command>
                                </PopoverContent>
                            </Popover>
                            <Label>Capacidad</Label>
                            <Input className='w-20' type="number" value={data.capacidad} onChange={e => setData('capacidad', e.target.value)} />
                            <Button type="submit" disabled={processing}>
                                {isEdit ? 'Guardar cambios' : 'Crear'}
                            </Button>
                        </div>
                    </form>
                </div>
                <hr className="my-4" />
                {isEdit && (
                    <div>
                        <div className="flex justify-between items-center">
                            <h2 className="font-semibold text-xl text-gray-800 leading-tight">Equipamientos</h2>
                            <Dialog>
                                <DialogTrigger>
                                    <Button variant='blue'>
                                        Agregar equipamiento
                                    </Button>
                                </DialogTrigger>
                                <DialogContent>
                                    <DialogHeader>
                                        <DialogTitle>Agregar nuevo equipamiento</DialogTitle>
                                        <DialogDescription>
                                            <form className='flex flex-col gap-4' onSubmit={submitNuevoEquipamiento}>
                                                <Label>Equipamiento</Label>
                                                <Popover open={openEquipamientos} onOpenChange={setOpenEquipamientos}>
                                                    <PopoverTrigger asChild><Button variant="outline" role="combobox" aria-expanded={openLocalizaciones} className="w-full max-w-[400px] justify-between">
                                                        {equipamientos.find(l => l.id === nuevoEquipamiento.equipamiento_id)?.nombre || 'Selecciona un equipamiento'}
                                                        <ChevronsUpDown className="ml-2 h-4 w-4 shrink-0 opacity-50" />
                                                    </Button>
                                                    </PopoverTrigger>
                                                    <PopoverContent>
                                                        <Command>
                                                            <CommandInput placeholder="Buscar..." />
                                                            <CommandEmpty>No se encontraron resultados</CommandEmpty>
                                                            <CommandGroup>
                                                                <CommandList>
                                                                    {equipamientos.map((item) => (
                                                                        <CommandItem
                                                                            key={item.id}
                                                                            value={item.id}
                                                                            onSelect={() => {
                                                                                setNuevoEquipamiento('equipamiento_id', item.id);
                                                                                setOpenLocalizaciones(false);
                                                                            }}
                                                                        >
                                                                            <Check className={cn("mr-2 h-4 w-4", nuevoEquipamiento.equipamiento_id === item.id ? "opacity-100 " : "opacity-0")} />
                                                                            {item.nombre}
                                                                        </CommandItem>
                                                                    ))}
                                                                </CommandList>
                                                            </CommandGroup>
                                                        </Command>
                                                    </PopoverContent>
                                                </Popover>
                                                <Label>Cantidad</Label>
                                                <Input type="number" value={nuevoEquipamiento.cantidad} onChange={e => setNuevoEquipamiento('cantidad', e.target.value)} />
                                                <Button type="submit" disabled={processingNuevoEquipamiento}>
                                                    Guardar cambios
                                                </Button>
                                            </form>
                                        </DialogDescription>
                                    </DialogHeader>
                                </DialogContent>
                            </Dialog>

                        </div>
                        <DataTable columns={columns} data={espacio.equipamientos} />
                    </div>
                )
                }
            </div>

            {isEquipamientoEspacioEdit && (
                <Dialog open={isEquipamientoEspacioEdit} onOpenChange={() => { router.get(route('espacios.edit', espacio.id)) }}>
                    <DialogTrigger asChild>
                        <Button variant='ghost'>
                            <Check size={24} />
                        </Button>
                    </DialogTrigger>
                    <DialogContent>
                        <DialogHeader>
                            <DialogTitle>Editar equipamiento</DialogTitle>
                        </DialogHeader>
                        <DialogDescription>
                            <p className="text-sm text-gray-600"> {EquipamientoEspacio.equipamiento.nombre} </p>
                            <form onSubmit={submitEquipamiento}>
                                <Label>Cantidad</Label>
                                <Input type="number" value={dataEquipamiento.cantidad} onChange={e => setDataEquipamiento('cantidad', e.target.value)} />
                                <Button type="submit" className='mt-2' disabled={processingEquipamiento}>
                                    Guardar cambios
                                </Button>
                            </form>
                        </DialogDescription>
                    </DialogContent>
                </Dialog>
            )
            }

        </ AuthenticatedLayout >
    );
}