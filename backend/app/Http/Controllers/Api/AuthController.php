<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Mosque;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
            'role' => ['required', 'in:tenant,platform'],
            'mosque_slug' => ['nullable', 'string']
        ]);

        $guard = $data['role'] === 'platform' ? 'platform' : 'tenant';

        if ($guard === 'tenant') {
            $slug = $data['mosque_slug'] ?? $request->header('X-Tenant-Slug');
            $mosque = $slug ? Mosque::where('slug', $slug)->first() : null;

            if (!$mosque) {
                return response()->json(['message' => 'Mosque not found.'], 404);
            }
        }

        if (!Auth::guard($guard)->attempt(['email' => $data['email'], 'password' => $data['password']])) {
            return response()->json(['message' => 'Invalid credentials.'], 422);
        }

        $request->session()->regenerate();

        return response()->json([
            'message' => 'Logged in successfully.',
            'user' => Auth::guard($guard)->user(),
            'guard' => $guard,
        ]);
    }

    public function logout(Request $request)
    {
        $guard = $request->input('role') === 'platform' ? 'platform' : 'tenant';

        Auth::guard($guard)->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json(['message' => 'Logged out successfully.']);
    }

    public function me(Request $request)
    {
        $user = $request->user('platform') ?? $request->user('tenant');

        if (!$user) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        return response()->json(['user' => $user]);
    }
}
