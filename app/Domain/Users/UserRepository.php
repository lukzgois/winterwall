<?php

namespace App\Domain\Users;

use Hash;
use App\Domain\Repository\CrudRepository;

class UserRepository extends CrudRepository
{
    protected $modelClass = User::class;
}