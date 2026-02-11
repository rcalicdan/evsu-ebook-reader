<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthService
{
    /**
     * Attempt to authenticate a user
     *
     * @param string $email
     * @param string $password
     * @param bool $remember
     * @return User
     * @throws ValidationException
     */
    public function login(string $email, string $password, bool $remember = false): User
    {
        $user = User::where('email', $email)->first();

        if (!$user || !Hash::check($password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        Auth::login($user, $remember);

        return $user;
    }

    /**
     * Log the user out
     *
     * @return void
     */
    public function logout(): void
    {
        Auth::logout();
        
        request()->session()->invalidate();
        request()->session()->regenerateToken();
    }
}