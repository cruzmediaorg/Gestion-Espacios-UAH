import { Link } from '@inertiajs/react';

export default function NavLink({ active = false, className = '', children, ...props }) {
    return (
        <Link
            {...props}
            className={
                'px-4 py-4 ' +
                (active
                    ? 'border-l-4 flex gap-2 border-black bg-white font-bold'
                    : 'text-white flex gap-2') +
                className
            }
        >
            {children}
        </Link>
    );
}
