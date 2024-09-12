<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

class CreateResourceForModule extends Command
{
    protected $signature = 'make:module-resource {module} {resource}';
    protected $description = 'Create a resource for a module';
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
        $basePath = base_path("modules/{$moduleName}/Http/Resources");
        $resourceName = $this->getTitleFormatted();

        $resourcePath = "{$basePath}/{$resourceName}.php";

        if($this->files->exists($resourcePath)){
            $this->warn('The file already exists');
            return;
        }

        if(!$this->files->isDirectory($basePath)){
            $this->files->makeDirectory($basePath,0755, true);
        }

        $modelStub = app_path("/Console/Stubs/resource.stub");
        $stubContent = $this->files->get($modelStub);

        $stubContent = str_replace('{{ resourceName }}', $resourceName, $stubContent);
        $stubContent = str_replace('{{ moduleName }}', $moduleName, $stubContent);

        $this->files->put($resourcePath, $stubContent);

        $this->info("{$resourceName} created successfully for the module {$moduleName}");
    }

    private function getTitleFormatted()
    {
        $title = $this->argument('resource');
        return Str::contains($title, 'Resource') ? $title : $title.'Resource';
    }
}
