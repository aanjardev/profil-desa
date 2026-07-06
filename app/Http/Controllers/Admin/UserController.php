<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\PendingRegistration;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the users and pending emails.
     */
    public function index(Request $request)
    {
        $activeTab = $request->get('tab', 'users'); // 'users' or 'pending'
        
        $users = User::orderBy('name', 'asc')->paginate(10, ['*'], 'users_page')->withQueryString();
        $pendingEmails = PendingRegistration::orderBy('created_at', 'desc')->paginate(10, ['*'], 'pending_page')->withQueryString();

        return view('admin.users.index', compact('users', 'pendingEmails', 'activeTab'));
    }

    /**
     * Store a newly created pending email.
     */
    public function storeEmail(Request $request)
    {
        $request->validate([
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email'),
                Rule::unique('pending_registrations', 'email'),
            ],
        ], [
            'email.unique' => 'Email ini sudah terdaftar di sistem atau sedang dalam status pending.',
        ]);

        PendingRegistration::create([
            'email' => $request->email,
            'status' => 'pending',
        ]);

        return redirect()->route('admin.users.index', ['tab' => 'pending'])
            ->with('success', 'Email berhasil didaftarkan. Pengguna kini dapat mendaftar menggunakan email ini.');
    }

    /**
     * Remove a pending email from storage.
     */
    public function destroyEmail(PendingRegistration $pendingRegistration)
    {
        $pendingRegistration->delete();
        
        return redirect()->route('admin.users.index', ['tab' => 'pending'])
            ->with('success', 'Email pending berhasil dihapus.');
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|string|in:admin,editor,user',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user->name = $validated['name'];
        $user->role = $validated['role'];
        
        if ($request->filled('password')) {
            $user->password = Hash::make($validated['password']);
        }
        
        $user->save();

        return redirect()->route('admin.users.index', ['tab' => 'users'])
            ->with('success', 'Data pengguna berhasil diperbarui.');
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy(User $user)
    {
        if (auth()->id() === $user->id) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        // Check if user is the last admin
        if ($user->role === 'admin' && User::where('role', 'admin')->count() <= 1) {
            return back()->with('error', 'Tidak dapat menghapus admin terakhir di sistem.');
        }

        $user->delete();

        // Also clean up pending_registrations if needed, though they would be marked 'registered' already
        PendingRegistration::where('email', $user->email)->delete();

        return redirect()->route('admin.users.index', ['tab' => 'users'])
            ->with('success', 'Pengguna berhasil dihapus.');
    }
}
