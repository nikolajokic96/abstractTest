<?php

namespace App\Http\Controllers;

use App\Jobs\ZipFile;
use App\Services\FileService;
use Illuminate\Http\Request;

class FileController
{
    public const NO_FILE = '';

    /**
     * @var FileService
     */
    private FileService $fileService;

    /**
     * @param FileService $fileService
     */
    public function __construct(FileService $fileService)
    {
        $this->fileService = $fileService;
    }

    /**
     * Uploads file
     * @param Request $request
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

        $url = public_path() . '/storage/' . $path;
        $this->fileService->saveFile($url, $fileName);
        $zipFileJob = new ZipFile($fileName, $url, $this->fileService->getCurrentUser());
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
