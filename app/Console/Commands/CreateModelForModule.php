<?php

namespace App\Console\Commands;

use App\Console\shared\CommandFactory;
use Illuminate\Contracts\Filesystem\FileNotFoundException;

class CreateModelForModule extends CommandFactory
{
    protected $signature = 'make:module-model {module} {model} {--p|path= : Custom path}';

    protected $description = 'Create a model for a module';

    protected string $directoryPath = 'Models';

    protected string $stubPath = '/Console/Stubs/model.stub';

    /**
     * @throws FileNotFoundException
     */
    public function handle(): void
    {
        $moduleName = $this->capitalize($this->argument('module'));
        $basePath = $this->getBasePath($this->getCustomPath(), $moduleName);
        $modelName = $this->capitalize($this->argument('model'));

        $this->setPlaceHolders($modelName, $moduleName);

        $modelPath = $this->getResourcePath($basePath, $modelName);

        $this->verifyIfResourceExists($modelPath, 'Model already exists.');

        $this->createDirectoryForResource($basePath);
        $this->createResource($modelPath, $modelName, $moduleName);

        $this->info("Model {$modelName} created successfully for the module {$moduleName}");
    }
}
