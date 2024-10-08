<?php

namespace App\Console\Commands;

use App\Console\shared\CustomPathTrait;
use Illuminate\Console\Command;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

class CreateControllerForModule extends Command
{
    use CustomPathTrait;

    protected $signature = 'make:module-controller {module} {controller} {--p|path= : Custom path}';
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
        $moduleName = ucfirst($this->argument('module'));
        $customPath = $this->getCustomPath();
        $basePath = is_null($customPath)
            ? base_path('modules' . DIRECTORY_SEPARATOR . $moduleName . DIRECTORY_SEPARATOR . 'Http/Controllers')
            : base_path('modules' . DIRECTORY_SEPARATOR . $moduleName . DIRECTORY_SEPARATOR . 'Http/Controllers/' . $customPath);
        $controllerName = $this->argument('controller');
        $controllerPath = "{$basePath}/{$controllerName}.php";

        if ($this->files->exists($controllerPath)) {
            $this->warn('The file already exists');
            return;
        }

        if (!$this->files->isDirectory($basePath)) {
            $this->files->makeDirectory($basePath, 0755, true);
        }

        $modelStub = app_path("/Console/Stubs/api_controller.stub");
        $stubContent = $this->files->get($modelStub);

        $stubContent = str_replace('{{ controllerName }}', $controllerName, $stubContent);
        $stubContent = str_replace('{{ moduleName }}', $moduleName, $stubContent);
        $stubContent = str_replace('{{ namespace }}', $this->getNameSpace(), $stubContent);

        $this->files->put($controllerPath, $stubContent);

        $this->info("{$controllerName} created successfully for the module {$moduleName}");
    }
}
