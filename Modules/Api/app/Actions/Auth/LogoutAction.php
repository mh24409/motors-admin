<?php

namespace Modules\Api\Actions\Auth;

use Modules\Api\Models\User;

class LogoutAction
{
    /**
     * Execute the logout action.
     * Revokes the current access token.
     */
    public function execute(User $user): void
    {
        $user->currentAccessToken()->delete();
    }
}
