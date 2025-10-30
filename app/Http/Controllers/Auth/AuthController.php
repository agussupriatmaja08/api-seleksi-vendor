<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\QueryException;
use App\Helpers\ServiceResponse;
use App\Services\Contracts\AuthInterface;

/**
 * @group Autentikasi
 *
 * API untuk registrasi, login, dan update akun pengguna.
 */
class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthInterface $authService)
    {
        $this->authService = $authService;
    }


    /**
     * Login Pengguna
     *
     * Mengotentikasi pengguna berdasarkan email dan password,
     * lalu mengembalikan JWT (Bearer Token) jika berhasil.
     *
     * @bodyParam email string required Alamat email pengguna. Example: admin@example.com
     * @bodyParam password string required Kata sandi pengguna. Example: 12345678
     *
     * @response 200 {
     * "success": true,
     * "data": {
     * "access_token": "ey...[jwt]...",
     * "token_type": "Bearer",
     * "expires_in": 3600
     * },
     * "message": "Login berhasil"
     * }
     * @response 401 {
     * "success": false,
     * "message": "Unauthorized. Email atau password salah."
     * }
     * @response 422 {
     * "success": false,
     * "message": "Data validasi tidak valid.",
     * "errors": {
     * "email": [
     * "The email field is required."
     * ]
     * }
     * }
     */
    public function login(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required',
                'password' => 'required',
            ]);
            $data = $this->authService->login($request);

            return response()->json($data);
        } catch (ValidationException $e) {
            return response()->json('Data validasi tidak valid.', 422, $e->errors());
        } catch (JWTException $e) {
            return response()->json('Gagal membuat token.', 500);
        } catch (Exception $e) {
            return response()->json('Terjadi kesalahan: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Registrasi Pengguna Baru
     *
     * Membuat akun pengguna baru.
     *
     * @bodyParam name string required Nama lengkap pengguna. Example: admin
     * @bodyParam email string required Alamat email pengguna (harus unik). Example: user@gmail.com
     * @bodyParam password string required Kata sandi (minimal 8 karakter). Example: 12345678
     *
     * @response 201 {
     * "success": true,
     * "message": "Berhasil terdaftar",
     * "data": null
     * }
     * @response 422 {
     * "success": false,
     * "message": "Data validasi tidak valid.",
     * "errors": {
     * "email": [
     * "The email has already been taken."
     * ]
     * }
     * }
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:50|min:1',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8'
        ]);
        $data = $this->authService->register($validated);

        return response()->json($data);


    }

    /**
     * Update Akun Pengguna (Profil Saya)
     *
     * Memperbarui nama, email, atau password pengguna yang sedang login.
     * Pengguna hanya dapat memperbarui data mereka sendiri (Otorisasi dicek).
     *
     * @authenticated
     * @urlParam user required ID dari pengguna yang akan di-update (harus ID sendiri). Example: 1
     * @bodyParam name string Nama baru pengguna (opsional). Example: John Smith
     * @bodyParam email string Email baru pengguna (opsional). Example: john.smith@example.com
     * @bodyParam password string Password baru (opsional, min 8 karakter). Example: newPassword123
     *
     * @response 200 {
     * "success": true,
     * "message": "Akun berhasil diperbarui",
     * "data": {
     * "id": 1,
     * "name": "John Smith",
     * "email": "john.smith@example.com",
     * "email_verified_at": null,
     * "created_at": "2025-10-30T06:00:00.000000Z",
     * "updated_at": "2025-10-30T06:30:00.000000Z"
     * }
     * }
     * @response 403 {
     * "success": false,
     * "message": "Akses Ditolak (Forbidden). Anda hanya dapat memperbarui akun Anda sendiri."
     * }
     * @response 422 {
     * "success": false,
     * "message": "Data validasi tidak valid.",
     * "errors": {
     * "password": [
     * "The password must be at least 8 characters."
     * ]
     * }
     * }
     */
    public function updateAkun(Request $request)
    {
        $targetUserId = $request->route('user');
        $authenticatedUser = $request->user();
        if ($authenticatedUser->id != $targetUserId) {
            $error = ServiceResponse::error('Akses Ditolak (Forbidden). Anda hanya dapat memperbarui akun Anda sendiri.');
            return response()->json($error, 403);
        }
        $validated = $request->validate([
            'name' => 'sometimes|string|max:50|min:1',
            'email' => 'sometimes|email|unique:users,email,' . $authenticatedUser->id,
            'password' => 'sometimes|string|min:8'
        ]);
        $data = $this->authService->updateAkun($request, $validated);

        return response()->json($data);
    }
}

