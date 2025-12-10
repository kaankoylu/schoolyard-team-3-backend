<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): Response
    {
        // This does the actual Auth::attempt(...) etc.
        $request->authenticate();

        // On "normal" web routes there is a session; on /api/login there isn't.
        // Avoid "Session store not set on request" by only touching it if present.
        if ($request->hasSession()) {
            $request->session()->regenerate();
        }

        // For API usage we just return 204 No Content on success.
        return response()->noContent();
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): Response
    {
        Auth::guard('web')->logout();

        // Again: only touch the session if the middleware created one.
        if ($request->hasSession()) {
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }

        return response()->noContent();
    }
}
