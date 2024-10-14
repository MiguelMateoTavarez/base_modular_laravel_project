<?php

namespace App\Console\Commands;

use App\Console\shared\CommandFactory;
use App\Console\shared\CustomPathTrait;
use Illuminate\Console\Command;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

class CreateRequestForModule extends CommandFactory
{
    protected $signature = 'make:module-request {module} {request} {--p|path= : Custom path}';
    protected $description = 'Create a request for a module';

    protected string $directoryPath = 'Http/Requests';
    protected string $stubPath = '/Console/Stubs/request.stub';
    /**
     * @throws FileNotFoundException
     */
    public function handle(): void
    {
        $moduleName = $this->capitalize($this->argument('module'));
        $basePath = $this->getBasePath($this->getCustomPath(), $moduleName);
        $requestName = $this->capitalize($this->argument('request'));

        $this->setPlaceHolders($requestName, $moduleName);

        $requestPath = $this->getResourcePath($basePath, $requestName);

        $this->verifyIfResourceExists($requestPath, 'Request already exists.');

        $this->createDirectoryForResource($basePath);
        $this->createResource($requestPath);

        $this->info("{$requestName} created successfully for the module {$moduleName}");
    }
}
