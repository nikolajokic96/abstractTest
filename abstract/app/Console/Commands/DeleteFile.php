<?php

namespace App\Console\Commands;

use App\Services\FileService;
use Illuminate\Console\Command;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Facades\File;
use Symfony\Component\Console\Command\Command as CommandAlias;

class DeleteFile extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'work:delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deletes files every day';

    /**
     * @var FileService
     */
    private FileService $fileService;

    /**
     * Create a new command instance.
     *
     * @return void
     * @throws BindingResolutionException
     */
    public function __construct()
    {
        parent::__construct();
        $this->fileService = app()->make(FileService::class);
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $user = $this->fileService->getCurrentUser();
        $files = json_decode($user->files, true);
        $zipFiles = json_decode($user->zipFiles, true);

        foreach ($files as $key => $file) {
            if ($file['delete'] === 1) {
                File::delete($file['path']);
                File::delete($zipFiles[$key]['path']);
                unset($files[$key]);
                unset($zipFiles[$key]);
            }
        }

        $user->files = json_encode($files);
        $user->zipFiles = json_encode($zipFiles);
        $user->save();

        return CommandAlias::SUCCESS;
    }
}
