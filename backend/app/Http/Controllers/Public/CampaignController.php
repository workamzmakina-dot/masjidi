<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Mosque;
use App\Services\QrCodeService;
use Illuminate\View\View;

class CampaignController extends Controller
{
    public function index(): View
    {
        $mosque = app(Mosque::class);
        $campaigns = Campaign::where('is_active', true)->latest()->get();
        return view('public.campaigns.index', compact('mosque', 'campaigns'));
    }

    public function show($mosque_slug, $id, QrCodeService $qrService): View
    {
        $campaign = Campaign::findOrFail($id);
        $qrCode = $qrService->generateForCampaign($campaign);
        
        // Track view
        $campaign->increment('views'); // Schema needs to be updated or added in migration

        return view('public.campaigns.show', compact('campaign', 'qrCode'));
    }
}