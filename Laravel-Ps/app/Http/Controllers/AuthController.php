<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request) {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        if(Auth::attempt($credentials)) {
            $user = Auth::user();
            // dd($user);
            $token = $user->createToken('Personal Access Token')->plainTextToken;

            // Kirim token sebagai respons JSON API
            return response()->json([
                'token' => $token,
                // 'token' => 'ini token yaaaa',
                'message' => 'Berhasil Login!'
            ], 200);
        }else {
            return response()->json([
                'error' => 'Email atau Password salah!'
            ], 401);
        }
    }

    public function logout(Request $request) {
        // dd($request->user());
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Succesfully  Logout!'
        ]);
    }
}
