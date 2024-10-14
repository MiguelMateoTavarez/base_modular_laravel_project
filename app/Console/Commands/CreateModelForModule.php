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
        parent:: handle();

        $basePath = $this->getBasePath($this->getCustomPath());
        $modelName = $this->capitalize($this->argument('model'));

        $this->setPlaceHolders($modelName);

        $modelPath = $this->getResourcePath($basePath, $modelName);

        $this->verifyIfResourceExists($modelPath, 'Model already exists.');

        $this->createDirectoryForResource($basePath);
        $this->createResource($modelPath);

        $this->info("Model {$modelName} created successfully for the module {$this->moduleName}");
    }
}
