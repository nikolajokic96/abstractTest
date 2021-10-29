<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\UserRepository;
use Exception;

class LoginService
{
    /**
     * @var UserRepository
     */
    private UserRepository $userRepository;

    /**
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @throws Exception
     */
    public function login(string $username, string $password): User
    {
        $user = $this->userRepository->getUser($username, $password);
        if (!$user) {
            throw new Exception(__('labels.noSuchUser'), 404);
        }

        return $user;
    }
}
