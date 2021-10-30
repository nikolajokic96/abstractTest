<?php

namespace App\Services;

use App\Jobs\Webhook;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Utilities\JsonPayloadStrategy;
use Illuminate\Support\Facades\Http;

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
            'fileName' => $fileName,
            'delete' => 0,
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
     * Marks file as deleted
     * @param string $fileName
     */
    public function deleteFile(string $fileName)
    {
        $user = $this->getCurrentUser();
        $files = json_decode($user->files, true);
        $zipFiles = json_decode($user->zipFiles, true);
        $newFiles = [];
        $newZipFiles = [];
        foreach ($files as $key => $file) {
            if ($file['fileName'] === $fileName) {
                $file['delete'] = 1;
                $zipFiles[$key]['delete'] = 1;
            }

            $newFiles[] = $file;
            $newZipFiles[] = $zipFiles[$key];
        }

        $user->files = json_encode($newFiles);
        $user->zipFiles = json_encode($newZipFiles);
        $user->save();
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
