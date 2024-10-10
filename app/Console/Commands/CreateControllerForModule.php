<?php

namespace App\Console\Commands;

use App\Console\shared\CustomPathTrait;
use Illuminate\Console\Command;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

class CreateControllerForModule extends Command
{
    use CustomPathTrait;

    protected $signature = 'make:module-controller {module} {controller} {--p|path= : Custom path}';
    protected $description = 'Create a controller for a module';
    protected Filesystem $files;
    private string $directoryPath = 'Http/Controllers';
    private string $stubPath = '/Console/Stubs/api_controller.stub';

    public function __construct(Filesystem $files)
    {
        parent::__construct();
        $this->files = $files;
    }

    /**
     * @throws FileNotFoundException
     */
    public function handle(): void
    {
        $moduleName = $this->getArgumentCapitalized($this->argument('module'));
        $customPath = $this->getCustomPath();
        $basePath = $this->getBasePath($customPath, $moduleName);
        $controllerName = $this->getArgumentCapitalized($this->argument('controller'));
        $controllerPath = $this->getControllerPath($basePath, $controllerName);

        $this->verifyIfControllerExists($controllerPath);

        $this->createDirectoryForController($basePath);
        $this->createController($controllerPath, $controllerName, $moduleName);

        $this->info("{$controllerName} created successfully for the module {$moduleName}");
    }

    private function getBasePath(string $customPath, string $moduleName): string
    {
        $path = $customPath ?? $this->directoryPath;
        return base_path("modules/{$moduleName}/{$path}");
    }

    private function getArgumentCapitalized(string $argument): string
    {
        return ucfirst($argument);
    }

    private function getControllerPath(string $basePath, string $controllerName): string
    {
        return "{$basePath}/{$controllerName}.php";
    }

    private function verifyIfControllerExists(string $controllerPath): void
    {
        if ($this->files->exists($controllerPath)) {
            $this->warn('The file already exists');
            throw new \RuntimeException('Controller already exists');
        }
    }

    private function createDirectoryForController(string $basePath): void
    {
        if (!$this->files->isDirectory($basePath)) {
            $this->files->makeDirectory($basePath, 0755, true);
        }
    }

    private function getStubPath(): string
    {
        return app_path($this->stubPath);
    }

    private function getStubContent(string $controllerName, string $moduleName): string
    {
        $stubContent = $this->files->get($this->getStubPath());
        $placeHolders = [
            '{{ controllerName }}' => $controllerName,
            '{{ moduleName }}' => $moduleName,
            '{{ namespace }}' => $this->getNameSpace(),
        ];

        return $this->replaceStubPlaceHolders($stubContent, $placeHolders);
    }

    private function replaceStubPlaceHolders(string $content, array $placeHolders): string
    {
        foreach ($placeHolders as $placeHolder => $value) {
            $content = str_replace($placeHolder, $value, $content);
        }
        return $content;
    }

    private function createController(string $controllerPath, string $controllerName, string $moduleName): void
    {
        $this->files->put($controllerPath, $this->getStubContent($controllerName, $moduleName));
    }
}
