<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

class CreateInterfaceForModule extends Command
{
    protected $signature = 'make:module-interface {module} {interface}';
    protected $description = 'Create an interface for a module';
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
        $basePath = base_path("modules/{$moduleName}/Eloquents/Contracts");
        $interfaceName = $this->argument('interface');

        $interfacePath = "{$basePath}/{$interfaceName}.php";

        if(!$this->files->isDirectory($basePath)){
            $this->files->makeDirectory($basePath,0755, true);
        }

        $modelStub = app_path("/Console/Stubs/contract.stub");
        $stubContent = $this->files->get($modelStub);

        $stubContent = str_replace('{{ interfaceName }}', $interfaceName, $stubContent);
        $stubContent = str_replace('{{ moduleName }}', $moduleName, $stubContent);

        $this->files->put($interfacePath, $stubContent);

        $this->info("{$interfaceName} created successfully for the module {$moduleName}");
    }
}
