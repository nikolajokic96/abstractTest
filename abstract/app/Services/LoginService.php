<?php

namespace App\Services;

use App\DTO\Files;
use App\Http\Controllers\LoginController;
use App\Models\User;
use App\Repositories\UserRepository;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

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

    /**
     * Loads dashboard page
     * @param User $user
     * @return Application|Factory|View
     */
    public function loadDashboardPage(User $user)
    {
        $filesArray = $this->renderFileViewData($user);
        return \view(LoginController::DASHBOARD, ['files' => $filesArray]);
    }

    /**
     * Renders users files for view
     * @param User $user
     * @return array
     */
    private function renderFileViewData(User $user): array
    {
        if (!$user->files) {
            return [];
        }

        $files = json_decode($user->files, true);
        $zipFiles = json_decode($user->zipFiles, true);
        $allFiles = [];
        foreach ($files as $key => $file) {
            if ($file['delete'] !== 1) {
                $fileObject = new Files($file, $zipFiles[$key]);
                $allFiles[$key] = $fileObject;
            }
        }

        return $allFiles;
    }
}
