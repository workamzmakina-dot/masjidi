<?php

namespace App\Http\Controllers\Api\Tenant;

use App\Http\Controllers\Controller;
use App\Models\WhatsAppTemplate;
use Illuminate\Http\Request;

class WhatsAppTemplateController extends Controller
{
    public function index()
    {
        return response()->json(WhatsAppTemplate::latest()->paginate(20));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string'],
            'language' => ['nullable', 'string'],
            'content' => ['required', 'string'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $template = WhatsAppTemplate::create($data);

        return response()->json($template, 201);
    }

    public function show(WhatsAppTemplate $template)
    {
        return response()->json($template);
    }

    public function update(Request $request, WhatsAppTemplate $template)
    {
        $data = $request->validate([
            'name' => ['sometimes', 'string'],
            'language' => ['nullable', 'string'],
            'content' => ['sometimes', 'string'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $template->update($data);

        return response()->json($template);
    }

    public function destroy(WhatsAppTemplate $template)
    {
        $template->delete();

        return response()->json(['message' => 'Template deleted.']);
    }
}
