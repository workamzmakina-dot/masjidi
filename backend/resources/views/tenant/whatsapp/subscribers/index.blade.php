@extends('layouts.tenant')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h2 class="text-2xl font-bold text-slate-800">WhatsApp Subscribers</h2>
        <div class="flex gap-2">
            <button onclick="document.getElementById('import-modal').classList.remove('hidden')" class="bg-white border border-slate-200 px-4 py-2 rounded-lg text-sm font-bold shadow-sm">Import CSV</button>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">
        <div class="p-4 border-b border-slate-100 flex gap-4 bg-slate-50">
            <form action="{{ route('tenant.whatsapp.subscribers.index', $mosque->slug) }}" class="flex-1 flex gap-2">
                <input type="text" name="search" value="{{ request('search') }}" class="flex-1 px-4 py-2 rounded-lg border border-slate-200 text-sm" placeholder="Search by name or phone...">
                <select name="status" class="px-4 py-2 rounded-lg border border-slate-200 text-sm">
                    <option value="">All Statuses</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="opted_out" {{ request('status') === 'opted_out' ? 'selected' : '' }}>Opted Out</option>
                    <option value="blocked" {{ request('status') === 'blocked' ? 'selected' : '' }}>Blocked</option>
                </select>
                <button class="bg-slate-900 text-white px-6 py-2 rounded-lg text-sm font-bold">Filter</button>
            </form>
        </div>

        <table class="w-full text-left">
            <thead class="bg-slate-50 text-[10px] uppercase text-slate-400 font-black border-b">
                <tr>
                    <th class="px-6 py-4">Subscriber</th>
                    <th class="px-6 py-4">Phone</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4">Source</th>
                    <th class="px-6 py-4">Joined At</th>
                    <th class="px-6 py-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-sm">
                @foreach($subscribers as $s)
                <tr class="hover:bg-slate-50 transition-colors">
                    <td class="px-6 py-4 font-bold">{{ $s->name ?: 'Worshipper' }}</td>
                    <td class="px-6 py-4 font-mono text-xs">{{ $s->phone_e164 }}</td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase {{ 
                            $s->status === 'active' ? 'bg-emerald-100 text-emerald-700' : ($s->status === 'blocked' ? 'bg-red-100 text-red-700' : 'bg-slate-100 text-slate-500') 
                        }}">
                            {{ $s->status }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-xs text-slate-500">{{ $s->source }}</td>
                    <td class="px-6 py-4 text-xs text-slate-400">{{ $s->created_at->format('Y-m-d') }}</td>
                    <td class="px-6 py-4 text-right space-x-2">
                        @if($s->status !== 'blocked')
                        <form action="{{ route('tenant.whatsapp.subscribers.block', [$mosque->slug, $s]) }}" method="POST" class="inline">
                            @csrf
                            <button class="text-red-500 text-[10px] font-bold uppercase hover:underline">Block</button>
                        </form>
                        @else
                        <form action="{{ route('tenant.whatsapp.subscribers.unblock', [$mosque->slug, $s]) }}" method="POST" class="inline">
                            @csrf
                            <button class="text-emerald-500 text-[10px] font-bold uppercase hover:underline">Unblock</button>
                        </form>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="p-6">
            {{ $subscribers->links() }}
        </div>
    </div>
</div>
@endsection
