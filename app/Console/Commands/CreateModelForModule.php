<?php

namespace App\Console\Commands;

use App\Console\shared\CustomPathTrait;
use Illuminate\Console\Command;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

class CreateModelForModule extends Command
{
    use CustomPathTrait;

    protected $signature = 'make:module-model {module} {model} {--p|path= : Custom path}';
    protected $description = 'Create a model for a module';
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
        $customPath = $this->getCustomPath();
        $basePath = is_null($customPath)
            ? base_path('modules' . DIRECTORY_SEPARATOR . $moduleName . DIRECTORY_SEPARATOR . 'Models')
            : base_path('modules' . DIRECTORY_SEPARATOR . $moduleName . DIRECTORY_SEPARATOR . 'Models/' . $customPath);
        $modelName = $this->argument('model');

        $modelPath = "{$basePath}/{$modelName}.php";

        if(!$this->files->isDirectory($basePath)){
            $this->files->makeDirectory($basePath,0755, true);
        }

        $modelStub = app_path("/Console/Stubs/model.stub");
        $stubContent = $this->files->get($modelStub);

        $stubContent = str_replace('{{ modelName }}', $modelName, $stubContent);
        $stubContent = str_replace('{{ moduleName }}', $moduleName, $stubContent);
        $stubContent = str_replace('{{ namespace }}', $this->getNameSpace(), $stubContent);

        $this->files->put($modelPath, $stubContent);

        $this->info("Model {$modelName} created successfully for the module {$moduleName}");
    }
}
