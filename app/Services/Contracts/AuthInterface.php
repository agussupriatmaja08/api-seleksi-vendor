<?php

namespace App\Services\Contracts;
use Illuminate\Http\Request;
use App\Models\User;



interface AuthInterface
{
    public function login(Request $request);
    public function register($data);
    public function updateAkun($data, User $user);
}