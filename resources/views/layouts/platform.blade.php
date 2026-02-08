<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MosqueSaaS - Platform Control</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Arabic:wght@400;700;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Noto Sans Arabic', sans-serif; }
    </style>
</head>
<body class="bg-indigo-50/30 flex min-h-screen text-slate-800">
    <aside class="w-72 bg-slate-900 text-slate-300 flex-shrink-0 flex flex-col">
        <div class="p-8 border-b border-slate-800">
            <h1 class="text-2xl font-black text-white tracking-tight">MosqueSaaS</h1>
            <p class="text-[10px] uppercase text-indigo-400 font-bold tracking-widest mt-1">Platform Control</p>
        </div>
        <nav class="flex-1 p-6 space-y-1">
            <a href="{{ route('platform.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-slate-800 transition-all {{ request()->routeIs('platform.dashboard') ? 'bg-indigo-600 text-white shadow-lg' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                <span class="font-bold text-sm">لوحة التحكم</span>
            </a>
            <a href="{{ route('platform.mosques.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-slate-800 transition-all {{ request()->routeIs('platform.mosques.*') ? 'bg-indigo-600 text-white shadow-lg' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                <span class="font-bold text-sm">المساجد (المستأجرين)</span>
            </a>
            @if(auth()->user()->isSuperAdmin())
            <a href="{{ route('platform.plans.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-slate-800 transition-all {{ request()->routeIs('platform.plans.*') ? 'bg-indigo-600 text-white shadow-lg' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path></svg>
                <span class="font-bold text-sm">باقات الاشتراك</span>
            </a>
            <a href="{{ route('platform.resellers.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-slate-800 transition-all {{ request()->routeIs('platform.resellers.*') ? 'bg-indigo-600 text-white shadow-lg' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                <span class="font-bold text-sm">الموزعين</span>
            </a>
            @endif
            <div class="pt-4 pb-2 text-[10px] font-bold text-slate-500 uppercase tracking-widest px-4">السجلات والمراقبة</div>
            <a href="{{ route('platform.logs.webhooks') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-slate-800 transition-all {{ request()->routeIs('platform.logs.webhooks') ? 'bg-indigo-600 text-white shadow-lg' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M8 9l3 3-3 3m5 0h3M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                <span class="font-bold text-sm">سجلات الويب هوك</span>
            </a>
            <a href="{{ route('platform.logs.audit') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-slate-800 transition-all {{ request()->routeIs('platform.logs.audit') ? 'bg-indigo-600 text-white shadow-lg' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                <span class="font-bold text-sm">سجلات التدقيق</span>
            </a>
        </nav>
        <div class="p-6 border-t border-slate-800">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-indigo-600 flex items-center justify-center font-bold text-white">{{ substr(auth()->user()->name, 0, 1) }}</div>
                <div>
                    <p class="text-xs font-bold text-white">{{ auth()->user()->name }}</p>
                    <p class="text-[9px] text-slate-500 uppercase">{{ auth()->user()->role }}</p>
                </div>
            </div>
        </div>
    </aside>
    <main class="flex-1 p-12 overflow-y-auto">
        @if(session('success'))
            <div class="mb-8 bg-emerald-50 border border-emerald-100 p-4 rounded-2xl text-emerald-800 text-sm font-bold shadow-sm">
                {{ session('success') }}
            </div>
        @endif
        @yield('content')
    </main>
</body>
</html>
