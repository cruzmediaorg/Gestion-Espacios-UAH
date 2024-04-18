import { Link } from '@inertiajs/react';

export default function NavLink({ active = false, className = '', children, ...props }) {
    return (
        <Link
            {...props}
            className={
                'px-4 py-4 ' +
                (active
                    ? 'bg-white font-bold'
                    : 'text-white') +
                className
            }
        >
            {children}
        </Link>
    );
}
