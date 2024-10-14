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
        $moduleName = $this->capitalize($this->argument('module'));
        $basePath = $this->getBasePath($this->getCustomPath(), $moduleName);
        $controllerName = $this->capitalize($this->argument('controller'));

        $this->setPlaceHolders($controllerName, $moduleName);

        $controllerPath = $this->getResourcePath($basePath, $controllerName);

        $this->verifyIfResourceExists($controllerPath, 'Controller already exists.');

        $this->createDirectoryForResource($basePath);
        $this->createResource($controllerPath);

        $this->info("{$controllerName} created successfully for the module {$moduleName}");
    }
}
