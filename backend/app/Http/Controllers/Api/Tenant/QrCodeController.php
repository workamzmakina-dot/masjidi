<?php

namespace App\Http\Controllers\Api\Tenant;

use App\Http\Controllers\Controller;
use App\Models\QrCode;
use Illuminate\Http\Request;

class QrCodeController extends Controller
{
    public function index()
    {
        return response()->json(QrCode::latest()->paginate(20));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'label' => ['required', 'string'],
            'payload' => ['required', 'string'],
            'image_path' => ['nullable', 'string'],
        ]);

        $qr = QrCode::create($data);

        return response()->json($qr, 201);
    }

    public function show(QrCode $qr_code)
    {
        return response()->json($qr_code);
    }

    public function update(Request $request, QrCode $qr_code)
    {
        $data = $request->validate([
            'label' => ['sometimes', 'string'],
            'payload' => ['sometimes', 'string'],
            'image_path' => ['nullable', 'string'],
        ]);

        $qr_code->update($data);

        return response()->json($qr_code);
    }

    public function destroy(QrCode $qr_code)
    {
        $qr_code->delete();

        return response()->json(['message' => 'QR code deleted.']);
    }
}
