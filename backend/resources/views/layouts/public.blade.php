<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $currentMosque->name }} - MosqueSaaS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        :root {
            --primary-color: {{ $currentMosque->settings['primary_color'] ?? '#064e3b' }};
        }
        .bg-primary { background-color: var(--primary-color); }
        .text-primary { color: var(--primary-color); }
    </style>
</head>
<body class="bg-gray-50">
    <header class="bg-white shadow-sm border-b">
        <div class="max-w-7xl mx-auto px-4 h-16 flex items-center justify-between">
            <h1 class="text-xl font-bold text-primary">{{ $currentMosque->name }}</h1>
            <nav class="space-x-4 text-sm font-medium">
                <a href="{{ route('public.home', $currentMosque->slug) }}">Home</a>
                <a href="#">Prayer Times</a>
                <a href="#">Donate</a>
            </nav>
        </div>
    </header>
    <main class="max-w-7xl mx-auto py-10 px-4">
        @yield('content')
    </main>
</body>
</html>