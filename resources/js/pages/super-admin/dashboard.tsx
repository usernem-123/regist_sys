
import { Head, Link } from '@inertiajs/react';

type Stats = {
    users: number;
    activeUsers: number;
    students: number;
    programs: number;
    academicRecords: number;
    documentRequests: number;
    roles: number;
    permissions: number;
};

type RoleCount = {
    name: string;
    users_count: number;
};

type RecentUser = {
    id: number;
    name: string;
    email: string;
    created_at: string;
};

type Props = {
    stats: Stats;
    roleCounts: RoleCount[];
    recentUsers: RecentUser[];
};

export default function SuperAdminDashboard({
    stats,
    roleCounts,
    recentUsers,
}: Props) {
    const cards = [
        { label: 'Total Users', value: stats.users },
        { label: 'Active Users', value: stats.activeUsers },
        { label: 'Students', value: stats.students },
        { label: 'Programs', value: stats.programs },
        { label: 'Academic Records', value: stats.academicRecords },
        { label: 'Document Requests', value: stats.documentRequests },
    ];

    return (
        <>
            <Head title="Super Admin Dashboard" />

            <div className="flex flex-1 flex-col gap-6 overflow-x-auto p-4">
                <div>
                    <h1 className="text-2xl font-semibold">
                        Super Admin Dashboard
                    </h1>
                    <p className="mt-1 text-sm text-muted-foreground">
                        Manage system access and monitor your registrar
                        system.
                    </p>
                </div>

                <div className="grid gap-4 sm:grid-cols-2 xl:grid-cols-3">
                    {cards.map((card) => (
                        <div
                            key={card.label}
                            className="rounded-xl border border-sidebar-border/70 bg-background p-5"
                        >
                            <p className="text-sm text-muted-foreground">
                                {card.label}
                            </p>
                            <p className="mt-2 text-3xl font-semibold">
                                {card.value}
                            </p>
                        </div>
                    ))}
                </div>

                <section className="grid gap-4 sm:grid-cols-2">
                    <Link
                        href="/superadmin/users"
                        className="rounded-xl border border-sidebar-border/70 bg-background p-5 transition hover:bg-muted/40"
                    >
                        <h2 className="font-semibold">User Management</h2>
                        <p className="mt-1 text-sm text-muted-foreground">
                            Create accounts, update user details, and manage active status.
                        </p>
                    </Link>

                    <Link
                        href="/superadmin/permissions"
                        className="rounded-xl border border-sidebar-border/70 bg-background p-5 transition hover:bg-muted/40"
                    >
                        <h2 className="font-semibold">Role Access</h2>
                        <p className="mt-1 text-sm text-muted-foreground">
                            Control which features each role can access.
                        </p>
                    </Link>
                </section>

                <section className="rounded-xl border border-sidebar-border/70 bg-background p-5">
                    <h2 className="text-lg font-semibold">
                        Users by Role
                    </h2>

                    <div className="mt-4 divide-y">
                        {roleCounts.map((role) => (
                            <div
                                key={role.name}
                                className="flex items-center justify-between gap-4 py-3"
                            >
                                <span>{role.name}</span>
                                <span className="font-semibold">
                                    {role.users_count}
                                </span>
                            </div>
                        ))}
                    </div>
                </section>

                <section className="rounded-xl border border-sidebar-border/70 bg-background p-5">
                    <h2 className="text-lg font-semibold">
                        Recently Registered Users
                    </h2>

                    <div className="mt-4 overflow-x-auto">
                        <table className="w-full text-left text-sm">
                            <thead>
                                <tr className="border-b text-muted-foreground">
                                    <th className="py-3 pr-4 font-medium">
                                        Name
                                    </th>
                                    <th className="py-3 pr-4 font-medium">
                                        Email
                                    </th>
                                    <th className="py-3 font-medium">
                                        Registered
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                {recentUsers.map((user) => (
                                    <tr
                                        key={user.id}
                                        className="border-b last:border-0"
                                    >
                                        <td className="py-3 pr-4">
                                            {user.name}
                                        </td>
                                        <td className="py-3 pr-4">
                                            {user.email}
                                        </td>
                                        <td className="py-3">
                                            {new Date(
                                                user.created_at,
                                            ).toLocaleDateString()}
                                        </td>
                                    </tr>
                                ))}

                                {recentUsers.length === 0 && (
                                    <tr>
                                        <td
                                            colSpan={3}
                                            className="py-6 text-center text-muted-foreground"
                                        >
                                            No users registered yet.
                                        </td>
                                    </tr>
                                )}
                            </tbody>
                        </table>
                    </div>
                </section>
            </div>
        </>
    );
}

SuperAdminDashboard.layout = {
    breadcrumbs: [
        {
            title: 'Super Admin',
            href: '/superadmin',
        },
    ],
};
