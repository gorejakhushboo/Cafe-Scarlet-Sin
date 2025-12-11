<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        // validate input
        $request->validate([
            'com' => 'required|string|max:255',
            'drink' => 'required|string|max:100',
        ]);

        // insert into database
        DB::table('comments')->insert([
            'com' => $request->input('com'),
            'drink' => $request->input('drink'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // redirect back with success message
        return redirect()->back()->with('success', 'Your whisper has been shared with the Society.');
    }
}
