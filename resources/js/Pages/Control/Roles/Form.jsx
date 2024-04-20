import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Input } from '@/Components/ui/input';
import { Button } from '@/Components/ui/button';
import { useForm } from '@inertiajs/react'
import { Label } from '@/Components/ui/label';
export default function Edit({ auth, role, isEdit = false, permissions }) {

    const { data, setData, put, post, processing, errors } = useForm({
        name: isEdit ? role.name : '',
        permissions: isEdit ? role.permissions : []
    })


    function submit(e) {
        e.preventDefault()
        if (isEdit) {
            put(route('roles.update', role.id))
        } else {
            post(route('roles.store'))
        }
    }

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={<div className='flex justify-between items-center'>
                <h2 className="font-semibold text-xl text-gray-800 leading-tight"> {isEdit ? 'Editar' : 'Crear'} rol</h2></div>}
        >
            <div className="h-full overflow-y-scroll">
                <div className="py-4">
                    <form onSubmit={submit}>
                        <div className="flex flex-col gap-2 w-full">
                            <Label>Nombre</Label>
                            <Input type="text" value={data.name} onChange={e => setData('name', e.target.value)} />

                            <Label>Permisos</Label>
                            <div className="flex flex-col gap-2">
                                <Button type="button" variant="ghost" className='w-fit' onClick={() => {
                                    if (permissions.length === data.permissions.length) {
                                        setData('permissions', [])
                                    }
                                    else {
                                        setData('permissions', permissions.map(p => p.name))
                                    }
                                }
                                }>

                                    {permissions.length === data.permissions.length ? 'Deseleccionar todos' : 'Seleccionar todos'}
                                </Button>
                                {permissions.map(permission => (
                                    <div key={permission.name} className="flex items-center gap-2">
                                        <input
                                            type="checkbox"
                                            checked={data.permissions.includes(permission.name)}
                                            onChange={e => {
                                                if (e.target.checked) {
                                                    setData('permissions', [...data.permissions, permission.name])
                                                } else {
                                                    setData('permissions', data.permissions.filter(p => p !== permission.name))
                                                }
                                            }}
                                        />
                                        <span>{permission.name}</span>
                                    </div>
                                ))}
                            </div>

                            <Button type="submit" disabled={processing}>
                                {isEdit ? 'Guardar cambios' : 'Crear'}
                            </Button>
                        </div>
                    </form>
                </div>
            </div>
        </ AuthenticatedLayout >
    );
}