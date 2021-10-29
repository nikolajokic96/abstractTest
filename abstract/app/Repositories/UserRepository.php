<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

class UserRepository
{
    /**
     * @var string
     */
    private string $username;
    /**
     * @var string
     */
    private string $password;

    /**
     * Gets user by username/email and password
     * @param string $username
     * @param string $password
     * @return User|Builder|\Illuminate\Database\Eloquent\Model|object
     */
    public function getUser(string $username, string $password)
    {
        $this->username = $username;
        $this->password = $password;
        /** @var User $user $user */
        return User::query()->where('username', '=', $username)
            ->where('password', '=', $password)->orWhere(function ($query) {
                $query->where('email', '=', $this->username)
                    ->where('password', '=', $this->password);
            })->first();
    }

}
