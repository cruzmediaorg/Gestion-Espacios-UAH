import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Input } from '@/Components/ui/input';
import { Button } from '@/Components/ui/button';
import { useForm } from '@inertiajs/react'
import { Label } from '@/Components/ui/label';
export default function Edit({ auth, user, isEdit = false, roles }) {

    const { data, setData, put, post, processing, errors } = useForm({
        name: isEdit ? user.name : '',
        email: isEdit ? user.email : '',
        password: '',
        roles: isEdit ? user.roles : ['General']
    })


    function submit(e) {
        e.preventDefault()
        if (isEdit) {
            put(route('usuarios.update', user.id))
        } else {
            post(route('usuarios.store'))
        }
    }

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={<div className='flex justify-between items-center'>
                <h2 className="font-semibold text-xl text-gray-800 leading-tight"> {isEdit ? 'Editar' : 'Crear'} usuario</h2></div>}
        >
            <div className="h-full overflow-y-scroll">

                <div className="py-4">
                    <form onSubmit={submit}>
                        <div className="flex flex-col gap-2 w-full">
                            <Label>Nombre</Label>
                            <Input type="text" value={data.name} onChange={e => setData('name', e.target.value)} />
                            <Label>Correo electrónico</Label>
                            <Input type="text" value={data.email} onChange={e => setData('email', e.target.value)} />
                            {errors.email && <div>{errors.email}</div>}
                            <Label>Contraseña</Label>
                            <Input type="password" value={data.password} onChange={e => setData('password', e.target.value)} />
                            {errors.password && <div>{errors.password}</div>}
                            <Label>Roles</Label>
                            <div className="flex flex-col gap-2">
                                {roles.map((role) => (
                                    <div key={role.id}>
                                        <input type="checkbox" id={role.name} name="roles" value={role.name} onChange={e => {
                                            if (e.target.checked) {
                                                setData('roles', [...data.roles, e.target.value])
                                            } else {
                                                setData('roles', data.roles.filter((r) => r !== e.target.value))
                                            }
                                        }}
                                            checked={data.roles.includes(role.name)}

                                        />
                                        <label className={
                                            data.roles.includes(role.name) ? 'text-uahBlue ml-2 font-bold' : ' ml-2'
                                        } htmlFor={role.name}>{role.name}</label>
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