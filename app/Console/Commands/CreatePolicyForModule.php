<?php

namespace App\Console\Commands;

use App\Console\shared\CommandFactory;
use Illuminate\Contracts\Filesystem\FileNotFoundException;

class CreatePolicyForModule extends CommandFactory
{
    protected $signature = 'make:module-policy {module} {policy}
        {--m|model= : The model that the policy applies to}
        {--p|path= : Custom path}';

    protected $description = 'Create a policy for a module';

    protected string $directoryPath = 'Policies';

    private string $modelsPath = 'Models';

    protected string $stubPath = '/Console/Stubs/policy.stub';

    /**
     * @throws FileNotFoundException
     */
    public function handle(): void
    {
        parent::handle();

        $basePath = $this->getBasePath($this->getCustomPath());
        $modelBasePath = $this->getBasePath($this->getModelPath());
        $policyName = $this->capitalize($this->argument('policy'));
        $modelName = $this->capitalize($this->option('model'));
        $modelPath = $this->getResourcePath($modelBasePath, $modelName);

        $this->verifyIfModelExists(
            $modelPath,
            "The model '{$modelBasePath}' doesn't exists."
        );

        $this->setPlaceHolders($policyName);

        $policyPath = $this->getResourcePath($basePath, $policyName);

        $this->verifyIfResourceExists($policyPath, "Policy '{$policyName}' already exists.");

        $this->createDirectoryForResource($basePath);

        $this->createResource($policyPath);

        $this->info("Policy {$policyName} created successfully for the module {$this->moduleName}");
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
