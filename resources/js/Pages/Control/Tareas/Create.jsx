import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Input } from '@/Components/ui/input';
import { Button } from '@/Components/ui/button';
import { useForm } from '@inertiajs/react'
import { Label } from '@/Components/ui/label';
export default function Edit({ auth, tipoTarea }) {

    const { data, setData, put, post, processing, errors } = useForm({
        parametros: tipoTarea.parametros_requeridos.reduce((acc, item) => ({ ...acc, [item.key]: '' }), {}),
    });


    function submit(e) {
        e.preventDefault()

        post(route('tareas.ejecutar', tipoTarea.id))

    }

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={<div className='flex flex-col'>
                <h2 className="font-semibold text-xl text-gray-800 leading-tight">Ejecutar tarea de {tipoTarea.nombre}</h2>
                <p className="text-sm text-gray-500"> {tipoTarea.descripcion}</p>
            </div>}
        >
            <div className="h-full overflow-y-scroll">
                <div className="py-4">
                    <form onSubmit={submit}>
                        <div className="flex flex-col gap-2 w-full">
                            <Label>Parámetros</Label>
                            {tipoTarea.parametros_requeridos.map((parametro, index) => (
                                <div key={index}>
                                    <Label>{parametro.label}</Label>
                                    <p className="text-sm text-gray-500">{parametro.descripcion}</p>
                                    <Input
                                        required
                                        type="text"
                                        value={data.parametros[parametro.key]}
                                        onChange={e => setData('parametros', { ...data.parametros, [parametro.key]: e.target.value })}
                                    />
                                </div>
                            ))}

                            <Button type="submit" disabled={processing}>
                                Ejecutar tarea
                            </Button>
                        </div>
                    </form>
                </div>
            </div>
        </ AuthenticatedLayout >
    );
}