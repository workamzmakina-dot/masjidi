<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use App\Models\Mosque;
use App\Services\Payment\WishMoneyGateway;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DonationFlowController extends Controller
{
    public function show($mosque_slug, $campaign_id)
    {
        return view('public.donate', [
            'campaign' => \App\Models\Campaign::findOrFail($campaign_id)
        ]);
    }

    public function process(Request $request, $mosque_slug)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:1',
            'campaign_id' => 'required|exists:campaigns,id',
            'worshipper_name' => 'required|string'
        ]);

        $mosque = app(Mosque::class);
        
        $donation = Donation::create([
            'transaction_id' => Str::uuid(),
            'amount' => $validated['amount'],
            'campaign_id' => $validated['campaign_id'],
            'status' => 'pending',
            'payment_method' => 'wish_money'
        ]);

        // Mocking gateway retrieval from mosque settings
        $gateway = new WishMoneyGateway((object)[
            'credentials' => encrypt([
                'api_key' => config('services.wish.key'),
                'secret' => config('services.wish.secret'),
                'url' => 'https://api.wish.money'
            ])
        ]);

        $checkoutUrl = $gateway->createPayment($donation);

        return redirect($checkoutUrl);
    }
}
