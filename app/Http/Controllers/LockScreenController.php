<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LockScreenController extends Controller
{
    public function show()
    {
        // Store the intended URL before locking
        if (!Session::has('lock_screen_url')) {
            Session::put('lock_screen_url', url()->previous());
        }

        $user = Auth::user();
        return view('auth.lock-screen', compact('user'));
    }

    public function unlock(Request $request)
    {
        $request->validate([
            'password' => ['required', 'string'],
        ]);

        $credentials = [
            'email' => Auth::user()->email,
            'password' => $request->password,
        ];

        if (Auth::attempt($credentials)) {
            $intendedUrl = Session::get('lock_screen_url', route('dashboard'));
            Session::forget('lock_screen_url');
            
            return redirect($intendedUrl)->with('success', 'Screen unlocked successfully!');
        }

        return back()->withErrors([
            'password' => 'The provided password is incorrect.',
        ]);
    }
}

