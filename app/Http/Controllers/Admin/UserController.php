<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::orderBy('id', 'desc');

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $s = '%' . trim($request->search) . '%';
            $query->where(function ($q) use ($s) {
                $q->where('name', 'like', $s)
                  ->orWhere('email', 'like', $s)
                  ->orWhere('phone', 'like', $s);
            });
        }

        $users = $query->paginate(15)->withQueryString();

        $roleCounts = [
            'all' => User::count(),
            'super_admin' => User::where('role', 'super_admin')->count(),
            'admin' => User::where('role', 'admin')->count(),
            'editor' => User::where('role', 'editor')->count(),
            'moderator' => User::where('role', 'moderator')->count(),
            'member' => User::where('role', 'member')->count(),
        ];

        return view('admin.users.index', compact('users', 'roleCounts'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'phone' => 'nullable|string|max:255',
            'role' => ['required', Rule::in(['super_admin', 'admin', 'editor', 'moderator', 'member'])],
            'status' => ['required', Rule::in(['active', 'inactive', 'banned'])],
            'password' => 'required|string|min:6',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg,gif|max:10240',
        ]);

        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('uploads/avatars', 'public');
            $validated['avatar'] = 'storage/' . $path;

            try {
                $destDir = public_path('storage/uploads/avatars');
                if (!file_exists($destDir)) {
                    @mkdir($destDir, 0755, true);
                }
                @copy(storage_path('app/public/' . $path), public_path('storage/' . $path));
            } catch (\Exception $e) {
                // Ignore fallback copy error
            }
        }

        $validated['password'] = Hash::make($validated['password']);
        $validated['is_admin'] = in_array($validated['role'], ['super_admin', 'admin']);

        User::create($validated);

        return redirect()->route('admin.users.index')->with('success', 'User created successfully.');
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone' => 'nullable|string|max:255',
            'role' => ['required', Rule::in(['super_admin', 'admin', 'editor', 'moderator', 'member'])],
            'status' => ['required', Rule::in(['active', 'inactive', 'banned'])],
            'password' => 'nullable|string|min:6',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg,gif|max:10240',
        ]);

        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('uploads/avatars', 'public');
            $validated['avatar'] = 'storage/' . $path;

            try {
                $destDir = public_path('storage/uploads/avatars');
                if (!file_exists($destDir)) {
                    @mkdir($destDir, 0755, true);
                }
                @copy(storage_path('app/public/' . $path), public_path('storage/' . $path));
            } catch (\Exception $e) {
                // Ignore fallback copy error
            }
        }

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $validated['is_admin'] = in_array($validated['role'], ['super_admin', 'admin']);

        $user->update($validated);

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        if (Auth::id() === $user->id) {
            return back()->with('error', 'You cannot delete your own account.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
    }
}
