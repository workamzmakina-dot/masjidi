@extends('layouts.platform')

@section('content')
<div class="space-y-8 animate-in slide-in-from-bottom duration-500">
    <div class="flex justify-between items-end">
        <div>
            <h2 class="text-3xl font-black text-slate-900 tracking-tight">إدارة المساجد</h2>
            <p class="text-slate-500">التحكم في كافة المستأجرين والحسابات النشطة.</p>
        </div>
        <a href="{{ route('platform.mosques.create') }}" class="bg-indigo-600 text-white px-8 py-3 rounded-2xl font-black shadow-xl hover:bg-indigo-500 transition-all flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            إضافة مسجد جديد
        </a>
    </div>

    <div class="bg-white rounded-[40px] border border-slate-200 overflow-hidden shadow-sm">
        <div class="p-8 border-b border-slate-100 bg-slate-50 flex flex-wrap gap-4">
            <form action="{{ route('platform.mosques.index') }}" class="flex-1 flex gap-4">
                <input type="text" name="search" value="{{ request('search') }}" class="flex-1 px-6 py-3 rounded-2xl border border-slate-200 text-sm focus:ring-2 focus:ring-indigo-600 outline-none transition-all" placeholder="بحث بالاسم أو المعرف...">
                <select name="status" class="px-6 py-3 rounded-2xl border border-slate-200 text-sm focus:ring-2 focus:ring-indigo-600 outline-none">
                    <option value="">كل الحالات</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>نشط</option>
                    <option value="suspended" {{ request('status') === 'suspended' ? 'selected' : '' }}>معلق</option>
                    <option value="trialing" {{ request('status') === 'trialing' ? 'selected' : '' }}>تجريبي</option>
                </select>
                <select name="plan_id" class="px-6 py-3 rounded-2xl border border-slate-200 text-sm focus:ring-2 focus:ring-indigo-600 outline-none">
                    <option value="">كل الباقات</option>
                    @foreach($plans as $p)
                    <option value="{{ $p->id }}" {{ request('plan_id') == $p->id ? 'selected' : '' }}>{{ $p->name }}</option>
                    @endforeach
                </select>
                <button type="submit" class="bg-slate-900 text-white px-8 py-3 rounded-2xl font-bold text-sm">تصفية</button>
            </form>
        </div>

        <table class="w-full text-right">
            <thead class="bg-slate-50 text-[10px] uppercase text-slate-400 font-black border-b">
                <tr>
                    <th class="px-8 py-5">المسجد</th>
                    <th class="px-8 py-5">الباقة</th>
                    <th class="px-8 py-5">الحالة</th>
                    <th class="px-8 py-5">الموزع</th>
                    <th class="px-8 py-5">المعرف</th>
                    <th class="px-8 py-5 text-left">الإجراءات</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-sm">
                @foreach($mosques as $m)
                <tr class="hover:bg-slate-50 transition-colors">
                    <td class="px-8 py-5">
                        <span class="font-bold text-slate-900 block">{{ $m->name }}</span>
                        <span class="text-xs text-slate-400">{{ $m->slug }}</span>
                    </td>
                    <td class="px-8 py-5">
                        <span class="bg-indigo-50 text-indigo-700 px-3 py-1 rounded-lg text-xs font-bold">{{ $m->plan->name ?? 'بدون باقة' }}</span>
                    </td>
                    <td class="px-8 py-5">
                        <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase {{ 
                            $m->status === 'active' ? 'bg-emerald-100 text-emerald-700' : ($m->status === 'suspended' ? 'bg-red-100 text-red-700' : 'bg-slate-100 text-slate-500') 
                        }}">
                            {{ $m->status }}
                        </span>
                    </td>
                    <td class="px-8 py-5 text-xs text-slate-500">
                        {{ $m->creator->name ?? 'إدارة النظام' }}
                    </td>
                    <td class="px-8 py-5 font-mono text-[10px] text-slate-400">#{{ $m->id }}</td>
                    <td class="px-8 py-5 text-left space-x-reverse space-x-3">
                        <a href="{{ route('platform.mosques.show', $m) }}" class="text-indigo-600 hover:text-indigo-900 font-bold">عرض</a>
                        <a href="{{ route('platform.mosques.edit', $m) }}" class="text-slate-500 hover:text-slate-900 font-bold">تعديل</a>
                        @if($m->status !== 'suspended')
                        <form action="{{ route('platform.mosques.suspend', $m) }}" method="POST" class="inline">
                            @csrf
                            <button class="text-red-500 hover:text-red-700 font-bold text-xs" onclick="return confirm('هل أنت متأكد من تعليق هذا الحساب؟')">تعليق</button>
                        </form>
                        @else
                        <form action="{{ route('platform.mosques.activate', $m) }}" method="POST" class="inline">
                            @csrf
                            <button class="text-emerald-500 hover:text-emerald-700 font-bold text-xs">تفعيل</button>
                        </form>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="p-8 bg-slate-50">
            {{ $mosques->links() }}
        </div>
    </div>
</div>
@endsection
