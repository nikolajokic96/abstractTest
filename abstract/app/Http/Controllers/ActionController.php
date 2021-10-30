<?php

namespace App\Http\Controllers;

use App\Services\FileService;
use App\Services\LoginService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ActionController
{
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
     * Downloads zip file
     * @param Request $request
     * @return BinaryFileResponse
     */
    public function downloadFile(Request $request): BinaryFileResponse
    {
        return response()->download($request->get('filePath'));
    }

    /**
     * Deletes file
     * @param Request $request
     * @return Application|Factory|View
     */
    public function deleteFile(Request $request)
    {
        $this->fileService->deleteFile($request->get('fileName'));
        $user = $this->fileService->getCurrentUser();

        return $this->loginService->loadDashboardPage($user);
    }
}
