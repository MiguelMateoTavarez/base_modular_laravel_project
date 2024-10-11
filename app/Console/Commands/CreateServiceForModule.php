<?php

namespace App\Console\Commands;

use App\Console\shared\CommandFactory;
use App\Console\shared\CustomPathTrait;
use Illuminate\Console\Command;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

class CreateServiceForModule extends CommandFactory
{
    protected $signature = 'make:module-service {module} {service} {--i|interface= : The interface to implement} {--p|path= : Custom path}';
    protected $description = 'Create a service for a module';

    protected string $directoryPath = 'Eloquents/Services';
    private string $interfacePath = 'Eloquents/Contracts';
    protected string $stubPath = '/Console/Stubs/service_contract.stub';
    protected string $alternativeStubPath = '/Console/Stubs/service_no_contract.stub';

    /**
     * @throws FileNotFoundException
     */
    public function handle(): void
    {
        $moduleName = $this->getArgumentCapitalized($this->argument('module'));
        $basePath = $this->getBasePath($this->getCustomPath(), $moduleName);
        $interfaceBasePath = $this->getBasePath($this->getInterfacePath(), $moduleName);
        $serviceName = $this->getArgumentCapitalized($this->argument('model'));
        $interfaceName = $this->getArgumentCapitalized($this->option('interface'));

        if($interfaceName){
            $this->updatePlaceHolders($interfaceName);
        }

        $this->setPlaceHolders($serviceName, $moduleName);

        $servicePath = $this->getResourcePath($basePath, $serviceName);
        $interfacePath = $this->getResourcePath($interfaceBasePath, $interfaceName);

        $this->verifyIfResourceExists($servicePath, "Service '{$interfacePath}' already exists.");
        $this->verifyIfInterfaceExists($interfacePath, "The interface '{$interfaceName}' doesn't exists.");

        $this->createDirectoryForResource($basePath);

        $this->createResource($interfacePath, $serviceName, $moduleName);

        $this->info("Service {$serviceName} created successfully for the module {$moduleName}");
    }

    private function verifyIfInterfaceExists(string $resourceName, string $message): void
    {
        if (!$this->files->exists($resourceName)) {
            throw new \RuntimeException($message);
        }
    }

    private function getInterfacePath(): string
    {
        if (is_null($this->option('path'))) {
            return $this->interfacePath;
        }

        return $this->interfacePath.'/'.$this->getClearCustomCapitalizedPath();
    }

    protected function updatePlaceHolders($interfaceName): void
    {
        $this->placeHolders['{{ interfaceName }}'] = $interfaceName;
    }
}
