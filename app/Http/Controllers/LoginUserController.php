<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LoginUserController extends Controller
{
    public function index(): View
    {
        return view('pages.auth.login', [
            'title' => 'Login',
        ]);
    }

    public function login(LoginUserRequest $request)
    {
        if (Auth::guard('web')->attempt(['email' => $request->email, 'password' => $request->password])) {
            $request->session()->regenerate();

            // Redirect based on role
            if (Auth::user()->role == '0') {
                return redirect()->intended(route('inventory.dashboard'));
            }
            return redirect()->intended(route('pos.index'));
        }

        return back()->withErrors([
            'email' => 'Email atau password salah',
            'password' => 'Email atau password salah',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return to_route('login');
    }
}
