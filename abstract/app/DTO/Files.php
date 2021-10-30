<?php

namespace App\DTO;

class Files
{
    /**
     * @var array
     */
    private array $file;
    /**
     * @var array
     */
    private array $zipFile;

    /**
     * @param array $file
     * @param array $zipFile
     */
    public function __construct(array $file, array $zipFile)
    {
        $this->file = $file;
        $this->zipFile = $zipFile;
    }

    /**
     * @return array
     */
    public function getFile(): array
    {
        return $this->file;
    }

    /**
     * @return array
     */
    public function getZipFile(): array
    {
        return $this->zipFile;
    }
}
