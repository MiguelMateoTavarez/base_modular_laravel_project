<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class CreateModelForModule extends Command
{
    protected $signature = 'make:module-model {module} {model}';
    protected $description = 'Create a model for a module';
    protected $files;

    public function __construct(Filesystem $files)
    {
        parent::__construct();
        $this->files = $files;
    }

    public function handle()
    {
        $moduleName = $this->argument('module');
        $basePath = base_path("Modules/{$moduleName}/Models");
        $modelName = $this->argument('model');

        $modelPath = "{$basePath}/{$modelName}.php";

        if(!$this->files->isDirectory($basePath)){
            $this->files->makeDirectory($basePath,0755, true);
        }

        $modelStub = fopen(app_path()."Console/Stubs/model.stub", 'r');
        $stubContent = $this->files->get($modelStub);

        $stubContent = str_replace('{{ modelName }}', $modelName, $stubContent);
        $stubContent = str_replace('{{ moduleName }}', $moduleName, $stubContent);

        $this->files->put($modelPath, $stubContent);

        $this->info("Model {$modelName} created successfully for the module {$moduleName}");
    }
}
