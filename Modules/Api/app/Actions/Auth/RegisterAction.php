<?php

namespace Modules\Api\Actions\Auth;

use Illuminate\Support\Facades\Hash;
use Modules\Api\Models\User;

class RegisterAction
{
    /**
     * Execute the registration action.
     *
     * @param array $data Validated registration data
     * @return array{user: User, token: string}
     */
    public function execute(array $data): array
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'phone' => $data['phone'] ?? null,
            'is_active' => true,
        ]);

        $token = $user->createToken('auth-token')->plainTextToken;

        return [
            'user' => $user,
            'token' => $token,
        ];
    }
}