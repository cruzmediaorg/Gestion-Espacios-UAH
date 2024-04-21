import { useEffect, useState } from 'react';
import Checkbox from '@/Components/Checkbox';
import GuestLayout from '@/Layouts/GuestLayout';
import InputError from '@/Components/InputError';
import InputLabel from '@/Components/InputLabel';
import PrimaryButton from '@/Components/PrimaryButton';
import TextInput from '@/Components/TextInput';
import { Head, Link, useForm } from '@inertiajs/react';
import { Building, BuildingIcon } from 'lucide-react';

export default function Login({ status, canResetPassword }) {
    const { data, setData, post, processing, errors, reset } = useForm({
        sid: '',
        password: '',
        remember: false,
    });

    const [showSIDLogin, setShowSIDLogin] = useState(false);

    useEffect(() => {
        return () => {
            reset('password');
        };
    }, []);

    const submit = (e) => {
        e.preventDefault();

        post(route('login'));
    };

    return (
        <GuestLayout>
            <Head title="Log in" />

            {status && <div className="mb-4 font-medium text-sm text-green-600">{status}</div>}

            {!showSIDLogin && (
                <div className="flex items-center justify-center my-4">
                    <div className="space-y-4 w-96">
                        <PrimaryButton
                            className="bg-[#1da1f2] rounded-sm py-4 w-full justify-center"
                            onClick={() => window.location = route('login.microsoft')}
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"
                                className="w-4 h-4 inline-block mr-2" fill="currentColor"
                            ><path d="M0 32h214.6v214.6H0V32zm233.4 0H448v214.6H233.4V32zM0 265.4h214.6V480H0V265.4zm233.4 0H448V480H233.4V265.4z" /></svg>Continuar con Microsoft O365
                        </PrimaryButton>
                        <PrimaryButton
                            className="bg-uahBlue hover:bg-uahBlue/90 py-4 rounded-sm w-full justify-center"
                            onClick={() => setShowSIDLogin(true)}
                        >

                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"
                                className="w-4 h-4 inline-block mr-2" fill="currentColor"
                            ><path d="M243.4 2.6l-224 96c-14 6-21.8 21-18.7 35.8S16.8 160 32 160v8c0 13.3 10.7 24 24 24H456c13.3 0 24-10.7 24-24v-8c15.2 0 28.3-10.7 31.3-25.6s-4.8-29.9-18.7-35.8l-224-96c-8-3.4-17.2-3.4-25.2 0zM128 224H64V420.3c-.6 .3-1.2 .7-1.8 1.1l-48 32c-11.7 7.8-17 22.4-12.9 35.9S17.9 512 32 512H480c14.1 0 26.5-9.2 30.6-22.7s-1.1-28.1-12.9-35.9l-48-32c-.6-.4-1.2-.7-1.8-1.1V224H384V416H344V224H280V416H232V224H168V416H128V224zM256 64a32 32 0 1 1 0 64 32 32 0 1 1 0-64z" /></svg>
                            Continuar con SID
                        </PrimaryButton>

                    </div>
                </div>
            )}
            {showSIDLogin ? (
                <form onSubmit={submit}>
                    <div className="flex items-center justify-center">
                        <div className="space-y-4 w-96">
                            <div>
                                <InputLabel htmlFor="sid" value="Usuario" />
                                <TextInput
                                    id="sid"
                                    type="sid"
                                    name="sid"
                                    value={data.sid}
                                    className="mt-1 block w-full"
                                    autoComplete="username"
                                    isFocused={true}
                                    onChange={(e) => setData('sid', e.target.value)}
                                />
                                <InputError message={errors.sid} className="mt-2" />
                            </div>
                            <div className="mt-4">
                                <InputLabel htmlFor="password" value="Contraseña" />
                                <TextInput
                                    id="password"
                                    type="password"
                                    name="password"
                                    value={data.password}
                                    className="mt-1 block w-full"
                                    autoComplete="current-password"
                                    onChange={(e) => setData('password', e.target.value)}
                                />
                                <InputError message={errors.password} className="mt-2" />
                            </div>
                            <div className="block mt-4">
                                <label className="flex items-center">
                                    <Checkbox
                                        name="remember"
                                        checked={data.remember}
                                        onChange={(e) => setData('remember', e.target.checked)}
                                    />
                                    <span className="ms-2 text-sm text-gray-600">Recuérdame</span>
                                </label>
                            </div>
                            <PrimaryButton className="bg-uahBlue rounded-sm w-full justify-center" disabled={processing}>
                                Iniciar sesión
                            </PrimaryButton>
                            <div className="flex items-center justify-end mt-4">

                                {canResetPassword && (
                                    <Link
                                        href={route('password.request')}
                                        className="underline text-sm text-gray-600 hover:text-gray-900  focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                    >
                                        ¿Olvidaste tu contraseña?
                                    </Link>
                                )}

                            </div>
                        </div>
                    </div>
                </form>
            ) : (null
            )
            }

        </GuestLayout>
    );
}
