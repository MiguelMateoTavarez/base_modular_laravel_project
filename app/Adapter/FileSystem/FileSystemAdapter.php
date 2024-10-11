<?php

namespace App\Adapter\FileSystem;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Filesystem\Filesystem;

class FileSystemAdapter implements FileServiceInterface
{
    private Filesystem $files;

    public function __construct(Filesystem $files)
    {
        $this->files = $files;
    }

    public function exists(string $resourceName): bool
    {
        return $this->files->exists($resourceName);
    }

    public function isDirectory(string $resourcePath): bool
    {
        return $this->files->isDirectory($resourcePath);
    }

    public function makeDirectory(string $resourcePath, int $permission = 0755, bool $recursive = true): bool
    {
        return $this->files->makeDirectory($resourcePath, $permission, $recursive);
    }

    /**
     * @throws FileNotFoundException
     */
    public function getFileContent(string $resourcePath): string
    {
        return $this->files->get($resourcePath);
    }

    public function putFileContent(string $resourcePath, string $content): bool
    {
        return $this->files->put($resourcePath, $content);
    }
}
