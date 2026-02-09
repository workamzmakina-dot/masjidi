
<!DOCTYPE html>
<html lang="en">
<head>
    <title>{{ $tenant->name }} Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex">
    <aside class="w-64 bg-slate-900 h-screen text-white p-6">
        <h1 class="font-bold text-xl mb-8">{{ $tenant->name }}</h1>
        <nav class="space-y-4">
            <a href="{{ route('admin.dashboard', $tenant->slug) }}" class="block">Dashboard</a>
            <a href="{{ route('admin.donations.index', $tenant->slug) }}" class="block">Donations</a>
            <a href="{{ route('admin.prayer-times.index', $tenant->slug) }}" class="block">Prayer Times</a>
        </nav>
    </aside>
    <main class="flex-1 p-10">
        @yield('content')
    </main>
</body>
</html>
