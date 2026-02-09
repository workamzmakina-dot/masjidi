<?php

namespace App\Http\Controllers\Api\Tenant;

use App\Http\Controllers\Controller;
use App\Models\WhatsAppSubscriber;
use Illuminate\Http\Request;

class WhatsAppSubscriberController extends Controller
{
    public function index()
    {
        return response()->json(WhatsAppSubscriber::latest()->paginate(25));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'phone_e164' => ['required', 'string'],
            'name' => ['nullable', 'string'],
            'locale' => ['nullable', 'string'],
            'status' => ['nullable', 'in:active,opted_out,blocked'],
            'source' => ['nullable', 'string'],
        ]);

        $subscriber = WhatsAppSubscriber::create($data);

        return response()->json($subscriber, 201);
    }

    public function destroy(WhatsAppSubscriber $subscriber)
    {
        $subscriber->delete();

        return response()->json(['message' => 'Subscriber deleted.']);
    }

    public function block(WhatsAppSubscriber $subscriber)
    {
        $subscriber->update(['status' => 'blocked']);

        return response()->json($subscriber);
    }

    public function unblock(WhatsAppSubscriber $subscriber)
    {
        $subscriber->update(['status' => 'active']);

        return response()->json($subscriber);
    }
}
