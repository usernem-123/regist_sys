import { Head } from '@inertiajs/react';
import { dashboard } from '@/routes';

export default function Dashboard() {
    return (
        <>
            <Head title="Registrar System" />
            <div className="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
                <div className="flex items-center justify-between">
                    <h1 className="text-2xl font-semibold">Registrar System</h1>
                </div>
                <div className="flex-1 rounded-xl border border-sidebar-border/70 bg-background p-6">
                    <p className="text-muted-foreground">
                        Welcome to the Registrar System. Start building your
                        features here.
                    </p>
                </div>
            </div>
        </>
    );
}

Dashboard.layout = {
    breadcrumbs: [
        {
            title: 'Dashboard',
            href: dashboard(),
        },
    ],
};
