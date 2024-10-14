<?php

namespace App\Console\Commands;

use App\Console\shared\CommandFactory;
use Illuminate\Contracts\Filesystem\FileNotFoundException;

class CreateResourceForModule extends CommandFactory
{
    protected $signature = 'make:module-resource {module} {resource} {--p|path= : Custom path}';

    protected $description = 'Create a resource for a module';

    protected string $directoryPath = 'Http/Resources';

    protected string $stubPath = '/Console/Stubs/resource.stub';

    /**
     * @throws FileNotFoundException
     */
    public function handle(): void
    {
        parent::handle();

        $basePath = $this->getBasePath($this->getCustomPath());
        $resourceName = $this->capitalize($this->argument('resource'));

        $this->setPlaceHolders($resourceName);

        $resourcePath = $this->getResourcePath($basePath, $resourceName);

        $this->verifyIfResourceExists($resourcePath, 'Resource already exists.');

        $this->createDirectoryForResource($basePath);
        $this->createResource($resourcePath);

        $this->info("{$resourceName} created successfully for the module {$this->moduleName}");
    }
}
