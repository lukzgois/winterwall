<?php

namespace App\Domain\Auth;

use Illuminate\Database\Eloquent\Model;

class PasswordReset extends Model
{
    /**
     * Fillable fields for this model.
     *
     * @var array
     */
    protected $fillable = [
        'email',
        'token'
    ];
}