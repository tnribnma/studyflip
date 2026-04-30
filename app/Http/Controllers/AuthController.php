<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{    public function showRegister(){
        if (session()->has('user_id')) {
            return redirect()->route('dashboard');
        }
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'                  => 'required|string|max:100',
            'email'                 => 'required|email|max:150|unique:users,email',
            'password'              => 'required|min:6|confirmed',
            'password_confirmation' => 'required',
        ], [
            'name.required'      => 'Your name is required.',
            'email.required'     => 'Email address is required.',
            'email.unique'       => 'This email is already registered. Please login.',
            'password.required'  => 'Password is required.',
            'password.min'       => 'Password must be at least 6 characters.',
            'password.confirmed' => 'Passwords do not match.',
        ]);

        $user = User::create([
            'name'     => trim($request->name),
            'email'    => strtolower(trim($request->email)),
            'password' => Hash::make($request->password),
            'role'     => 'user',
        ]);

        session([
            'user_id'   => $user->id,
            'user_name' => $user->name,
            'user_role' => $user->role,
        ]);

        return redirect()->route('dashboard')->with('success', 'Welcome to StudyFlip, ' . $user->name .'!');
    }


    public function showLogin()
    {
        if (session()->has('user_id')) {
            return redirect()->route('dashboard');
        }
        return view('auth.login');
    }


    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ], [
            'email.required'    => 'Email address is required.',
            'email.email'       => 'Please enter a valid email address.',
            'password.required' => 'Password is required.',
        ]);

        $user = User::findByEmail(strtolower(trim($request->email)));

        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => 'Invalid email or password. Please try again.']);
        }

        session([
            'user_id'   => $user->id,
            'user_name' => $user->name,
            'user_role' => $user->role,
        ]);

        return redirect()->route('dashboard')->with('success', 'Welcome back, ' . $user->name . '!');
    }


    public function logout(Request $request)
    {
        session()->flush();
        return redirect()->route('login')->with('success', 'You have been logged out successfully.');
    }
}
