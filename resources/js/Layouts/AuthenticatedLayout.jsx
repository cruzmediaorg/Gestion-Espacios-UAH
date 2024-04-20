import ApplicationLogo from '@/Components/ApplicationLogo';
import NavLink from '@/Components/NavLink';
import { Link } from '@inertiajs/react';
import { HomeIcon, Calendar, Check, Table } from 'lucide-react';

export default function Authenticated({ user, header, children }) {

    const currentRoute = window.location.pathname;

    return (
        <div className="min-h-screen flex bg-gray-100">
            <div className='flex h-[100vh] w-60 bg-uahBlue items-center flex-col'>
                <Link href='/'>
                    <ApplicationLogo className='h-14 mt-8 mb-12' />
                </Link>
                <nav className='flex flex-col justify-start w-full'>
                    <NavLink href='/'
                        active={
                            currentRoute.includes('/dashboard')
                        }
                    >
                        <HomeIcon size='24' />
                        Panel
                    </NavLink>
                    <NavLink href='/calendario'
                        active={
                            currentRoute.includes('calendario')
                        }
                    >
                        <Calendar size='24' />
                        Calendario</NavLink>
                    <NavLink href='/reservas' active={
                        currentRoute.includes('reservas')
                    }>
                        <Check size='24' />
                        Reservas</NavLink>
                    <NavLink href='/control' active={
                        currentRoute.includes('control')
                    }>
                        <Table size='24' />
                        Gestión</NavLink>
                </nav>
            </div>

            <main className="h-[100vh] overflow-y-scroll max-w-screen-xl w-full p-12">
                <header className='w-full border-b py-2'>
                    {header}
                </header>
                {children}
            </main>
        </div>
    );
}
