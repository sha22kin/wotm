<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\JoinSubmission;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    /**
     * Display the user profile and dashboard.
     */
    public function index()
    {
        $user = Auth::user();
        $settings = Setting::getAllGrouped();

        return view('user.profile', compact('user', 'settings'));
    }

    /**
     * Update user profile information.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:50',
            'current_password' => 'nullable|required_with:password',
            'password' => ['nullable', 'confirmed', Password::defaults()],
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ], [
            'name.required' => app()->getLocale() === 'en' ? 'Name is required.' : 'নাম আবশ্যক।',
            'current_password.required_with' => app()->getLocale() === 'en' ? 'Current password is required to change password.' : 'পাসওয়ার্ড পরিবর্তনের জন্য বর্তমান পাসওয়ার্ড দিতে হবে।',
            'password.confirmed' => app()->getLocale() === 'en' ? 'Password confirmation does not match.' : 'পাসওয়ার্ড নিশ্চিতকরণ মিলছে না।',
        ]);

        // Verify current password if changing password
        if (!empty($validated['current_password'])) {
            if (!Hash::check($validated['current_password'], $user->password)) {
                return back()->withErrors([
                    'current_password' => app()->getLocale() === 'en' ? 'The provided current password does not match.' : 'বর্তমান পাসওয়ার্ড সঠিক নয়।',
                ])->withInput();
            }
        }

        // Handle password update
        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }
        unset($validated['current_password']);

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('uploads/avatars', 'public');
            $validated['avatar'] = 'storage/' . $path;
        }

        $user->update($validated);

        return back()->with('success', app()->getLocale() === 'en' ? 'Profile updated successfully!' : 'প্রোফাইল সফলভাবে আপডেট করা হয়েছে!');
    }

    /**
     * Update only user avatar photo.
     */
    public function updateAvatar(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
        ], [
            'avatar.required' => app()->getLocale() === 'en' ? 'Please select an image file.' : 'একটি ছবি নির্বাচন করুন।',
            'avatar.image' => app()->getLocale() === 'en' ? 'Uploaded file must be an image.' : 'ফাইলটি ছবি হতে হবে।',
            'avatar.max' => app()->getLocale() === 'en' ? 'Maximum image size is 2MB.' : 'ছবির সাইজ সর্বোচ্চ ২ মেগাবাইট হতে পারবে।',
        ]);

        $path = $request->file('avatar')->store('uploads/avatars', 'public');
        Auth::user()->update([
            'avatar' => 'storage/' . $path,
        ]);

        return back()->with('success', app()->getLocale() === 'en' ? 'Profile picture updated!' : 'প্রোফাইল ছবি সফলভাবে পরিবর্তিত হয়েছে!');
    }
}
