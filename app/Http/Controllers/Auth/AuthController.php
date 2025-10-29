<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    //

    public function login(Request $request)
    {
        $request->validate(
            [
                'email' => 'required',
                'password' => 'required',
            ]

        );
        $credentials = $request->only('email', 'password');

        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => JWTAuth::factory()->getTTL() * 60
        ]);
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:50|min:1',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8'
        ]);
        $user = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ];

        $user = User::create($user);
        if ($user) {
            return response()->json([
                'success' => true,
                'message' => 'Berhasi terdaftar',
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'Gagal mendaftar',
        ], 500);
    }


    public function updateAkun(Request $request)
    {

        $targetUserId = $request->route('user');
        $authenticatedUser = $request->user();
        if ($authenticatedUser->id != $targetUserId) {
            return response()->json([
                'success' => false,
                'message' => 'Akses Ditolak (Forbidden). Anda hanya dapat memperbarui akun Anda sendiri.',
            ], 403);
        }


        $user = $authenticatedUser;

        $validated = $request->validate([
            'name' => 'sometimes|string|max:50|min:1',
            'email' => 'sometimes|email|unique:users,email,' . $user->id,
            'password' => 'sometimes|string|min:8'
        ]);

        if ($request->filled('password')) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $isSuccess = $user->update($validated);

        if ($isSuccess) {
            return response()->json([
                'success' => true,
                'message' => 'Akun berhasil diperbarui',
                'data' => $user->fresh()
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'Gagal memperbarui akun',
        ], 400);
    }
}
