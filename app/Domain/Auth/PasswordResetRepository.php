<?php

namespace App\Domain\Auth;

use App\Domain\Repository\CrudRepository;
use App\Domain\Users\User;

class PasswordResetRepository extends CrudRepository
{
    /**
     * Model class for this repository
     * @var PasswordReset
     */
    protected $modelClass = PasswordReset::class;

    /**
     * Generate a new reset token for the user.
     *
     * @param  User   $user
     * @return PasswordReset
     */
    public function generateResetToken(User $user) : PasswordReset
    {
        $token = md5(time() . str_random(10));

        return $this->create([
            'email' => $user->email,
            'token' => $token
        ]);
    }
}
