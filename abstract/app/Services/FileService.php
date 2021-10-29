<?php

namespace App\Services;

use App\Jobs\Webhook;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Utilities\JsonPayloadStrategy;

class FileService
{
    public const JSON_PAYLOAD = 'json';

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
     * Sends Webhooks to all endpoints
     * @param string $filePath
     */
    public function sendWebhooks(string $filePath)
    {
        $payloadStrategy = config('services.payloadType');
        if ($payloadStrategy !== self::JSON_PAYLOAD) {
            return;
        }

        $strategy = new RequestPayloadService(new JsonPayloadStrategy());
        $payload = $strategy->createPayload($filePath);

        $webhooksJob = new Webhook($payload);
        dispatch($webhooksJob);

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
