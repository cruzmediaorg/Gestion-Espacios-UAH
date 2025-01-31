import ApplicationLogo from '@/Components/ApplicationLogo';
import NavLink from '@/Components/NavLink';
import { Link, usePage } from '@inertiajs/react';
import { HomeIcon, Calendar, Check, Table, Bell } from 'lucide-react';

import { Toaster } from "@/Components/ui/toaster"
import { useToast } from "@/Components/ui/use-toast"
import { useEffect, useState } from 'react';
import ReactIf from "@/lib/ReactIf.jsx";


export default function Authenticated({ user, header, children }) {

    const currentRoute = window.location.pathname;

    const page = usePage();
    const [unreadNotifications, setUnreadNotifications] = useState(page.props.unreadNotifications?.length);
    const { toast } = useToast()

    useEffect(() => {
        Echo.channel(`users.${user.id}`)
            .listen('NotificationCreatedEvent', (e) => {

                setUnreadNotifications(unreadNotifications + 1)

                toast({
                    title: e.message,
                    variant: e.tipo
                })
            }
            );
    }
        , [])


    useEffect(() => {
        if (page.props.flash.success) {
            toast({
                title: page.props.flash.success,
                variant: 'success'
            })
        }
        if (page.props.flash.error) {
            toast({
                title: page.props.flash.error,
                variant: 'error'
            })
        }

    }, [page.props.flash.error, page.props.flash.success])


    return (
        <div className="min-h-screen flex bg-gray-100">
            <div className='flex h-[100vh] w-60 bg-uahBlue items-center flex-col relative'>
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
                        Inicio
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

                    <NavLink href='/notificaciones' active={
                        currentRoute.includes('notificaciones')
                    }>
                        <Bell size='24' />
                        Notificaciones   <pre>
                            <ReactIf condition={unreadNotifications > 0}>
                                <span className='bg-red-500 text-white rounded-full text-xs font-bold py-2 flex justify-center items-center px-3
                            '> {unreadNotifications}</span>
                            </ReactIf>
                        </pre></NavLink>
                </nav>

                <div className='flex flex-col items-center bg-white justify-center w-full absolute bottom-0'>
                    <div className='w-10 h-10 bg-uahBlue rounded-full mt-4'></div>
                    <p className='text-uahBlue mt-2'>{user?.name}</p>
                    <p className='text-uahBlue mt-2'>{user?.email}</p>

                    <Link href='/logout' method='post' as='button' className='bg-uahBlue  mb-4  px-4 py-2 rounded-sm text-white mt-4'>Cerrar sesión</Link>
                </div>


            </div>

            <main className="h-[100vh] overflow-y-scroll max-w-screen-xl w-full p-12">
                <Toaster />
                <header className='w-full border-b py-2'>
                    {header && header}
                </header>
                {children && <div className='mt-4'>{children}</div>}
            </main>
        </div>
    );
}
