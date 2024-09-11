<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

class CreateMiddlewareForModule extends Command
{
    protected $signature = 'make:module-middleware {module} {middleware}';
    protected $description = 'Create a middleware for a module';
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
        $basePath = base_path("modules/{$moduleName}/Http/Middleware");
        $middlewareName = $this->argument('middleware');

        $middlewarePath = "{$basePath}/{$middlewareName}.php";

        if(!$this->files->isDirectory($basePath)){
            $this->files->makeDirectory($basePath,0755, true);
        }

        $modelStub = app_path("/Console/Stubs/middleware.stub");
        $stubContent = $this->files->get($modelStub);

        $stubContent = str_replace('{{ middlewareName }}', $middlewareName, $stubContent);
        $stubContent = str_replace('{{ moduleName }}', $moduleName, $stubContent);

        $this->files->put($middlewarePath, $stubContent);

        $this->info("{$middlewareName} created successfully for the module {$moduleName}");
    }
}
