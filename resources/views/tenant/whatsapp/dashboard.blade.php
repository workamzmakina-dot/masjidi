@extends('layouts.tenant')

@section('content')
<div class="space-y-8">
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-3xl font-bold text-slate-800">WhatsApp Marketing</h2>
            <p class="text-slate-500">Manage broadcasts, subscribers, and templates.</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('tenant.whatsapp.broadcast.create', $mosque->slug) }}" class="bg-primary text-white px-6 py-2.5 rounded-xl font-bold shadow-lg hover:opacity-90">New Broadcast</a>
            <a href="{{ route('tenant.whatsapp.provider.edit', $mosque->slug) }}" class="bg-white border border-slate-200 text-slate-700 px-6 py-2.5 rounded-xl font-bold">Settings</a>
        </div>
    </div>

    @php
        $provider = \App\Models\WhatsAppProviderSetting::where('mosque_id', $mosque->id)->first();
    @endphp

    @if(!$provider || !$provider->is_enabled)
    <div class="bg-amber-50 border border-amber-200 p-4 rounded-2xl flex items-center gap-4">
        <div class="bg-amber-100 p-2 rounded-lg text-amber-600">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
        </div>
        <div>
            <p class="text-sm font-bold text-amber-900">WhatsApp Provider Disabled</p>
            <p class="text-xs text-amber-700">Messages will be queued but not delivered until you enable a provider in settings.</p>
        </div>
    </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm">
            <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">Active Subscribers</span>
            <div class="text-3xl font-black text-emerald-600 mt-2">{{ number_format($stats['active_subscribers']) }}</div>
            <p class="text-[10px] text-slate-400 mt-1">{{ $stats['opted_out'] }} Unsubscribed</p>
        </div>
        
        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm md:col-span-2">
            <div class="flex justify-between items-start mb-4">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">Monthly Quota Usage</span>
                <span class="text-xs font-bold text-slate-900">{{ number_format($stats['sent_this_month']) }} / {{ number_format($mosque->plan->limits['whatsapp_messages'] ?? 0) }}</span>
            </div>
            <div class="w-full h-3 bg-slate-100 rounded-full overflow-hidden">
                <div class="h-full bg-primary" style="width: {{ $stats['quota_percent'] }}%"></div>
            </div>
            <p class="text-[10px] text-slate-400 mt-2">{{ number_format($stats['quota_remaining']) }} Messages Remaining this month.</p>
        </div>

        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm">
            <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">Failed Deliveries</span>
            <div class="text-3xl font-black text-red-500 mt-2">{{ $stats['failed_count'] }}</div>
            <p class="text-[10px] text-slate-400 mt-1">Check outbox for errors</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <div class="bg-white rounded-3xl border border-slate-100 p-8">
            <h3 class="font-bold text-slate-800 mb-6 flex items-center gap-2">
                <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                Management Links
            </h3>
            <div class="grid grid-cols-2 gap-4">
                <a href="{{ route('tenant.whatsapp.subscribers.index', $mosque->slug) }}" class="p-4 bg-slate-50 rounded-2xl hover:bg-emerald-50 transition-all border border-transparent hover:border-emerald-100">
                    <span class="block font-bold text-sm text-slate-800">Subscribers</span>
                    <span class="text-[10px] text-slate-400">View & Import list</span>
                </a>
                <a href="{{ route('tenant.whatsapp.segments.index', $mosque->slug) }}" class="p-4 bg-slate-50 rounded-2xl hover:bg-emerald-50 transition-all border border-transparent hover:border-emerald-100">
                    <span class="block font-bold text-sm text-slate-800">Segments</span>
                    <span class="text-[10px] text-slate-400">Targeting groups</span>
                </a>
                <a href="{{ route('tenant.whatsapp.templates.index', $mosque->slug) }}" class="p-4 bg-slate-50 rounded-2xl hover:bg-emerald-50 transition-all border border-transparent hover:border-emerald-100">
                    <span class="block font-bold text-sm text-slate-800">Templates</span>
                    <span class="text-[10px] text-slate-400">Message content</span>
                </a>
                <a href="{{ route('tenant.whatsapp.outbox.index', $mosque->slug) }}" class="p-4 bg-slate-50 rounded-2xl hover:bg-emerald-50 transition-all border border-transparent hover:border-emerald-100">
                    <span class="block font-bold text-sm text-slate-800">Outbox</span>
                    <span class="text-[10px] text-slate-400">Delivery history</span>
                </a>
            </div>
        </div>

        <div class="bg-slate-900 rounded-3xl p-8 text-white relative overflow-hidden">
            <div class="relative z-10">
                <h3 class="text-xl font-bold mb-2">Automated Friday Reminders</h3>
                <p class="text-slate-400 text-sm mb-6 leading-relaxed">Boost Jumaa attendance automatically. Our system sends a reminder every Friday morning to all active worshippers.</p>
                <div class="flex items-center gap-4">
                    <div class="bg-emerald-500/20 text-emerald-400 px-4 py-1.5 rounded-full text-xs font-bold border border-emerald-500/30">ENABLED</div>
                    <span class="text-xs text-slate-500">Next send: This Friday, 09:00 AM</span>
                </div>
            </div>
            <svg class="absolute -right-8 -bottom-8 w-48 h-48 text-white/5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 .587l3.668 7.431 8.2 1.192-5.934 5.787 1.4 8.169L12 18.896l-7.334 3.864 1.4-8.169L.132 9.21l8.2-1.192z"/></svg>
        </div>
    </div>
</div>
@endsection