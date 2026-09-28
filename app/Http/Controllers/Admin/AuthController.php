<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (
            Auth::check() &&
            Auth::user()->role === 'admin' &&
            Auth::user()->is_active
        ) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.auth.login');
    }


    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => [
                'required',
                'email',
                'max:255',
            ],

            'password' => [
                'required',
                'string',
            ],
        ]);


        $key =
            strtolower($credentials['email'])
            .'|'
            .$request->ip();


        if (
            RateLimiter::tooManyAttempts(
                $key,
                5
            )
        ) {

            $seconds =
                RateLimiter::availableIn($key);

            return back()
                ->withErrors([
                    'email' =>
                        "Too many login attempts. Try again in {$seconds} seconds.",
                ])
                ->onlyInput('email');
        }


        if (
            !Auth::attempt(
                $credentials,
                $request->boolean('remember')
            )
        ) {

            RateLimiter::hit(
                $key,
                60
            );

            return back()
                ->withErrors([
                    'email' =>
                        'Invalid email or password.',
                ])
                ->onlyInput('email');
        }


        $user = $request->user();


        if (
            !$user->is_active ||
            $user->role !== 'admin'
        ) {

            Auth::logout();

            $request->session()->invalidate();

            $request->session()->regenerateToken();


            return back()
                ->withErrors([
                    'email' =>
                        'You do not have administrator access.',
                ])
                ->onlyInput('email');
        }


        RateLimiter::clear($key);

        $request->session()->regenerate();


        return redirect()
            ->intended(
                route('admin.dashboard')
            );
    }


    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();


        return redirect()
            ->route('admin.login');
    }
}
