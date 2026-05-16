<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

class PasswordController extends Controller
{
    /**
     * Show the user's password settings page.
     */
    public function edit()
    {
        return view('settings.password');
    }

    /**
     * Update the user's password.
     */
    public function update(Request $request): RedirectResponse
    {
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'current_password' => ['required', 'string', 'current_password'],
            'password'         => ['required', 'string', Password::defaults(), 'confirmed'],
        ])->setAttributeNames([
            'current_password' => 'Current Password',
            'password'         => 'New Password',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator, 'updatePassword')
                ->withInput();
        }

        $request->user()->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('status', 'password-updated');
    }
}
