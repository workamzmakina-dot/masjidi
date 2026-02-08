@extends('layouts.platform')

@section('content')
<div class="space-y-10 animate-in fade-in duration-500">
    <div class="flex justify-between items-center">
        <div class="flex items-center gap-6">
            <div class="w-20 h-20 rounded-[30px] bg-slate-900 text-white flex items-center justify-center text-3xl font-black shadow-2xl">
                {{ substr($mosque->name, 0, 1) }}
            </div>
            <div>
                <h2 class="text-4xl font-black text-slate-900 tracking-tight">{{ $mosque->name }}</h2>
                <div class="flex items-center gap-3 mt-1">
                    <span class="text-slate-400 text-sm">{{ $mosque->slug }}.mosquesaas.com</span>
                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase {{ $mosque->status === 'active' ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700' }}">
                        {{ $mosque->status }}
                    </span>
                </div>
            </div>
        </div>
        <div class="flex gap-4">
            <a href="{{ route('platform.mosques.overrides.edit', $mosque) }}" class="bg-white border border-slate-200 px-6 py-3 rounded-2xl font-bold text-sm shadow-sm hover:bg-slate-50 transition-all">تخصيص الميزات</a>
            <a href="{{ route('platform.mosques.subscription.edit', $mosque) }}" class="bg-indigo-600 text-white px-6 py-3 rounded-2xl font-bold text-sm shadow-xl hover:bg-indigo-500 transition-all">تغيير الباقة</a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
        <div class="lg:col-span-2 space-y-10">
            <div class="bg-white rounded-[40px] border border-slate-200 p-10">
                <h3 class="font-black text-slate-900 text-xl mb-8">إحصائيات الاستخدام</h3>
                <div class="grid grid-cols-2 gap-8">
                    @php
                        $sent = \App\Models\UsageCounter::where('mosque_id', $mosque->id)->where('feature_name', 'whatsapp_sent')->where('reset_date', '>=', now()->startOfMonth())->value('current_usage') ?? 0;
                        $limit = $mosque->plan->limits['whatsapp_messages'] ?? 100;
                        $percent = $limit > 0 ? min(100, round(($sent / $limit) * 100)) : 0;
                    @endphp
                    <div class="p-6 bg-slate-50 rounded-3xl">
                        <div class="flex justify-between items-center mb-4">
                            <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">كوتا الواتساب (شهرياً)</span>
                            <span class="text-xs font-black text-indigo-600">{{ $sent }} / {{ $limit }}</span>
                        </div>
                        <div class="w-full h-3 bg-slate-200 rounded-full overflow-hidden">
                            <div class="h-full bg-indigo-600 shadow-[0_0_10px_rgba(79,70,229,0.3)]" style="width: {{ $percent }}%"></div>
                        </div>
                        <p class="text-[10px] text-slate-400 mt-2">المسجد استهلك {{ $percent }}% من الكوتا المتاحة.</p>
                    </div>

                    <div class="p-6 bg-slate-50 rounded-3xl">
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">إجمالي التبرعات</span>
                        <div class="text-3xl font-black text-amber-600 mt-2">{{ \App\Models\Donation::where('mosque_id', $mosque->id)->where('status', 'paid')->count() }}</div>
                        <p class="text-[10px] text-slate-400 mt-1">عمليات دفع ناجحة عبر WISH Money</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-[40px] border border-slate-200 p-10">
                <h3 class="font-black text-slate-900 text-xl mb-8">الميزات المفعلة (Flag Status)</h3>
                <div class="grid grid-cols-3 gap-4">
                    @php
                        $features = $mosque->plan->features ?? [];
                    @endphp
                    @foreach(['prayer_times', 'lectures', 'events', 'fatwas', 'donations', 'whatsapp_notifications', 'white_label'] as $f)
                        <div class="flex items-center gap-3 p-4 rounded-2xl {{ in_array($f, $features) ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-100 text-slate-400' }}">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                            <span class="text-xs font-bold">{{ ucwords(str_replace('_', ' ', $f)) }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <div class="bg-slate-900 rounded-[40px] p-10 text-white">
                <h4 class="text-xs font-black uppercase tracking-widest text-slate-500 mb-6">معلومات التواصل</h4>
                <div class="space-y-4">
                    <div>
                        <span class="text-[10px] text-slate-500 font-bold block">تاريخ التسجيل</span>
                        <span class="text-sm font-bold">{{ $mosque->created_at->format('j F Y') }}</span>
                    </div>
                    <div>
                        <span class="text-[10px] text-slate-500 font-bold block">الموقع</span>
                        <span class="text-sm font-bold">{{ $mosque->settings['location'] ?? 'غير محدد' }}</span>
                    </div>
                    <div>
                        <span class="text-[10px] text-slate-500 font-bold block">الدومين المخصص</span>
                        <span class="text-sm font-bold text-indigo-400">{{ $mosque->custom_domain ?: 'لا يوجد' }}</span>
                    </div>
                </div>
            </div>

            <div class="bg-white border border-slate-200 rounded-[40px] p-10">
                <h4 class="text-xs font-black uppercase tracking-widest text-slate-400 mb-6">إجراءات سريعة</h4>
                <div class="space-y-3">
                    <button class="w-full text-right p-4 rounded-2xl hover:bg-slate-50 transition-all group">
                        <span class="font-bold text-sm block">تحميل السجلات</span>
                        <span class="text-[10px] text-slate-400">PDF Audit Report</span>
                    </button>
                    <button class="w-full text-right p-4 rounded-2xl hover:bg-slate-50 transition-all group">
                        <span class="font-bold text-sm block">تصفير العدادات</span>
                        <span class="text-[10px] text-slate-400">Manual Usage Reset</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
