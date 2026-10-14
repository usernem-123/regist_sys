
import { Head, router } from '@inertiajs/react';

type Permission = {
    id: number;
    name: string;
};

type Role = {
    id: number;
    name: string;
    users_count: number;
    permissions: Permission[];
};

type Props = {
    roles: Role[];
    permissions: Permission[];
};

export default function RolePermissions({
    roles,
    permissions,
}: Props) {
    function toggle(role: Role, permission: Permission) {
        router.patch(
            `/superadmin/roles/${role.id}/permissions/${permission.id}`,
            {},
            { preserveScroll: true },
        );
    }

    function hasPermission(role: Role, permission: Permission) {
        return role.permissions.some(
            (assigned) => assigned.id === permission.id,
        );
    }

    return (
        <>
            <Head title="Role Access" />

            <main className="flex flex-1 flex-col gap-6 p-4">
                <header>
                    <h1 className="text-2xl font-semibold">
                        Role Access
                    </h1>
                    <p className="mt-1 text-sm text-muted-foreground">
                        Choose which features each role can access.
                    </p>
                </header>

                <div className="overflow-x-auto rounded-xl border border-sidebar-border/70 bg-background">
                    <table className="w-full text-left text-sm">
                        <thead>
                            <tr className="border-b bg-muted/40">
                                <th className="min-w-48 p-4">Role</th>
                                <th className="p-4">Users</th>
                                {permissions.map((permission) => (
                                    <th
                                        key={permission.id}
                                        className="min-w-40 p-4"
                                    >
                                        {permission.name}
                                    </th>
                                ))}
                            </tr>
                        </thead>

                        <tbody>
                            {roles.map((role) => {
                                const isProtected =
                                    role.name === 'Super Admin';

                                return (
                                    <tr
                                        key={role.id}
                                        className="border-b last:border-0"
                                    >
                                        <td className="p-4 font-medium">
                                            {role.name}
                                            {isProtected && (
                                                <p className="mt-1 text-xs text-muted-foreground">
                                                    Protected role
                                                </p>
                                            )}
                                        </td>

                                        <td className="p-4">
                                            {role.users_count}
                                        </td>

                                        {permissions.map((permission) => {
                                            const enabled = hasPermission(
                                                role,
                                                permission,
                                            );

                                            return (
                                                <td
                                                    key={permission.id}
                                                    className="p-4"
                                                >
                                                    <button
                                                        type="button"
                                                        role="switch"
                                                        aria-checked={enabled}
                                                        aria-label={`${permission.name} for ${role.name}`}
                                                        disabled={isProtected}
                                                        onClick={() =>
                                                            toggle(
                                                                role,
                                                                permission,
                                                            )
                                                        }
                                                        className={`relative h-6 w-11 rounded-full transition ${
                                                            enabled
                                                                ? 'bg-primary'
                                                                : 'bg-muted'
                                                        } disabled:cursor-not-allowed disabled:opacity-50`}
                                                    >
                                                        <span
                                                            className={`absolute top-1 size-4 rounded-full bg-white transition ${
                                                                enabled
                                                                    ? 'left-6'
                                                                    : 'left-1'
                                                            }`}
                                                        />
                                                    </button>
                                                </td>
                                            );
                                        })}
                                    </tr>
                                );
                            })}

                            {roles.length === 0 && (
                                <tr>
                                    <td
                                        colSpan={permissions.length + 2}
                                        className="p-6 text-center text-muted-foreground"
                                    >
                                        No roles found.
                                    </td>
                                </tr>
                            )}
                        </tbody>
                    </table>
                </div>

                <p className="text-sm text-muted-foreground">
                    Changes are saved immediately. Super Admin access is
                    protected from changes on this page.
                </p>
            </main>
        </>
    );
}

RolePermissions.layout = {
    breadcrumbs: [
        { title: 'Super Admin', href: '/superadmin' },
        { title: 'Role Access', href: '/superadmin/permissions' },
    ],
};
