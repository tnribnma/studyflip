<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\StudySession;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function show(){
        $user = User::findOrFail(session('user_id'));

        $totalDecks    = $user->decks()->count();
        $totalSessions = StudySession::where('user_id', $user->id)->count();

        return view('profile.show', compact('user', 'totalDecks', 'totalSessions'));
    }
    public function update(Request $request){
        $userId = session('user_id');

        $request->validate([
            'name'  => 'required|string|max:100',
            'email' => 'required|email|max:150|unique:users,email,' . $userId,
        ], [
            'name.required'  => 'Your name is required.',
            'email.required' => 'Email address is required.',
            'email.unique'   => 'This email is already used by another account.',
        ]);

        $user = User::findOrFail($userId);
        $user->update([
            'name'  => trim($request->name),
            'email' => strtolower(trim($request->email)),
        ]);
        session(['user_name' => $user->name]);

        return back()->with('success', 'Profile updated successfully!');
    }

    public function changePassword(Request $request){
        $request->validate([
            'current_password'      => 'required',
            'password'              => 'required|min:6|confirmed',
            'password_confirmation' => 'required',
        ], [
            'current_password.required' => 'Current password is required.',
            'password.required'         => 'New password is required.',
            'password.min'              => 'New password must be at least 6 characters.',
            'password.confirmed'        => 'New passwords do not match.',
        ]);

        $user = User::findOrFail(session('user_id'));

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        $user->update(['password' => Hash::make($request->password)]);

        return back()->with('success', 'Password changed successfully!');
    }
}
