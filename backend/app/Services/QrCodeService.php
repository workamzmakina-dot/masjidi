<?php

namespace App\Services;

class QrCodeService
{
    /**
     * Generate a QR Code URL pointing to a campaign
     */
    public function generateForCampaign($campaign)
    {
        $url = route('public.campaigns.show', [
            'mosque_slug' => $campaign->mosque->slug,
            'campaign_id' => $campaign->id
        ]);

        // Using a reliable public API for QR generation in Step 3
        return "https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=" . urlencode($url);
    }
}