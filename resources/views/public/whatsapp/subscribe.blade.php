@extends('layouts.public')

@section('content')
<div class="max-w-md mx-auto bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100" dir="rtl">
    <div class="bg-primary p-8 text-white text-center">
        <h2 class="text-2xl font-black mb-2">اشترك في تنبيهات واتساب</h2>
        <p class="text-sm opacity-90">ابقَ على اطلاع بمواعيد الصلاة والدروس وأخبار المسجد</p>
    </div>
    
    <form action="{{ route('public.whatsapp.subscribe.process', $mosque->slug) }}" method="POST" class="p-8 space-y-6 text-right">
        @csrf
        
        <div>
            <label class="block text-sm font-bold text-gray-700 mb-2">الاسم (اختياري)</label>
            <input type="text" name="name" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-primary outline-none transition-all" placeholder="مثلاً: محمد أحمد">
        </div>

        <div>
            <label class="block text-sm font-bold text-gray-700 mb-2">رقم الهاتف (واتساب)</label>
            <input type="tel" name="phone" required class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-primary outline-none transition-all text-left" dir="ltr" placeholder="+966 5x xxx xxxx">
            @error('phone') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-bold text-gray-700 mb-2">لغة الرسائل</label>
            <select name="locale" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-primary outline-none appearance-none">
                <option value="ar">العربية</option>
                <option value="en">English</option>
            </select>
        </div>

        <div class="flex items-start gap-3">
            <input type="checkbox" name="consent" id="consent" required class="mt-1 w-5 h-5 rounded border-gray-300 text-primary focus:ring-primary">
            <label for="consent" class="text-xs text-gray-500 leading-relaxed">
                أوافق على استلام رسائل واتساب من {{ $mosque->name }}. يمكنك إلغاء الاشتراك في أي وقت.
            </label>
        </div>

        <button type="submit" class="w-full bg-primary text-white font-black py-4 rounded-2xl shadow-lg hover:opacity-90 transition-all">
            تأكيد الاشتراك
        </button>
    </form>
    
    <div class="p-6 bg-gray-50 border-t border-gray-100 text-center">
        <a href="{{ route('public.whatsapp.unsubscribe', $mosque->slug) }}" class="text-xs text-gray-400 hover:text-red-500 underline">إلغاء الاشتراك السابق</a>
    </div>
</div>
@endsection
