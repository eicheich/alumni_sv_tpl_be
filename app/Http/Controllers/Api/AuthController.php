<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Container\Attributes\DB;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function registerAdmin(Request $request) {
    //     $validated = $request->validate([
    //         'name' => 'required|string|max:255',
    //         'email' => 'required|string|email|max:255|unique:users',
    //         'password' => 'required|string|min:8|confirmed',
    //     ]);
    //     $user = DB::table('users')->create([
    //         'name' => $validated['name'],
    //         'email' => $validated['email'],
    //         'password' => bcrypt($validated['password']),
    //     ]);
    //     $user->assignRole('admin');
    //     return response()->json(['message' => 'Admin registered successfully'], 201);



    }
    public function login(Request $request)
    {
    }
    //
}
