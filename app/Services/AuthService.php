<?php


namespace App\Services;
use App\Services\Contracts\AuthInterface;
use Illuminate\Http\Request;
use App\Helpers\ServiceResponse;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Models\User;
use Illuminate\Support\Facades\Hash;



class AuthService implements AuthInterface
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');


        if (!$token = JWTAuth::attempt($credentials)) {
            return ServiceResponse::error('Unauthorized. Email atau password salah.', 401);
            // return response()->json($error);
        }
        $data = [
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => JWTAuth::factory()->getTTL() * 60
        ];
        return ServiceResponse::success($data, 'Login berhasil', 200);


    }
    public function register(array $validated)
    {
        $userData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password'])
        ];

        User::create($userData);
        return ServiceResponse::success(null, 'User berhasil dibuat', 201);

    }
    public function updateAkun(Request $request, array $validated)
    {

        $user = $request->user();

        if ($request->filled('password')) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $isSuccess = $user->update($validated);

        if ($isSuccess) {
            return ServiceResponse::success(null, 'Berhasil diperbaharui', 200);
        } else {
            return ServiceResponse::error('Gagal diperbaharui', 404);
        }

    }

}