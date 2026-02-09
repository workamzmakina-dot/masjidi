<?php

namespace App\Http\Controllers\Api\Platform;

use App\Http\Controllers\Controller;
use App\Models\Feature;

class FeatureController extends Controller
{
    public function index()
    {
        return response()->json(Feature::orderBy('name')->get());
    }
}
