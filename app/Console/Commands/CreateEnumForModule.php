<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

class CreateEnumForModule extends Command
{
    protected $signature = 'make:module-enum {module} {enum}';
    protected $description = 'Create an enum for a module';
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
        $basePath = base_path("modules/{$moduleName}/Enums");
        $enumName = $this->argument('enum');

        $enumPath = "{$basePath}/{$enumName}.php";

        if(!$this->files->isDirectory($basePath)){
            $this->files->makeDirectory($basePath,0755, true);
        }

        $modelStub = app_path("/Console/Stubs/enum.stub");
        $stubContent = $this->files->get($modelStub);

        $stubContent = str_replace('{{ enumName }}', $enumName, $stubContent);
        $stubContent = str_replace('{{ moduleName }}', $moduleName, $stubContent);

        $this->files->put($enumPath, $stubContent);

        $this->info("{$enumName} created successfully for the module {$moduleName}");
    }
}
