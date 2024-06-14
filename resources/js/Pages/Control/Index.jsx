import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Space } from 'lucide-react';
import { Link } from '@inertiajs/react';
import ReactIf from "@/lib/ReactIf.jsx";


export default function Dashboard({ auth }) {

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">Gestión</h2>}
        >
            <div className="bg-white  my-4 gap-4 grid grid-cols-1 md:grid-cols-3 p-5">
                <ReactIf condition={auth.permisos.includes('Crear usuarios') || auth.permisos.includes('Editar usuarios') || auth.permisos.includes('Ver usuarios')}>
                    <div className="p-4 border h-48 flex flex-col justify-center items-center hover:bg-gray-50">
                        <Space size="48"/>
                        <h2 className="text-2xl font-semibold">Usuarios</h2>
                        <p className="text-gray-600">
                            Administración de usuarios
                        </p>
                        <Link href="/control/usuarios" className="mt-4 bg-uahBlue text-white px-4 py-2 ">Gestionar</Link>
                    </div>
                </ReactIf>
            <ReactIf condition={auth.permisos.includes('Crear roles') || auth.permisos.includes('Editar roles') || auth.permisos.includes('Ver roles')}>
                <div className="p-4 border h-48 flex flex-col justify-center items-center hover:bg-gray-50">
                    <Space size="48"/>
                    <h2 className="text-2xl font-semibold">Roles</h2>
                    <p className="text-gray-600">
                        Administración de roles
                    </p>
                    <Link href="/control/roles" className="mt-4 bg-uahBlue text-white px-4 py-2 ">Gestionar</Link>
                </div>
            </ReactIf>
             <ReactIf condition={auth.permisos.includes('Crear espacios') || auth.permisos.includes('Editar espacios') || auth.permisos.includes('Ver espacios')}>
                <div className="p-4 border h-48 flex flex-col justify-center items-center hover:bg-gray-50">
                    <Space size="48"/>
                    <h2 className="text-2xl font-semibold">Espacios</h2>
                    <p className="text-gray-600">
                        Administración de espacios y equipamientos
                    </p>
                    <Link href="/control/espacios" className="mt-4 bg-uahBlue text-white px-4 py-2 ">Gestionar</Link>
                </div>
            </ReactIf>
            <ReactIf condition={auth.permisos.includes('Crear grados') || auth.permisos.includes('Editar grados') || auth.permisos.includes('Ver grados')}>
                <div className="p-4 border h-48 flex flex-col justify-center items-center hover:bg-gray-50">
                    <Space size="48"/>
                    <h2 className="text-2xl font-semibold">Grados</h2>
                    <p className="text-gray-600 text-center">
                        Administración de grados, masters y doctorados
                    </p>
                    <Link href="/control/grados" className="mt-4 bg-uahBlue text-white px-4 py-2 ">Gestionar</Link>
                </div>
            </ReactIf>
            <ReactIf condition={auth.permisos.includes('Crear cursos') || auth.permisos.includes('Editar cursos') || auth.permisos.includes('Ver cursos')}>
                <div className="p-4 border h-48 flex flex-col justify-center items-center hover:bg-gray-50">
                    <Space size="48"/>
                    <h2 className="text-2xl font-semibold">Cursos y horarios</h2>
                    <p className="text-gray-600">
                        Administración de cursos y horarios
                    </p>
                    <Link href="/control/cursos" className="mt-4 bg-uahBlue text-white px-4 py-2 ">Gestionar</Link>
                </div>
            </ReactIf>
            <ReactIf condition={auth.permisos.includes('Gestionar tareas automatizadas')}>
                <div className="p-4 border h-48 flex flex-col justify-center items-center hover:bg-gray-50">
                    <Space size="48"/>
                    <h2 className="text-2xl font-semibold">Tareas</h2>
                    <p className="text-gray-600">
                        Gestión de tareas automatizadas
                    </p>
                    <Link href="/control/tareas" className="mt-4 bg-uahBlue text-white px-4 py-2 ">Gestionar</Link>
                </div>
            </ReactIf>
            <ReactIf condition={auth.permisos.includes('Ver logs')}>
                <div className="p-4 border h-48 flex flex-col justify-center items-center hover:bg-gray-50">
                    <Space size="48"/>
                    <h2 className="text-2xl font-semibold">Logs</h2>
                    <p className="text-gray-600">
                        Seguimiento de actividades
                    </p>
                    <Link href="/logs" className="mt-4 bg-uahBlue text-white px-4 py-2 ">Ir</Link>
                </div>
            </ReactIf>
            </div>
        </AuthenticatedLayout>
    );
}
