<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /**
     * Simple demo login: accepts any non-empty credentials and sets session user.
     */
    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
            'role' => 'required|string'
        ]);

        // In a real app, validate against users table. Here we accept any demo user.
        $user = [
            'email' => $data['email'],
            'name' => explode('@', $data['email'])[0],
            'role' => $data['role']
        ];

        // Store minimal session user
        session(['user' => $user]);

        // Redirect based on role
        if ($user['role'] === 'customer') {
            return redirect()->route('customer.dashboard');
        }
        if ($user['role'] === 'production') {
            return redirect()->route('production.dashboard');
        }
        if ($user['role'] === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        // fallback
        return redirect()->route('home');
    }
}
