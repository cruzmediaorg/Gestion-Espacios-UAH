import { useState } from 'react';
import ApplicationLogo from '@/Components/ApplicationLogo';
import Dropdown from '@/Components/Dropdown';
import NavLink from '@/Components/NavLink';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink';
import { Link } from '@inertiajs/react';

export default function Authenticated({ user, header, children }) {

    const currentRoute = window.location.pathname;



    return (
        <div className="min-h-screen flex bg-gray-100">
            <div className='flex h-screen w-60 bg-uahBlue items-center flex-col'>
                <ApplicationLogo className='h-14 my-8' />
                <nav className='flex flex-col justify-start w-full px-4'>
                    <NavLink href='/dashboard'
                        active={
                            currentRoute.includes('dashboard')
                        }
                    >Dashboard</NavLink>
                    <NavLink href='/profile'
                        active={
                            currentRoute.includes('profile')
                        }
                    >Profile</NavLink>
                    <NavLink href='/users' active={
                        currentRoute.includes('users')
                    }>Users</NavLink>
                </nav>
            </div>
            <main>{children}</main>
        </div>
    );
}
