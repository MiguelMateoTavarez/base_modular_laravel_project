<?php

namespace App\Console\Commands;

use App\Console\shared\CommandFactory;
use Illuminate\Contracts\Filesystem\FileNotFoundException;

class CreateControllerForModule extends CommandFactory
{
    protected $signature = 'make:module-controller {module} {controller} {--p|path= : Custom path}';
    protected $description = 'Create a controller for a module';

    protected string $directoryPath = 'Http/Controllers';
    protected string $stubPath = '/Console/Stubs/api_controller.stub';

    /**
     * @throws FileNotFoundException
     */
    public function handle(): void
    {
        $moduleName = $this->getArgumentCapitalized($this->argument('module'));
        $basePath = $this->getBasePath($this->getCustomPath(), $moduleName);
        $controllerName = $this->getArgumentCapitalized($this->argument('controller'));

        $this->setPlaceHolders($controllerName, $moduleName);

        $controllerPath = $this->getResourcePath($basePath, $controllerName);

        $this->verifyIfResourceExists($controllerPath, 'Controller already exists.');

        $this->createDirectoryForResource($basePath);
        $this->createResource($controllerPath, $controllerName, $moduleName);

        $this->info("{$controllerName} created successfully for the module {$moduleName}");
    }
}
