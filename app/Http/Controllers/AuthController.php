<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;


class AuthController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function login(Request $request)
    {
        $validated = $request->validate([
            "email" => "required|string|email",
            "password" => "required|string"
        ]);

        if(!Auth::attempt(['email' => $validated["email"], 'password' => $validated["password"]]))
            return response()->json(array("status" => 403, "response" => ["error" => "Invalid credentials."]), 403);

        $user = Auth::user();
        $bearer = request()->bearerToken();
        if ($bearer) {
            $pat = PersonalAccessToken::findToken($bearer); // confronta hash in modo sicuro
            if ($pat && $pat->tokenable_id === $user->id) {
                $expired = $pat->expires_at instanceof Carbon && $pat->expires_at->isPast();
                if (! $expired && !$pat->deleted_at) {
                    return response()->json([
                        'status' => 200,
                        'response' => [
                            'message' => 'Token ancora valido.',
                            'token_id' => $bearer,
                            'expires_at' => optional($pat->expires_at)->toISOString(),
                        ],
                    ]);
                }

                // se scaduto, lo elimino per sicurezza
                $pat->delete();
            }
        }

        $minutes = config('sanctum.expiration');
        $expiresAt = $minutes ? now()->addMinutes($minutes) : null;

        $deviceName = $request->input('device_name') ?: ($request->userAgent() ?: 'default');

        $newToken = $user->createToken($deviceName, ['*'], $expiresAt);

        return response()->json([
            'status' => 200,
            'response' => [
                'token' => $newToken->plainTextToken, // questo puoi mostrarlo SOLO ora
                'expires_at' => optional($expiresAt)->toISOString(),
            ],
        ]);
    }

    public function authLogin(Request $request){
        $validated = $request->validate([
            "email" => "required|string|email",
            "password" => "required|string"
        ]);

        if(!Auth::attempt(['email' => $validated["email"], 'password' => $validated["password"]]))
            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ]);


        $request->session()->regenerate();
        return redirect('/dashboard');
    }

    public function authLogout(Request $request){
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function me(Request $request)
    {
        return response()->json(array("status" => 200, "response" => UserResource::make(auth('sanctum')->user()->with(['department']))->get()), 200);
    }

    /**
     * Display the specified resource.
     */
    public function logout()
    {
        $token = PersonalAccessToken::findToken(request()->bearerToken());
        $token->delete();

        return response()->json(array("status" => 200), 200);
    }
}
