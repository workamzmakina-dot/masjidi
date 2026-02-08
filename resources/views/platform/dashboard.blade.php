@extends('layouts.platform')

@section('content')
<div class="space-y-12 animate-in fade-in duration-500">
    <div>
        <h2 class="text-4xl font-black text-slate-900 tracking-tight">نظرة عامة على المنصة</h2>
        <p class="text-slate-500 mt-2">مراقبة الأداء والنمو عبر كافة المستأجرين.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
        <div class="bg-white p-8 rounded-3xl border border-slate-200 shadow-sm hover:shadow-md transition-shadow">
            <span class="text-[10px] font-black uppercase text-slate-400 tracking-widest">إجمالي المساجد</span>
            <div class="text-4xl font-black text-indigo-600 mt-2">{{ number_format($stats['total_mosques']) }}</div>
            <p class="text-xs text-slate-400 mt-2">{{ $stats['active_mosques'] }} مساجد نشطة</p>
        </div>
        <div class="bg-white p-8 rounded-3xl border border-slate-200 shadow-sm hover:shadow-md transition-shadow">
            <span class="text-[10px] font-black uppercase text-slate-400 tracking-widest">المشتركون النشطون</span>
            <div class="text-4xl font-black text-emerald-600 mt-2">{{ number_format($stats['total_subscribers']) }}</div>
            <p class="text-xs text-slate-400 mt-2">عبر كافة القنوات</p>
        </div>
        <div class="bg-white p-8 rounded-3xl border border-slate-200 shadow-sm hover:shadow-md transition-shadow">
            <span class="text-[10px] font-black uppercase text-slate-400 tracking-widest">رسائل واتساب (هذا الشهر)</span>
            <div class="text-4xl font-black text-purple-600 mt-2">{{ number_format($stats['whatsapp_sent_month']) }}</div>
            <p class="text-xs text-slate-400 mt-2">معدل الاستهلاك الشهري</p>
        </div>
        <div class="bg-white p-8 rounded-3xl border border-slate-200 shadow-sm hover:shadow-md transition-shadow">
            <span class="text-[10px] font-black uppercase text-slate-400 tracking-widest">إجمالي التبرعات</span>
            <div class="text-4xl font-black text-amber-600 mt-2">{{ number_format($stats['total_donations']) }}</div>
            <p class="text-xs text-slate-400 mt-2">عمليات ناجحة</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
        <div class="lg:col-span-2 bg-white rounded-[40px] border border-slate-200 p-10">
            <h3 class="text-xl font-bold text-slate-900 mb-8 flex items-center gap-3">
                <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                أحدث المساجد المنضمة
            </h3>
            <div class="overflow-x-auto">
                <table class="w-full text-right">
                    <thead>
                        <tr class="text-[10px] font-black text-slate-400 uppercase tracking-widest border-b pb-4">
                            <th class="pb-4">المسجد</th>
                            <th class="pb-4">الباقة</th>
                            <th class="pb-4">الحالة</th>
                            <th class="pb-4">تاريخ الانضمام</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($recentMosques as $m)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="py-5">
                                <span class="font-bold text-slate-900">{{ $m->name }}</span>
                                <span class="block text-xs text-slate-400">{{ $m->slug }}</span>
                            </td>
                            <td class="py-5">
                                <span class="bg-indigo-50 text-indigo-700 px-3 py-1 rounded-lg text-xs font-bold">{{ $m->plan->name ?? 'No Plan' }}</span>
                            </td>
                            <td class="py-5">
                                <span class="px-2 py-1 rounded-full text-[10px] font-bold uppercase {{ $m->status === 'active' ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-500' }}">
                                    {{ $m->status }}
                                </span>
                            </td>
                            <td class="py-5 text-xs text-slate-500">{{ $m->created_at->format('Y-m-d') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="space-y-6">
            <div class="bg-slate-900 rounded-[40px] p-10 text-white relative overflow-hidden">
                <div class="relative z-10">
                    <h3 class="text-xl font-bold mb-4">التحديث القادم</h3>
                    <p class="text-slate-400 text-sm leading-relaxed mb-8">نظام الفوترة التلقائية سيتم تفعيله لجميع المستخدمين في الأول من الشهر القادم.</p>
                    <button class="bg-indigo-600 px-6 py-2.5 rounded-xl font-bold text-sm shadow-xl hover:bg-indigo-500 transition-colors">عرض التفاصيل</button>
                </div>
                <svg class="absolute -right-8 -bottom-8 w-48 h-48 text-white/5" fill="currentColor" viewBox="0 0 24 24"><path d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
            </div>
            
            <div class="bg-indigo-600 rounded-[40px] p-10 text-white flex flex-col items-center justify-center text-center">
                <h4 class="text-xs font-bold uppercase tracking-widest opacity-60 mb-2">الدعم الفني</h4>
                <p class="text-2xl font-black mb-6">هل تحتاج لمساعدة؟</p>
                <a href="#" class="bg-white text-indigo-600 px-8 py-3 rounded-2xl font-black shadow-2xl hover:bg-slate-50 transition-colors">تحدث معنا</a>
            </div>
        </div>
    </div>
</div>
@endsection
