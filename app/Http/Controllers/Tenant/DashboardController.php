<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Mosque;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $mosque = app(Mosque::class);
        // Tenant data logic here (auto-scoped by Mosque::class singleton in ResolveTenant)
        return view('tenant.dashboard', compact('mosque'));
    }
}