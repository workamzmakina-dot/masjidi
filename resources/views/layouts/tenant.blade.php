<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $currentMosque->name }} Admin - Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100 font-sans antialiased">
    <div class="min-h-screen flex">
        <aside class="w-64 bg-slate-900 text-white">
            <div class="p-6">
                <h2 class="font-bold text-lg">{{ $currentMosque->name }}</h2>
                <p class="text-[10px] uppercase text-slate-400">Tenant Admin Panel</p>
            </div>
            <nav class="mt-4 px-4 space-y-1">
                <a href="{{ route('tenant.dashboard', $currentMosque->slug) }}" class="block px-4 py-2 rounded hover:bg-slate-800">Dashboard</a>
                <a href="#" class="block px-4 py-2 rounded hover:bg-slate-800">Finance</a>
                <a href="#" class="block px-4 py-2 rounded hover:bg-slate-800">Content</a>
                <a href="#" class="block px-4 py-2 rounded hover:bg-slate-800">WhatsApp</a>
            </nav>
        </aside>
        <div class="flex-1 flex flex-col">
            <header class="h-16 bg-white border-b px-8 flex items-center justify-between">
                <span class="text-slate-500 font-medium">Welcome, {{ auth('tenant')->user()->name }}</span>
                <form action="#" method="POST">@csrf <button class="text-xs text-red-500 font-bold uppercase">Logout</button></form>
            </header>
            <main class="p-8">
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>