<?php

namespace App\Http\Controllers\Api\Tenant;

use App\Http\Controllers\Controller;
use App\Models\FatwaQuestion;
use Illuminate\Http\Request;

class FatwaController extends Controller
{
    public function index()
    {
        return response()->json(FatwaQuestion::with('category')->latest()->paginate(20));
    }

    public function answer(Request $request, FatwaQuestion $fatwa)
    {
        $data = $request->validate([
            'answer' => ['required', 'string'],
            'status' => ['required', 'in:published,private_replied,draft'],
            'is_public' => ['nullable', 'boolean'],
        ]);

        $fatwa->update([
            'answer' => $data['answer'],
            'status' => $data['status'],
            'is_public' => $data['is_public'] ?? true,
            'answered_by' => $request->user('tenant')->id,
            'answered_at' => now(),
        ]);

        return response()->json($fatwa);
    }
}
