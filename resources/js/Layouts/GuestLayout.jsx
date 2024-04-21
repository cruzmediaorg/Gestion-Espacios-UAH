import ApplicationLogoBlue from '@/Components/ApplicationLogoBlue';
import { Link } from '@inertiajs/react';

export default function Guest({ children }) {
    return (
        <div className="min-h-screen flex  sm:justify-center items-center  bg-gray-100">
            <div className='w-full flex flex-col justify-center items-center'>
                <Link href="/">
                    <ApplicationLogoBlue className="w-full h-20 fill-current text-gray-500" />
                </Link>
                <h2 className="text-2xl  text-uahBlue my-4">Gestión de Espacios</h2>

                <div className="w-full px-6">
                    {children}
                </div>

            </div>

            <div className="w-full h-[100vh] px-6  bg-white overflow-hidden"
                style={{ background: 'url(/images/bg-aulas.jpeg) ', backgroundSize: 'cover' }}>

            </div>
        </div>
    );
}
