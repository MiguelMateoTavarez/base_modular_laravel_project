<?php

namespace App\Console\Commands;

use App\Console\shared\CommandFactory;
use Illuminate\Console\Command;
use Illuminate\Contracts\Filesystem\FileNotFoundException;

class CreateObserverForModel extends CommandFactory
{
    protected $signature = 'make:module-observer {module} {observer}
        {--m|model= : The model to observe}
        {--p|path= : Custom path}';

    protected $description = 'Create an observer for a module';

    protected string $directoryPath = 'Observers';

    private string $modelsPath = 'Models';

    protected string $stubPath = '/Console/Stubs/observer.stub';

    /**
     * Execute the console command.
     * @throws FileNotFoundException
     */
    public function handle(): void
    {
        parent::handle();

        if(!array_key_exists('model', $this->options())) {
            $this->error('You must provide a model to observe');
            return;
        }

        $basePath = $this->getBasePath($this->getCustomPath());
        $modelBasePath = $this->getBasePath($this->getModelPath());
        $observerName = $this->capitalize($this->argument('observer'));
        $modelName = $this->capitalize($this->option('model'));
        $modelPath = $this->getResourcePath($modelBasePath, $modelName);

        $this->verifyIfModelExists(
            $modelPath,
            "The model '{$modelBasePath}' doesn't exists."
        );

        $this->setPlaceHolders($observerName);

        $observerPath = $this->getResourcePath($basePath, $observerName);

        $this->verifyIfResourceExists($observerPath, "Policy '{$observerName}' already exists.");

        $this->createDirectoryForResource($basePath);

        $this->createResource($observerPath);

        $this->info("Policy {$observerName} created successfully for the module {$this->moduleName}");
    }

    private function getModelPath(): string
    {
        if (is_null($this->option('path'))) {
            return $this->modelsPath;
        }

        return $this->modelsPath.'/'.$this->getClearCustomCapitalizedPath();
    }

    private function verifyIfModelExists(string $modelPath, string $message): void
    {
        if (! $this->files->exists($modelPath)) {
            throw new \RuntimeException($message);
        }
    }

    protected function setPlaceHolders($resourceName): void
    {
        $model = $this->option('model');

        $this->placeHolders = [
            '{{ resourceName }}' => $resourceName,
            '{{ moduleName }}' => $this->moduleName,
            '{{ namespace }}' => $this->getNameSpace(),
            '{{ modelNamespace }}' => $this->getResourceImportedNameSpace(),
            '{{ modelName }}' => $model,
            '{{ moduleInjected }}' => lcfirst($model),
        ];
    }

    protected function getResourceImportedNameSpace(): string
    {
        $pathFormattedForNamespace = str_replace('/', '\\', $this->getModelPath());

        return "Modules\\{$this->argument('module')}\\$pathFormattedForNamespace\\{$this->capitalize($this->option('model'))}";
    }
}
