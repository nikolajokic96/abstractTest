<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\UserRepository;

class FileService
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
     * Saves file to database
     *
     * @param string $path
     * @param string $fileName
     */
    public function saveFile(string $path, string $fileName)
    {
        $fileArray = [
            'path' => $path,
            'fileName' => $fileName
        ];

        $this->userRepository->saveUsersFiles($fileArray);
    }

    /**
     * Gets current user
     *
     * @return User|null
     */
    public function getCurrentUser(): ?User
    {
        return $this->userRepository->getCurrentUser();
    }
}
