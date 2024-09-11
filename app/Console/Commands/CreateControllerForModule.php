<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

class CreateControllerForModule extends Command
{
    protected $signature = 'make:module-controller {module} {controller}';
    protected $description = 'Create a controller for a module';
    protected Filesystem $files;

    public function __construct(Filesystem $files)
    {
        parent::__construct();
        $this->files = $files;
    }

    /**
     * @throws FileNotFoundException
     */
    public function handle(): void
    {
        $moduleName = Str::title($this->argument('module'));
        $basePath = base_path("modules/{$moduleName}/Http/Controllers");
        $controllerName = $this->argument('controller');

        $controllerPath = "{$basePath}/{$controllerName}.php";

        if(!$this->files->isDirectory($basePath)){
            $this->files->makeDirectory($basePath,0755, true);
        }

        $modelStub = app_path("/Console/Stubs/api_controller.stub");
        $stubContent = $this->files->get($modelStub);

        $stubContent = str_replace('{{ controllerName }}', $controllerName, $stubContent);
        $stubContent = str_replace('{{ moduleName }}', $moduleName, $stubContent);

        $this->files->put($controllerPath, $stubContent);

        $this->info("{$controllerName} created successfully for the module {$moduleName}");
    }
}
