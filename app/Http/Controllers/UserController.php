<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display the student dashboard.
     */
    public function dashboard()
    {
        return view('user.dashboard');
    }

    /**
     * Display the student submissions page.
     */
    public function submissions()
    {
        return view('user.submissions');
    }

    /**
     * Display the student achievements page.
     */
    public function achievements()
    {
        return view('user.achievements');
    }

    /**
     * Display the student track records page.
     */
    public function trackRecords()
    {
        return view('user.track-records');
    }

    /**
     * Display the student profile update page.
     */
    public function profile()
    {
        return view('user.profile', [
            'user' => Auth::user()
        ]);
    }
}
