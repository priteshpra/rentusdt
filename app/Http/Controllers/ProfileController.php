<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfileRequest;
use App\Models\ReturnHistory;
use App\Services\UserService; // optional
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Auth;

class ProfileController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService = null)
    {
        $this->userService = $userService;
    }

    // Show profile (read-only)
    public function show()
    {
        $today = date('Y-m-d');
        $user = auth()->user();
        $totalReturn = ReturnHistory::where('user_id', $user['id'])->sum('monthly_return');
        $todaysReturn = ReturnHistory::where('user_id', $user['id'])->whereDate('processed_at', $today)->sum('daily_return');
        return view('rentus.profile', compact('user', 'totalReturn', 'todaysReturn'));
    }

    // Edit profile (form)
    public function edit()
    {
        $user = auth()->user();
        return view('rentus.profile.edit', compact('user'));
    }

    // Update profile
    public function update(UpdateProfileRequest $request)
    {
        $user = auth()->user();

        $data = $request->only(['name', 'email', 'contact', 'wallet_address']);

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        // handle avatar upload
        if ($request->hasFile('avatar')) {
            // delete old avatar if exists
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }

            $file = $request->file('avatar');
            $path = $file->store('avatars', 'public'); // stores in storage/app/public/avatars
            $data['avatar'] = $path;
        }

        if ($this->userService) {
            $this->userService->update($user->id, $data);
        } else {
            $user->update($data);
        }

        return redirect()->route('profile')->with('success', 'Profile updated successfully.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6',
            'confirm_password' => 'required|same:new_password',
        ]);

        $user = auth()->user();

        // current password check
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->with('error', 'Current password is incorrect');
        }

        // update new password
        $user->password = Hash::make($request->new_password);
        $user->save();

        return back()->with('success', 'Password updated successfully');
    }
}
