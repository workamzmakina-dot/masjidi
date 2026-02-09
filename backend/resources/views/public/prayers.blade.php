@extends('layouts.public')

@section('content')
<div class="space-y-8">
    @if($alert)
        <div class="bg-{{ $alert->type === 'emergency' ? 'red' : ($alert->type === 'warning' ? 'amber' : 'blue') }}-600 text-white p-4 rounded-2xl shadow-lg flex items-center gap-4 animate-pulse">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            <span class="font-bold">{{ $alert->message }}</span>
        </div>
    @endif

    <div class="bg-white rounded-3xl p-10 shadow-xl border border-gray-100">
        <div class="flex justify-between items-center mb-10">
            <div>
                <h2 class="text-3xl font-black text-primary">Prayer Timetable</h2>
                <p class="text-gray-500">{{ now()->format('l, jS F Y') }}</p>
            </div>
            @if($isRamadan)
                <div class="bg-indigo-100 text-indigo-700 px-6 py-2 rounded-full font-bold flex items-center gap-2">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path></svg>
                    Ramadan Mode Active
                </div>
            @endif
        </div>

        <div class="grid grid-cols-1 md:grid-cols-6 gap-4">
            @foreach(['fajr', 'sunrise', 'dhuhr', 'asr', 'maghrib', 'isha'] as $p)
                <div class="bg-gray-50 p-6 rounded-2xl border border-gray-100 text-center">
                    <span class="text-xs font-bold text-gray-400 uppercase tracking-widest">{{ $p }}</span>
                    <div class="text-2xl font-black text-primary my-2">{{ $today[$p]['adhan'] }}</div>
                    @if($p !== 'sunrise')
                        <div class="text-[10px] bg-primary/10 text-primary px-2 py-1 rounded font-bold uppercase">Iqama: {{ $today[$p]['iqama'] }}</div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection