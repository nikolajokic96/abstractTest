<?php

namespace App\Repositories;

use App\Http\Controllers\LoginController;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

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
     * @return User|Builder|Model|object
     */
    public function getUser(string $username, string $password): ?User
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

    /**
     * Gets current user
     *
     * @return Builder|Model|object|null
     */
    public function getCurrentUser(): ?User
    {
        return User::query()->where('username', '=', session(LoginController::CURRENT_USER))->first();
    }

    /**
     * Saves given file name and path to database
     *
     * @param array $userFile
     */
    public function saveUsersFiles(array $userFile): void
    {
        /** @var User $user */
        $user = $this->getCurrentUser();
        if ($user->files) {
            $files = json_decode($user->files, true);
            array_push($files, $userFile);
        } else {
            $files = array($userFile);
        }

        $user->files = json_encode($files);
        $user->save();
    }

}
