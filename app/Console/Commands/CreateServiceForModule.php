<?php

namespace App\Console\Commands;

use App\Console\shared\CommandFactory;
use Illuminate\Contracts\Filesystem\FileNotFoundException;

class CreateServiceForModule extends CommandFactory
{
    protected $signature = 'make:module-service {module} {service}
        {--i|interface= : The interface to implement}
        {--p|path= : Custom path}';

    protected $description = 'Create a service for a module';

    protected string $directoryPath = 'Eloquents/Services';

    private string $interfacePath = 'Eloquents/Contracts';

    protected string $stubPath = '/Console/Stubs/service.stub';

    /**
     * @throws FileNotFoundException
     */
    public function handle(): void
    {
        $moduleName = $this->capitalize($this->argument('module'));
        $basePath = $this->getBasePath($this->getCustomPath(), $moduleName);
        $interfaceBasePath = $this->getBasePath($this->getInterfacePath(), $moduleName);
        $serviceName = $this->capitalize($this->argument('service'));
        $interfaceName = $this->capitalize($this->option('interface'));
        $interfacePath = $this->getResourcePath($interfaceBasePath, $interfaceName);

        $this->verifyIfInterfaceExists(
            $interfacePath,
            "The interface '{$interfaceBasePath}' doesn't exists."
        );

        $this->setPlaceHolders($serviceName, $moduleName);

        $servicePath = $this->getResourcePath($basePath, $serviceName);

        $this->verifyIfResourceExists($servicePath, "Service '{$serviceName}' already exists.");

        $this->createDirectoryForResource($basePath);

        $this->createResource($servicePath);

        $this->info("Service {$serviceName} created successfully for the module {$moduleName}");
    }

    private function verifyIfInterfaceExists(string $interfacePath, string $message): void
    {
        if (! $this->files->exists($interfacePath)) {
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

    protected function setPlaceHolders($resourceName, $moduleName): void
    {
        $this->placeHolders = [
            '{{ resourceName }}' => $resourceName,
            '{{ moduleName }}' => $moduleName,
            '{{ namespace }}' => $this->getNameSpace(),
            '{{ interfaceNamespace }}' => $this->getResourceImportedNameSpace(),
            '{{ interfaceName }}' => $this->capitalize($this->option('interface')),
        ];
    }

    protected function getResourceImportedNameSpace(): string
    {
        $pathFormattedForNamespace = str_replace('/', '\\', $this->getInterfacePath());

        return "Modules\\{$this->argument('module')}\\$pathFormattedForNamespace\\{$this->capitalize($this->option('interface'))}";
    }
}
