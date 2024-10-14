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

    /**
     * @throws FileNotFoundException
     */
    public function handle(): void
    {
        parent::handle();

        $basePath = $this->getBasePath($this->getCustomPath());
        $modelName = $this->capitalize($this->argument('model'));

        $this->setPlaceHolders($modelName);

        $modelPath = $this->getResourcePath($basePath, $modelName);

        $this->verifyIfResourceExists($modelPath, 'Model already exists.');

        $this->createDirectoryForResource($basePath);
        $this->createResource($modelPath);

        if(array_key_exists('all', $this->options())) {
            $this->createAllResources();
        }

        $this->info("Model {$modelName} created successfully for the module {$this->moduleName}");
    }

    protected function createAllResources(): void
    {
        $this->createMigrationByCommand();
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
        //todo: seeder
    }

    public function createPolicyByCommand(): void
    {
        //todo: policy
    }

    public function createControllerByCommand(): void
    {
        //todo: controller
    }

    public function createRequestByCommand(): void
    {
        //todo: request
    }

    public function createResourceByCommand(): void
    {
        //todo: resource
    }

    public function createInterfaceByCommand(): void
    {
        //todo: interface
    }

    public function createServiceByCommand(): void
    {
        //todo: service
    }
}
