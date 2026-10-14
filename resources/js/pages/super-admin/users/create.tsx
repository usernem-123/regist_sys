
import { Head, Link, useForm } from '@inertiajs/react';
import type { FormEvent } from 'react';

type Role = {
    id: number;
    name: string;
};

type Props = {
    roles: Role[];
};

export default function CreateUser({ roles }: Props) {
    const form = useForm({
        name: '',
        email: '',
        password: '',
        password_confirmation: '',
        role: roles[0]?.name ?? '',
        is_active: true,
    });

    function submit(event: FormEvent<HTMLFormElement>) {
        event.preventDefault();
        form.post('/superadmin/users');
    }

    return (
        <>
            <Head title="Create User" />

            <main className="flex flex-1 flex-col gap-6 p-4">
                <header>
                    <h1 className="text-2xl font-semibold">Create User</h1>
                    <p className="mt-1 text-sm text-muted-foreground">
                        Create an account and assign its system role.
                    </p>
                </header>

                <form
                    onSubmit={submit}
                    className="max-w-2xl space-y-5 rounded-xl border border-sidebar-border/70 bg-background p-5"
                >
                    <div>
                        <label htmlFor="name" className="mb-1 block text-sm font-medium">
                            Full name
                        </label>
                        <input
                            id="name"
                            value={form.data.name}
                            onChange={(event) => form.setData('name', event.target.value)}
                            required
                            maxLength={255}
                            className="w-full rounded-lg border border-input bg-background px-3 py-2"
                        />
                        {form.errors.name && (
                            <p className="mt-1 text-sm text-red-600">{form.errors.name}</p>
                        )}
                    </div>

                    <div>
                        <label htmlFor="email" className="mb-1 block text-sm font-medium">
                            Email address
                        </label>
                        <input
                            id="email"
                            type="email"
                            value={form.data.email}
                            onChange={(event) => form.setData('email', event.target.value)}
                            required
                            maxLength={255}
                            className="w-full rounded-lg border border-input bg-background px-3 py-2"
                        />
                        {form.errors.email && (
                            <p className="mt-1 text-sm text-red-600">{form.errors.email}</p>
                        )}
                    </div>

                    <div>
                        <label htmlFor="password" className="mb-1 block text-sm font-medium">
                            Temporary password
                        </label>
                        <input
                            id="password"
                            type="password"
                            autoComplete="new-password"
                            value={form.data.password}
                            onChange={(event) => form.setData('password', event.target.value)}
                            required
                            minLength={8}
                            className="w-full rounded-lg border border-input bg-background px-3 py-2"
                        />
                        <p className="mt-1 text-xs text-muted-foreground">
                            Use at least 8 characters.
                        </p>
                        {form.errors.password && (
                            <p className="mt-1 text-sm text-red-600">{form.errors.password}</p>
                        )}
                    </div>

                    
                    <div>
                        <label
                            htmlFor="password_confirmation"
                            className="mb-1 block text-sm font-medium"
                        >
                            Confirm password
                        </label>

                        <input
                            id="password_confirmation"
                            type="password"
                            autoComplete="new-password"
                            value={form.data.password_confirmation}
                            onChange={(event) =>
                                form.setData('password_confirmation', event.target.value)
                            }
                            required
                            className="w-full rounded-lg border border-input bg-background px-3 py-2"
                        />

                        {form.errors.password_confirmation && (
                            <p className="mt-1 text-sm text-red-600">
                                {form.errors.password_confirmation}
                            </p>
                        )}
                    </div>
                
                    <div>
                        <label htmlFor="role" className="mb-1 block text-sm font-medium">
                            Role
                        </label>
                        <select
                            id="role"
                            value={form.data.role}
                            onChange={(event) => form.setData('role', event.target.value)}
                            required
                            className="w-full rounded-lg border border-input bg-background px-3 py-2"
                        >
                            {roles.map((role) => (
                                <option key={role.id} value={role.name}>
                                    {role.name}
                                </option>
                            ))}
                        </select>
                        {form.errors.role && (
                            <p className="mt-1 text-sm text-red-600">{form.errors.role}</p>
                        )}
                    </div>

                    <label className="flex items-center gap-2 text-sm">
                        <input
                            type="checkbox"
                            checked={form.data.is_active}
                            onChange={(event) => form.setData('is_active', event.target.checked)}
                            className="size-4"
                        />
                        Account is active
                    </label>
                    {form.errors.is_active && (
                        <p className="text-sm text-red-600">{form.errors.is_active}</p>
                    )}

                    <div className="flex flex-wrap gap-3">
                        <button
                            type="submit"
                            disabled={form.processing || roles.length === 0}
                            className="rounded-lg bg-primary px-4 py-2 text-sm font-medium text-primary-foreground disabled:opacity-50"
                        >
                            {form.processing ? 'Creating...' : 'Create Account'}
                        </button>

                        <Link
                            href="/superadmin/users"
                            className="rounded-lg border border-input px-4 py-2 text-sm"
                        >
                            Cancel
                        </Link>
                    </div>

                    {roles.length === 0 && (
                        <p className="text-sm text-red-600">
                            No assignable roles are available. Check the role seeder.
                        </p>
                    )}
                </form>
            </main>
        </>
    );
}

CreateUser.layout = {
    breadcrumbs: [
        { title: 'Super Admin', href: '/superadmin' },
        { title: 'Users', href: '/superadmin/users' },
        { title: 'Create', href: '/superadmin/users/create' },
    ],
};
