<?php

namespace App\Console\shared;

use App\Adapter\FileSystem\FileSystemAdapter;
use Illuminate\Console\Command;
use Illuminate\Contracts\Filesystem\FileNotFoundException;

abstract class CommandFactory extends Command
{
    use CustomPathTrait;

    protected string $directoryPath;

    protected string $stubPath;

    protected array $placeHolders;

    protected string $moduleName;

    protected FileSystemAdapter $files;

    public function __construct(FileSystemAdapter $files)
    {
        parent::__construct();
        $this->files = $files;
    }

    public function handle(): void
    {
        $this->moduleName = $this->argument('module');
    }

    protected function setPlaceHolders($resourceName): void
    {
        $this->placeHolders = [
            '{{ resourceName }}' => $resourceName,
            '{{ moduleName }}' => $this->moduleName,
            '{{ namespace }}' => $this->getNameSpace(),
        ];
    }

    protected function getBasePath(?string $customPath): string
    {
        $path = $customPath ?? $this->directoryPath;

        return base_path("modules/{$this->moduleName}/{$path}");
    }

    protected function capitalize(string $argument): string
    {
        return ucfirst($argument);
    }

    protected function getResourcePath(string $basePath, string $resourceName): string
    {
        return "{$basePath}/{$resourceName}.php";
    }

    protected function verifyIfResourceExists(string $resourcePath, string $message): void
    {
        if ($this->files->exists($resourcePath)) {
            throw new \RuntimeException($message);
        }
    }

    protected function createDirectoryForResource(string $basePath): void
    {
        if (! $this->files->isDirectory($basePath)) {
            $this->files->makeDirectory($basePath, 0755, true);
        }
    }

    protected function getStubPath(): string
    {
        return app_path($this->stubPath);
    }

    /**
     * @throws FileNotFoundException
     */
    protected function getStubContent(): string
    {
        $stubContent = $this->files->getFileContent($this->getStubPath());

        return $this->replaceStubPlaceHolders($stubContent, $this->placeHolders);
    }

    protected function replaceStubPlaceHolders(string $content, array $placeHolders): string
    {
        foreach ($placeHolders as $placeHolder => $value) {
            $content = str_replace($placeHolder, $value, $content);
        }

        return $content;
    }

    /**
     * @throws FileNotFoundException
     */
    protected function createResource(string $resourcePath): void
    {
        $this->files->putFileContent($resourcePath, $this->getStubContent());
    }
}
