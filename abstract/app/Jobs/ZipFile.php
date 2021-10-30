<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use ZipArchive;

class ZipFile implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var string
     */
    private string $fileName;
    /**
     * @var string
     */
    private string $filePath;
    /**
     * @var User
     */
    private User $currentUser;

    /**
     * @param string $fileName
     * @param string $filePath
     * @param User $currentUser
     */
    public function __construct(string $fileName, string $filePath, User $currentUser)
    {
        $this->fileName = $fileName;
        $this->filePath = $filePath;
        $this->currentUser = $currentUser;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $zip = new ZipArchive();
        $zipPath = public_path() . '/zip/' . $this->fileName . '.zip';
        if ($zip->open($zipPath, ZipArchive::CREATE) === true) {
            $zip->addFile($this->filePath);
            $zip->close();
        };

        $zipArray = [
            'path' => $zipPath,
            'fileName' => $this->fileName,
            'delete' => 0,
        ];

        $this->saveZipFile($zipArray);
    }

    /**
     * Updates users zip files
     *
     * @param array $zipFile
     */
    private function saveZipFile(array $zipFile): void
    {
        if ($this->currentUser->zipFiles) {
            $zipFiles = json_decode($this->currentUser->zipFiles, true);
            array_push($zipFiles, $zipFile);
        } else {
            $zipFiles = array($zipFile);
        }

        $this->currentUser->zipFiles = json_encode($zipFiles);
        $this->currentUser->save();
    }
}
