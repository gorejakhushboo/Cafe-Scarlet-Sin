<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminCheckController extends Controller
{
    // Show login page
    public function index()
    {
        return view('admincheck');
    }

    // Handle login form
    public function login(Request $request)
    {
        $username = $request->username;
        $password = $request->password;

        // Hardcoded login
        if ($username === "admin" && $password === "khushboo") {
            return redirect()->route('admin.products.index');
        }

        return redirect()->back()->with('error', 'Invalid username or password');
    }
}
