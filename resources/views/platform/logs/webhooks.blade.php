@extends('layouts.platform')

@section('content')
<div class="space-y-8 animate-in fade-in duration-500">
    <div>
        <h2 class="text-3xl font-black text-slate-900 tracking-tight">سجلات الويب هوك</h2>
        <p class="text-slate-500">مراقبة العمليات الواردة من مزودي الدفع والاتصالات.</p>
    </div>

    <div class="bg-white rounded-[40px] border border-slate-200 overflow-hidden shadow-sm">
        <div class="p-8 border-b border-slate-100 bg-slate-50">
            <form action="{{ route('platform.logs.webhooks') }}" class="flex gap-4">
                <select name="mosque_id" class="px-6 py-3 rounded-2xl border border-slate-200 text-sm">
                    <option value="">كل المساجد</option>
                    @foreach($mosques as $m)
                    <option value="{{ $m->id }}" {{ request('mosque_id') == $m->id ? 'selected' : '' }}>{{ $m->name }}</option>
                    @endforeach
                </select>
                <select name="provider" class="px-6 py-3 rounded-2xl border border-slate-200 text-sm">
                    <option value="">كل المزودين</option>
                    <option value="wish" {{ request('provider') === 'wish' ? 'selected' : '' }}>WISH Money</option>
                    <option value="meta" {{ request('provider') === 'meta' ? 'selected' : '' }}>WhatsApp (Meta)</option>
                </select>
                <button type="submit" class="bg-slate-900 text-white px-8 py-3 rounded-2xl font-bold text-sm">تصفية</button>
            </form>
        </div>

        <table class="w-full text-right text-sm">
            <thead class="bg-slate-50 text-[10px] uppercase text-slate-400 font-black border-b">
                <tr>
                    <th class="px-8 py-5">المعرف</th>
                    <th class="px-8 py-5">المسجد</th>
                    <th class="px-8 py-5">المزود</th>
                    <th class="px-8 py-5">التحقق</th>
                    <th class="px-8 py-5">التوقيت</th>
                    <th class="px-8 py-5 text-left">التفاصيل</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach($logs as $l)
                <tr class="hover:bg-slate-50">
                    <td class="px-8 py-4 font-mono text-[10px]">{{ $l->request_id }}</td>
                    <td class="px-8 py-4 font-bold">{{ $l->mosque->name ?? 'غير محدد' }}</td>
                    <td class="px-8 py-4 uppercase font-bold text-[10px]">{{ $l->provider }}</td>
                    <td class="px-8 py-4">
                        @if($l->verified)
                        <span class="text-emerald-600 font-bold flex items-center gap-1"><svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"></path></svg> موثق</span>
                        @else
                        <span class="text-red-600 font-bold">فشل</span>
                        @endif
                    </td>
                    <td class="px-8 py-4 text-xs text-slate-400">{{ $l->received_at->format('H:i:s Y-m-d') }}</td>
                    <td class="px-8 py-4 text-left">
                        <button class="text-indigo-600 hover:underline font-bold text-xs" onclick="alert(JSON.stringify(@json($l->payload), null, 2))">عرض الحمولة</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="p-8 bg-slate-50">
            {{ $logs->links() }}
        </div>
    </div>
</div>
@endsection
