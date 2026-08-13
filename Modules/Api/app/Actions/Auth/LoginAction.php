<?php

namespace Modules\Api\Actions\Auth;

use Illuminate\Support\Facades\Hash;
use Modules\Api\Models\User;

class LoginAction
{
    /**
     * Execute the login action.
     *
     * @param array $data Validated login data
     * @return array{user: User, token: string}|null
     */
    public function execute(array $data): ?array
    {
        $user = User::where('email', $data['email'])->first();

        if (!$user || !Hash::check($data['password'], $user->password)) {
            return null;
        }

        if (!$user->is_active) {
            return null;
        }

        $token = $user->createToken('auth-token')->plainTextToken;

        return [
            'user' => $user,
            'token' => $token,
        ];
    }
}
