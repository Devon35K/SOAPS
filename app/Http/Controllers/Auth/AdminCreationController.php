<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class AdminCreationController extends Controller
{
    public function show()
    {
        $superAdminCount = User::where('role', 'super_admin')->count();
        return view('auth.create-admin', compact('superAdminCount'));
    }

    public function store(Request $request)
    {
        $superAdminCount = User::where('role', 'super_admin')->count();

        $request->validate([
            'student_id' => ['required', 'string', 'max:255', 'unique:users'],
            'full_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'role' => ['required', 'in:admin,super_admin'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        if ($request->role === 'super_admin' && $superAdminCount >= 3) {
            return back()->withErrors(['role' => 'The maximum limit of 3 Super Admins has been reached.'])->withInput();
        }

        $user = User::create([
            'student_id' => $request->student_id,
            'full_name' => $request->full_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'approved' => true,
            'status' => 'undergraduate', // Fallback to allowed enum value
        ]);

        $roleDisplay = $request->role === 'super_admin' ? 'Super Admin' : 'Admin';
        return redirect()->route('login')->with('success', "{$roleDisplay} account created successfully! You can now login.");
    }
}
