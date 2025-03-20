<?php declare(strict_types=1);

namespace App\Actions;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\NewAccessToken;

class AuthenticateUser
{
    /**
     * Execute the login action.
     */
    public function execute(Request $request): array
    {
        // Validate request
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // Attempt authentication
        if (!Auth::attempt($request->only('email', 'password'))) {
            return [
                'success' => false,
                'message' => 'Unauthorized',
                'status' => 401
            ];
        }

        // Generate token
        $user = Auth::user();
        $user->token = $user->createToken('auth_token')->plainTextToken;

        return [
            'success' => true,
            'message' => 'Login successful',
            'user' => $user,
            'status' => 200
        ];
    }
}
