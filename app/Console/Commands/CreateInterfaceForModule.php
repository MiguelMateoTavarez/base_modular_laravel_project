<?php

namespace App\Console\Commands;

use App\Console\shared\CommandFactory;
use Illuminate\Contracts\Filesystem\FileNotFoundException;

class CreateInterfaceForModule extends CommandFactory
{
    protected $signature = 'make:module-interface {module} {interface} {--p|path= : Custom path}';

    protected $description = 'Create an interface for a module';

    protected string $directoryPath = 'Eloquents/Contracts';

    protected string $stubPath = '/Console/Stubs/contract.stub';

    /**
     * @throws FileNotFoundException
     */
    public function handle(): void
    {
        $moduleName = $this->capitalize($this->argument('module'));
        $basePath = $this->getBasePath($this->getCustomPath(), $moduleName);
        $interfaceName = $this->capitalize($this->argument('interface'));

        $this->setPlaceHolders($interfaceName, $moduleName);

        $interfacePath = $this->getResourcePath($basePath, $interfaceName);

        $this->verifyIfResourceExists($interfacePath, 'Interface already exists.');

        $this->createDirectoryForResource($basePath);
        $this->createResource($interfacePath, $interfaceName, $moduleName);

        $this->info("Interface {$interfaceName} created successfully for the module {$moduleName}");
    }
}
