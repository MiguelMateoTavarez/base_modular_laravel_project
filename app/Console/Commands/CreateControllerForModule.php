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
        $this->createDirectoryIfNotExists($basePath);

        $this->updateControllerText($controllerPath, $controllerName, $moduleName);

        $this->info("{$controllerName} created successfully for the module {$moduleName}");
    }

    private function getBasePath($customPath, $moduleName)
    {
        return is_null($customPath)
            ? base_path('modules' . DIRECTORY_SEPARATOR . $moduleName . DIRECTORY_SEPARATOR . $this->directoryPath)
            : base_path('modules' . DIRECTORY_SEPARATOR . $moduleName . DIRECTORY_SEPARATOR . $customPath);
    }

    private function getArgumentCapitalized($argument): string
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
            exit;
        }
    }

    private function createDirectoryIfNotExists(string $basePath): void
    {
        if (!$this->files->isDirectory($basePath)) {
            $this->files->makeDirectory($basePath, 0755, true);
        }
    }

    private function getStubPath(): string
    {
        return app_path($this->stubPath);
    }

    private function getStubContent($controllerName, $moduleName): string
    {
        $stubContent = $this->files->get($this->getStubPath());

        $stubContent = str_replace('{{ controllerName }}', $controllerName, $stubContent);
        $stubContent = str_replace('{{ moduleName }}', $moduleName, $stubContent);
        return str_replace('{{ namespace }}', $this->getNameSpace(), $stubContent);

    }

    private function updateControllerText($controllerPath, $controllerName, $moduleName): void
    {
        $this->files->put($controllerPath, $this->getStubContent($controllerName, $moduleName));
    }
}
