<?php

namespace App\Console\Commands;

use App\Console\shared\CommandFactory;
use Illuminate\Contracts\Filesystem\FileNotFoundException;

class CreateMiddlewareForModule extends CommandFactory
{
    protected $signature = 'make:module-middleware {module} {middleware} {--p|path= : Custom path}';

    protected $description = 'Create a middleware for a module';

    protected string $directoryPath = 'Http/Middleware';

    protected string $stubPath = '/Console/Stubs/middleware.stub';

    /**
     * @throws FileNotFoundException
     */
    public function handle(): void
    {
        $moduleName = $this->capitalize($this->argument('module'));
        $basePath = $this->getBasePath($this->getCustomPath(), $moduleName);
        $middlewareName = $this->capitalize($this->argument('middleware'));

        $this->setPlaceHolders($middlewareName, $moduleName);

        $middlewarePath = $this->getResourcePath($basePath, $middlewareName);

        $this->verifyIfResourceExists($middlewarePath, 'Middleware already exists.');

        $this->createDirectoryForResource($basePath);
        $this->createResource($middlewarePath);

        $this->info("{$middlewareName} created successfully for the module {$moduleName}");
    }
}
