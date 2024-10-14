<?php

namespace App\Adapter\FileSystem;

interface FileServiceInterface
{
    public function exists(string $resourceName): bool;

    public function isDirectory(string $resourcePath): bool;

    public function makeDirectory(string $resourcePath, int $permission = 0755, bool $recursive = true): bool;

    public function getFileContent(string $resourcePath): string;

    public function putFileContent(string $resourcePath, string $content): bool;
}
