import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Space } from 'lucide-react';
import { Link } from '@inertiajs/react';

export default function Dashboard({ auth }) {

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">Gestión</h2>}
        >
            <div className="bg-white  my-4 gap-4 grid grid-cols-1 md:grid-cols-3 p-5">
                <div className="p-4 border h-48 flex flex-col justify-center items-center hover:bg-gray-50">
                    <Space size="48" />
                    <h2 className="text-2xl font-semibold">Usuarios</h2>
                    <p className="text-gray-600">
                        Administración de usuarios
                    </p>
                    <Link href="/control/usuarios" className="mt-4 bg-uahBlue text-white px-4 py-2 ">Gestionar</Link>
                </div>
                <div className="p-4 border h-48 flex flex-col justify-center items-center hover:bg-gray-50">
                    <Space size="48" />
                    <h2 className="text-2xl font-semibold">Roles</h2>
                    <p className="text-gray-600">
                        Administración de roles
                    </p>
                    <Link href="/control/roles" className="mt-4 bg-uahBlue text-white px-4 py-2 ">Gestionar</Link>
                </div>
                <div className="p-4 border h-48 flex flex-col justify-center items-center hover:bg-gray-50">
                    <Space size="48" />
                    <h2 className="text-2xl font-semibold">Espacios</h2>
                    <p className="text-gray-600">
                        Administración de espacios y equipamientos
                    </p>
                    <Link href="/control/espacios" className="mt-4 bg-uahBlue text-white px-4 py-2 ">Gestionar</Link>
                </div>
                <div className="p-4 border h-48 flex flex-col justify-center items-center hover:bg-gray-50">
                    <Space size="48" />
                    <h2 className="text-2xl font-semibold">Grados</h2>
                    <p className="text-gray-600 text-center">
                        Administración de grados, masters y doctorados
                    </p>
                    <Link href="/control/grados" className="mt-4 bg-uahBlue text-white px-4 py-2 ">Gestionar</Link>
                </div>
                <div className="p-4 border h-48 flex flex-col justify-center items-center hover:bg-gray-50">
                    <Space size="48" />
                    <h2 className="text-2xl font-semibold">Cursos y horarios</h2>
                    <p className="text-gray-600">
                        Administración de cursos y horarios
                    </p>
                    <Link href="/users" className="mt-4 bg-uahBlue text-white px-4 py-2 ">Gestionar</Link>
                </div>
                <div className="p-4 border h-48 flex flex-col justify-center items-center hover:bg-gray-50">
                    <Space size="48" />
                    <h2 className="text-2xl font-semibold">Tareas</h2>
                    <p className="text-gray-600">
                        Gestión de tareas automatizadas
                    </p>
                    <Link href="/control/tareas" className="mt-4 bg-uahBlue text-white px-4 py-2 ">Gestionar</Link>
                </div>
            </div>
        </AuthenticatedLayout >
    );
}