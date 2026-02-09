<?php

namespace App\Http\Controllers\Platform;

use App\Http\Controllers\Controller;
use App\Models\Mosque;
use App\Models\Plan;

class GlobalDashboardController extends Controller
{
    public function index()
    {
        return view('platform.dashboard', [
            'mosque_count' => Mosque::count(),
            'total_revenue' => '$14,500',
            'top_plans' => Plan::withCount('mosques')->get()
        ]);
    }
}
