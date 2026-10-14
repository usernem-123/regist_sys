
import { Head, Link, router } from '@inertiajs/react';
import { useState, type FormEvent } from 'react';

type Role = {
    id: number;
    name: string;
};

type User = {
    id: number;
    name: string;
    email: string;
    is_active: boolean;
    created_at: string;
    roles: Role[];
};

type PaginationLink = {
    url: string | null;
    label: string;
    active: boolean;
};

type PaginatedUsers = {
    data: User[];
    current_page: number;
    last_page: number;
    total: number;
    links: PaginationLink[];
};

type Props = {
    users: PaginatedUsers;
    filters: {
        search: string;
    };
};

export default function UsersIndex({ users, filters }: Props) {
    const [search, setSearch] = useState(filters.search ?? '');

    function submitSearch(event: FormEvent<HTMLFormElement>) {
        event.preventDefault();

        router.get(
            '/superadmin/users',
            { search },
            { preserveState: true, replace: true },
        );
    }

    function toggleActive(user: User) {
        const action = user.is_active ? 'deactivate' : 'activate';

        if (!window.confirm(`Are you sure you want to ${action} ${user.name}?`)) {
            return;
        }

        router.patch(`/superadmin/users/${user.id}/toggle-active`, {}, {
            preserveScroll: true,
        });
    }

    return (
        <>
            <Head title="User Management" />

            <main className="flex flex-1 flex-col gap-6 overflow-x-auto p-4">
                <header className="flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
                    <div>
                        <h1 className="text-2xl font-semibold">User Management</h1>
                        <p className="mt-1 text-sm text-muted-foreground">
                            Create accounts, manage roles, and control access.
                        </p>
                    </div>

                    <Link
                        href="/superadmin/users/create"
                        className="inline-flex items-center justify-center rounded-lg bg-primary px-4 py-2 text-sm font-medium text-primary-foreground"
                    >
                        Create User
                    </Link>
                </header>

                <section className="rounded-xl border border-sidebar-border/70 bg-background p-5">
                    <form
                        onSubmit={submitSearch}
                        className="flex flex-col gap-3 sm:flex-row"
                    >
                        <input
                            type="search"
                            value={search}
                            onChange={(event) => setSearch(event.target.value)}
                            placeholder="Search name or email..."
                            className="min-w-0 flex-1 rounded-lg border border-input bg-background px-3 py-2 text-sm"
                        />

                        <button
                            type="submit"
                            className="rounded-lg bg-primary px-4 py-2 text-sm font-medium text-primary-foreground"
                        >
                            Search
                        </button>

                        <Link
                            href="/superadmin/users"
                            className="rounded-lg border border-input px-4 py-2 text-center text-sm"
                        >
                            Clear
                        </Link>
                    </form>

                    <p className="mt-4 text-sm text-muted-foreground">
                        {users.total} user(s) found
                    </p>

                    <div className="mt-3 overflow-x-auto">
                        <table className="w-full text-left text-sm">
                            <thead>
                                <tr className="border-b text-muted-foreground">
                                    <th className="py-3 pr-4 font-medium">Name</th>
                                    <th className="py-3 pr-4 font-medium">Email</th>
                                    <th className="py-3 pr-4 font-medium">Role</th>
                                    <th className="py-3 pr-4 font-medium">Status</th>
                                    <th className="py-3 font-medium">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                {users.data.map((user) => (
                                    <tr key={user.id} className="border-b last:border-0">
                                        <td className="py-3 pr-4 font-medium">
                                            {user.name}
                                        </td>
                                        <td className="py-3 pr-4">{user.email}</td>
                                        <td className="py-3 pr-4">
                                            {user.roles.map((role) => role.name).join(', ') || 'No role'}
                                        </td>
                                        <td className="py-3 pr-4">
                                            <span
                                                className={
                                                    user.is_active
                                                        ? 'rounded-full bg-green-100 px-2 py-1 text-xs font-medium text-green-800'
                                                        : 'rounded-full bg-red-100 px-2 py-1 text-xs font-medium text-red-800'
                                                }
                                            >
                                                {user.is_active ? 'Active' : 'Inactive'}
                                            </span>
                                        </td>
                                        <td className="py-3">
                                            <div className="flex flex-wrap gap-3">
                                                <Link
                                                    href={`/superadmin/users/${user.id}/edit`}
                                                    className="font-medium text-primary underline-offset-4 hover:underline"
                                                >
                                                    Edit
                                                </Link>

                                                <button
                                                    type="button"
                                                    onClick={() => toggleActive(user)}
                                                    disabled={user.id === 0}
                                                    className="font-medium underline-offset-4 hover:underline disabled:opacity-50"
                                                >
                                                    {user.is_active ? 'Deactivate' : 'Activate'}
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                ))}

                                {users.data.length === 0 && (
                                    <tr>
                                        <td
                                            colSpan={5}
                                            className="py-8 text-center text-muted-foreground"
                                        >
                                            No users found.
                                        </td>
                                    </tr>
                                )}
                            </tbody>
                        </table>
                    </div>

                    <nav
                        aria-label="User pagination"
                        className="mt-5 flex flex-wrap items-center gap-2"
                    >
                        {users.links.map((link, index) => (
                            <button
                                key={`${index}-${link.label}`}
                                type="button"
                                disabled={!link.url}
                                onClick={() => {
                                    if (link.url) {
                                        router.get(link.url, {}, {
                                            preserveState: true,
                                            preserveScroll: true,
                                        });
                                    }
                                }}
                                className={`rounded-md border px-3 py-1.5 text-sm ${
                                    link.active
                                        ? 'border-primary bg-primary text-primary-foreground'
                                        : 'border-input'
                                } disabled:cursor-not-allowed disabled:opacity-40`}
                                dangerouslySetInnerHTML={{ __html: link.label }}
                            />
                        ))}
                    </nav>
                </section>
            </main>
        </>
    );
}

UsersIndex.layout = {
    breadcrumbs: [
        { title: 'Super Admin', href: '/superadmin' },
        { title: 'Users', href: '/superadmin/users' },
    ],
};
