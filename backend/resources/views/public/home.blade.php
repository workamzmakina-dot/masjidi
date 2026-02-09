@extends('layouts.public')

@section('content')
<div class="bg-white rounded-3xl p-12 shadow-xl border border-gray-100 text-center">
    <h2 class="text-4xl font-black text-primary mb-4">Welcome to {{ $currentMosque->name }}</h2>
    <p class="text-gray-500 text-lg max-w-2xl mx-auto">Providing a sanctuary for faith, education, and community support in the heart of our neighborhood.</p>
    
    <div class="mt-12 grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="p-6 bg-primary/5 rounded-2xl">
            <h3 class="font-bold text-primary mb-2">Prayer Times</h3>
            <p class="text-sm text-gray-600">Fajr: 05:30 AM</p>
            <p class="text-sm text-gray-600">Dhuhr: 01:00 PM</p>
        </div>
        <div class="p-6 bg-primary/5 rounded-2xl">
            <h3 class="font-bold text-primary mb-2">Next Lecture</h3>
            <p class="text-sm text-gray-600">Tafseer Session</p>
            <p class="text-sm text-gray-600">Every Friday after Maghrib</p>
        </div>
        <div class="p-6 bg-primary/5 rounded-2xl">
            <h3 class="font-bold text-primary mb-2">Donate</h3>
            <p class="text-sm text-gray-600">Support our mosque projects via WishMoney.</p>
        </div>
    </div>
</div>
@endsection