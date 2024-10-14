<?php

namespace App\Console\Commands;

use App\Console\shared\CommandFactory;
use Illuminate\Contracts\Filesystem\FileNotFoundException;

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
        parent::handle();

        $basePath = $this->getBasePath($this->getCustomPath());
        $requestName = $this->capitalize($this->argument('request'));

        $this->setPlaceHolders($requestName);

        $requestPath = $this->getResourcePath($basePath, $requestName);

        $this->verifyIfResourceExists($requestPath, 'Request already exists.');

        $this->createDirectoryForResource($basePath);
        $this->createResource($requestPath);

        $this->info("{$requestName} created successfully for the module {$this->moduleName}");
    }
}
