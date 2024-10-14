<?php

namespace App\Console\Commands;

use App\Console\shared\CommandFactory;
use App\Helper\Pluralize;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Facades\Artisan;

class CreateModelForModule extends CommandFactory
{
    protected $signature = 'make:module-model {module} {model}
        {--a|all : Create all resources}
        {--p|path= : Custom path}';

    protected $description = 'Create a model for a module';

    protected string $directoryPath = 'Models';

    protected string $stubPath = '/Console/Stubs/model.stub';

    private string $modelName;

    /**
     * @throws FileNotFoundException
     */
    public function handle(): void
    {
        parent::handle();

        $basePath = $this->getBasePath($this->getCustomPath());
        $this->modelName = $this->capitalize($this->argument('model'));

        $this->setPlaceHolders($this->modelName);

        $modelPath = $this->getResourcePath($basePath, $this->modelName);

        $this->verifyIfResourceExists($modelPath, 'Model already exists.');

        $this->createDirectoryForResource($basePath);
        $this->createResource($modelPath);

        if (array_key_exists('all', $this->options())) {
            $this->createAllResources();
        }

        $this->info("Model {$this->modelName} created successfully for the module {$this->moduleName}");
    }

    protected function createAllResources(): void
    {
        $this->createMigrationByCommand();
        $this->createSeederByCommand();
        $this->createPolicyByCommand();
        $this->createControllerByCommand();
        $this->createRequestByCommand();
        $this->createResourceByCommand();
    }

    protected function createMigrationByCommand(): void
    {
        $tableName = Pluralize::getPlural(strtolower($this->argument('model')));

        Artisan::call('make:module-migration', [
            'module' => $this->moduleName,
            'migration' => "create_{$tableName}_table",
        ]);
    }

    public function createSeederByCommand(): void
    {
        $params = [
            'module' => $this->moduleName,
            'seeder' => "{$this->modelName}Seeder",
        ];

        if(array_key_exists('all', $this->options())) {
            $params['-p'] = $this->option('path');
        }

        Artisan::call('make:module-seeder', $params);
    }

    public function createPolicyByCommand(): void
    {
        $params = [
            'module' => $this->moduleName,
            'policy' => "{$this->modelName}Policy",
            '-m' => $this->modelName
        ];

        if(array_key_exists('all', $this->options())) {
            $params['-p'] = $this->option('path');
        }

        Artisan::call('make:module-policy', $params);
    }

    public function createControllerByCommand(): void
    {
        $tableName = Pluralize::getPlural(strtolower($this->argument('model')));

        $params = [
            'module' => $this->moduleName,
            'controller' => "{$tableName}Controller",
        ];

        if(array_key_exists('all', $this->options())) {
            $params['-p'] = $this->option('path');
        }

        Artisan::call('make:module-controller', $params);
    }

    public function createRequestByCommand(): void
    {
        $storeParams = [
            'module' => $this->moduleName,
            'request' => "Store{$this->modelName}Request",
        ];

        $updateParams = [
            'module' => $this->moduleName,
            'request' => "Update{$this->modelName}Request",
        ];

        if(array_key_exists('all', $this->options())) {
            $storeParams['-p'] = $this->option('path');
            $updateParams['-p'] = $this->option('path');
        }

        Artisan::call('make:module-request', $storeParams);

        Artisan::call('make:module-request', $updateParams);
    }

    public function createResourceByCommand(): void
    {
        $params = [
            'module' => $this->moduleName,
            'resource' => "{$this->modelName}Resource",
        ];

        if(array_key_exists('all', $this->options())) {
            $params['-p'] = $this->option('path');
        }

        Artisan::call('make:module-resource', $params);
    }
}
