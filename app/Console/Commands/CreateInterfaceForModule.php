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
        parent::handle();

        $basePath = $this->getBasePath($this->getCustomPath());
        $interfaceName = $this->capitalize($this->argument('interface'));

        $this->setPlaceHolders($interfaceName);

        $interfacePath = $this->getResourcePath($basePath, $interfaceName);

        $this->verifyIfResourceExists($interfacePath, 'Interface already exists.');

        $this->createDirectoryForResource($basePath);
        $this->createResource($interfacePath);

        $this->info("Interface {$interfaceName} created successfully for the module {$this->moduleName}");
    }
}
