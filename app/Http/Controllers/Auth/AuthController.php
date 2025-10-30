<?php

namespace App\Http\Controllers\Auth;

// [FIX] Import ApiController dan ServiceResponse
use App\Http\Controllers\Response\ApiController;
use App\Helpers\ServiceResponse;

use Illuminate\Http\Request;
use Exception;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\QueryException;
use App\Services\Contracts\AuthInterface;

/**
 * @group Autentikasi
 *
 * API untuk registrasi, login, dan update akun pengguna.
 */
class AuthController extends ApiController
{
    protected $authService;

    public function __construct(AuthInterface $authService)
    {
        $this->authService = $authService;
    }


    /**
     * Login User
     *
     * Mengotentikasi pengguna berdasarkan email dan password,
     * lalu mengembalikan JWT (Bearer Token) jika berhasil.
     *
     * @bodyParam email string required Alamat email pengguna. Example: admin@example.com
     * @bodyParam password string required Kata sandi pengguna. Example: 12345678
     *
     * @response 200 {
     *     "success": true,
     *     "data": {
     *         "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9...",
     *         "token_type": "Bearer",
     *         "expires_in": 3600
     *     },
     *     "message": "Login berhasil"
     * }
     * @response 401 {
     *     "success": false,
     *     "message": "Unauthorized. Email atau password salah."
     * }
     * @response 422 {
     *     "success": false,
     *     "message": "Data validasi tidak valid.",
     *     "errors": {
     *         "email": [
     *             "The email field is required."
     *         ]
     *     }
     * }
     * @response 500 {
     *     "success": false,
     *     "message": "Gagal membuat token."
     * }
     */
    public function login(Request $request)
    {
        try {
            $credentials = $request->validate([ // Validasi bisa melempar exception
                'email' => 'required',
                'password' => 'required',
            ]);

            // [FIX] Panggil service, yang akan mengembalikan ServiceResponse
            $result = $this->authService->login($request);

            // [FIX] Gunakan sendResponse dari ApiController
            return $this->sendResponse($result);

        } catch (ValidationException $e) {
            // [FIX] Gunakan ServiceResponse dan sendResponse untuk error
            $errorResponse = ServiceResponse::error('Data validasi tidak valid.', 422, $e->errors());
            return $this->sendResponse($errorResponse);

        } catch (JWTException $e) {
            $errorResponse = ServiceResponse::error('Gagal membuat token.', 500);
            return $this->sendResponse($errorResponse);

        } catch (Exception $e) {
            $errorResponse = ServiceResponse::error('Terjadi kesalahan: ' . $e->getMessage(), 500);
            return $this->sendResponse($errorResponse);
        }
    }

    /**
     * Registrasi User
     *
     * ... (docblock) ...
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
        // [NOTE] Handler.php akan menangani ValidationException secara otomatis
        $validated = $request->validate([
            'name' => 'required|max:50|min:1',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8'
        ]);

        // [FIX] Gunakan sendResponse
        return $this->sendResponse(
            $this->authService->register($validated)
        );
    }

    /**
     * Update Akun User Pribadi
     *
     * ... (docblock) ...
     *
     * @response 200 {
     * "success": true,
     * "message": "Akun berhasil diperbarui",
     * "data": { ... }
     * }
     * @response 403 {
     * "success": false,
     * "message": "Akses Ditolak (Forbidden). Anda hanya dapat memperbarui akun Anda sendiri."
     * }
     */
    public function updateAkun(Request $request)
    {
        // [NOTE] Handler.php akan menangani ValidationException secara otomatis

        $targetUserId = $request->route('user');
        $authenticatedUser = $request->user();

        if ($authenticatedUser->id != $targetUserId) {
            return $this->sendResponse(
                ServiceResponse::error('Akses Ditolak (Forbidden). Anda hanya dapat memperbarui akun Anda sendiri.', 403)
            );
        }

        $validated = $request->validate([
            'name' => 'sometimes|string|max:50|min:1',
            'email' => 'sometimes|email|unique:users,email,' . $authenticatedUser->id,
            'password' => 'sometimes|string|min:8'
        ]);

        // [FIX] Gunakan sendResponse
        return $this->sendResponse(
            $this->authService->updateAkun($request, $validated)
        );
    }
}
