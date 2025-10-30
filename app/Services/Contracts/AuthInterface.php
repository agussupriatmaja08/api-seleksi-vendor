<?php

namespace App\Services\Contracts;
use Illuminate\Http\Request;


interface AuthInterface
{
    public function login(Request $request);
    public function register(array $validated);
    public function updateAkun(Request $request, array $validated);
}