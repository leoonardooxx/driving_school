<?php

namespace App\Http\Controllers;

use App\Http\Requests\Profile\UpdatePasswordRequest;
use App\Http\Requests\Profile\UpdateProfileRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Show the logged-in user's profile.
     */
    public function index(Request $request)
    {
        return view('profile.index', ['user' => $request->user()]);
    }

    /**
     * Update the logged-in user's personal information and/or profile picture.
     */
    public function update(UpdateProfileRequest $request)
    {
        $user = $request->user();
        $data = $request->validated();

        if ($request->hasFile('image')) {
            if ($user->image) {
                Storage::disk('public')->delete($user->image);
            }
            $data['image'] = $request->file('image')->store('users', 'public');
        }

        $user->update($data);

        return redirect()->route('profile.index')->with('status', 'profile-updated');
    }

    /**
     * Change the logged-in user's password.
     */
    public function updatePassword(UpdatePasswordRequest $request)
    {
        $request->user()->update(['password' => $request->validated('password')]);

        return redirect()->route('profile.index')->with('status', 'password-updated');
    }
}
