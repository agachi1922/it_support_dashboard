<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'email' => [
                'required',
                'email',
            ],
            'password' => [
                'required',
                'string',
            ],
            'device_name' => [
                'nullable',
                'string',
                'max:100',
            ],
        ]);

        $user = User::where('email', $validated['email'])->first();

        if (! $user || ! Hash::check($validated['password'], $user->password)) {
            Log::warning('API login failed', [
                'email' => $validated['email'],
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'time' => now()->toDateTimeString(),
            ]);

            throw ValidationException::withMessages([
                'email' => [
                    'Email atau password tidak sesuai.',
                ],
            ]);
        }

        $token = $user->createToken(
            $validated['device_name'] ?? 'api-client'
        )->plainTextToken;

        Log::info('API login success', [
            'user_id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role,
            'device_name' => $validated['device_name'] ?? 'api-client',
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'time' => now()->toDateTimeString(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Login API berhasil.',
            'data' => [
                'token_type' => 'Bearer',
                'token' => $token,
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->role,
                ],
            ],
            'errors' => null,
        ]);
    }

    public function me(Request $request): JsonResponse
    {
        Log::info('API user profile accessed', [
            'user_id' => $request->user()?->id,
            'email' => $request->user()?->email,
            'ip' => $request->ip(),
            'time' => now()->toDateTimeString(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data pengguna berhasil diambil.',
            'data' => $request->user(),
            'errors' => null,
        ]);
    }

    public function logout(Request $request): JsonResponse
    {
        Log::info('API logout', [
            'user_id' => $request->user()?->id,
            'email' => $request->user()?->email,
            'ip' => $request->ip(),
            'time' => now()->toDateTimeString(),
        ]);

        $request->user()->currentAccessToken()?->delete();

        return response()->json([
            'success' => true,
            'message' => 'Token berhasil dicabut.',
            'data' => null,
            'errors' => null,
        ]);
    }
}