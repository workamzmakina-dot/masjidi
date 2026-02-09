@extends('layouts.tenant')

@section('content')
<div class="space-y-8">
    <div class="flex justify-between items-end">
        <div>
            <h2 class="text-3xl font-bold text-slate-800">Administrative Overview</h2>
            <p class="text-slate-500">Managing {{ $currentMosque->name }}</p>
        </div>
        <div class="bg-emerald-100 text-emerald-800 px-4 py-2 rounded-full text-xs font-bold">
            Plan: {{ strtoupper($currentMosque->plan->name ?? 'Basic') }}
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
            <span class="text-slate-400 text-xs font-bold uppercase tracking-wider">Total Donations</span>
            <div class="text-2xl font-bold mt-1">$4,250.00</div>
        </div>
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
            <span class="text-slate-400 text-xs font-bold uppercase tracking-wider">Active Subscribers</span>
            <div class="text-2xl font-bold mt-1">1,402</div>
        </div>
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
            <span class="text-slate-400 text-xs font-bold uppercase tracking-wider">WhatsApp Sent</span>
            <div class="text-2xl font-bold mt-1">852 / 1,000</div>
        </div>
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
            <span class="text-slate-400 text-xs font-bold uppercase tracking-wider">Storage Used</span>
            <div class="text-2xl font-bold mt-1">2.4 GB / 10 GB</div>
        </div>
    </div>

    <div class="bg-white p-8 rounded-2xl border border-slate-200 shadow-sm">
        <h3 class="font-bold text-slate-800 mb-4">Quick Actions</h3>
        <div class="flex gap-4">
            <button class="bg-slate-900 text-white px-6 py-3 rounded-xl font-bold text-sm">Send Broadcast</button>
            <button class="border border-slate-200 px-6 py-3 rounded-xl font-bold text-sm">Edit Prayer Times</button>
            <button class="border border-slate-200 px-6 py-3 rounded-xl font-bold text-sm">Create Campaign</button>
        </div>
    </div>
</div>
@endsection