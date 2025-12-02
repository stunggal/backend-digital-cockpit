<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

/**
 * API Authentication controller.
 *
 * Responsibilities:
 * - Authenticate users and issue personal access tokens
 * - Revoke tokens (logout)
 * - Provide a test token for development
 */
class AuthController extends Controller
{
    /**
     * Handle a login request and return a personal access token.
     *
     * Validates the request payload, verifies the user's credentials and
     * issues a Sanctum personal access token on success.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        // Validate input early so callers get clear feedback
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Find the user by email
        $user = User::where('email', $request->email)->first();

        // Verify the user exists and the password matches
        if (!$user || !Hash::check($request->password, $user->password)) {
            // Log failed login attempt for debugging/monitoring
            Log::warning('Failed login attempt', ['email' => $request->email]);
            return response()->json(['message' => 'Email atau password salah'], 401);
        }

        // Create a personal access token (Sanctum). The token is returned
        // as plain text so the client can store it for subsequent requests.
        $token = $user->createToken('auth_token')->plainTextToken;

        Log::info('User logged in', ['user_id' => $user->id]);

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ], 200);
    }

    // Anda juga bisa menambahkan fungsi logout
    /**
     * Revoke the current access token (logout).
     *
     * If the authenticated request has a current access token it will be
     * deleted. If there is no token present a friendly message is returned.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        $user = $request->user();
        if (!$user) {
            // No authenticated user on the request
            return response()->json(['message' => 'No authenticated user'], 401);
        }

        // currentAccessToken() may be null if the request had no token
        $token = $user->currentAccessToken();
        if ($token) {
            $token->delete();
            Log::info('User logged out', ['user_id' => $user->id]);
            return response()->json(['message' => 'Berhasil logout']);
        }

        // If there was no token to delete, return a neutral response
        return response()->json(['message' => 'No active token found']);
    }

    /**
     * Create a test token for the first user. Useful in development to
     * quickly obtain a token when authenticating against the API.
     *
     * NOTE: This method should not be exposed in production environments.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function test()
    {
        $user = User::first();
        if (!$user) {
            return response()->json(['message' => 'No users exist in the database'], 404);
        }

        $token = $user->createToken('test_token')->plainTextToken;
        Log::debug('Test token created', ['user_id' => $user->id]);

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ], 200);
    }
}
