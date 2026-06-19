<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showLogin(): View
    {
        return view('auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => [
                'required',
                'email',
            ],
            'password' => [
                'required',
                'string',
            ],
        ]);

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            Log::warning('Web login failed', [
                'email' => $request->input('email'),
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'time' => now()->toDateTimeString(),
            ]);

            return back()
                ->withErrors([
                    'email' => 'Email atau password tidak sesuai.',
                ])
                ->onlyInput('email');
        }

        $request->session()->regenerate();

        Log::info('Web login success', [
            'user_id' => $request->user()->id,
            'name' => $request->user()->name,
            'email' => $request->user()->email,
            'role' => $request->user()->role,
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'time' => now()->toDateTimeString(),
        ]);

        if ($request->user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('user.dashboard');
    }

    public function logout(Request $request): RedirectResponse
    {
        Log::info('Web logout', [
            'user_id' => $request->user()?->id,
            'email' => $request->user()?->email,
            'ip' => $request->ip(),
            'time' => now()->toDateTimeString(),
        ]);

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}