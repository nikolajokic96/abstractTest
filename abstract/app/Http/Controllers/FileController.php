<?php

namespace App\Http\Controllers;

use App\Jobs\ZipFile;
use App\Services\FileService;
use App\Services\LoginService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class FileController
{
    public const NO_FILE = '';

    /**
     * @var FileService
     */
    private FileService $fileService;
    /**
     * @var LoginService
     */
    private LoginService $loginService;

    /**
     * @param FileService $fileService
     * @param LoginService $loginService
     */
    public function __construct(FileService $fileService, LoginService $loginService)
    {
        $this->fileService = $fileService;
        $this->loginService = $loginService;
    }

    /**
     * Uploads file
     * @param Request $request
     * @return Application|Factory|View
     */
    public function uploadFile(Request $request)
    {
        $file = $request->file('file');
        $fileName = $file->getClientOriginalName();
        if ($this->hasFileName($request)) {
            $fileName = $request->get('fileName');
        }

        $path = $request->file('file')->storePubliclyAs(
            $file->getBasename(),
            $fileName,
            ['disk' => 'public']
        );

        $currentUser = $this->fileService->getCurrentUser();
        $url = public_path() . '/storage/' . $path;
        $this->fileService->saveFile($url, $fileName);
        $zipFileJob = new ZipFile($fileName, $url, $currentUser);
        dispatch($zipFileJob);
        $this->fileService->sendWebhooks($url);
    }

    /**
     * Checks if user has defined file name
     * @param Request $request
     * @return bool
     */
    private function hasFileName(Request $request): bool
    {
        $fileName = $request->get('fileName');

        return $fileName !== self::NO_FILE && $fileName;
    }
}
