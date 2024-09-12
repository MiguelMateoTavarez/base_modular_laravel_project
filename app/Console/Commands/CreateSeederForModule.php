<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

class CreateSeederForModule extends Command
{
    protected $signature = 'make:module-seeder {module} {seeder}';
    protected $description = 'Create a seeder for a module';
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
        $basePath = base_path("modules/{$moduleName}/Database/Seeders");
        $seederName = $this->getTitleFormatted();

        $seederPath = "{$basePath}/{$seederName}.php";

        if($this->files->exists($seederPath)){
            $this->warn('The file already exists');
            return;
        }

        if(!$this->files->isDirectory($basePath)){
            $this->files->makeDirectory($basePath,0755, true);
        }

        $modelStub = app_path("/Console/Stubs/seeder.stub");
        $stubContent = $this->files->get($modelStub);

        $stubContent = str_replace('{{ seederName }}', $seederName, $stubContent);
        $stubContent = str_replace('{{ moduleName }}', $moduleName, $stubContent);

        $this->files->put($seederPath, $stubContent);

        $this->info("{$seederName} created successfully for the module {$moduleName}");
    }

    private function getTitleFormatted()
    {
        $title = $this->argument('seeder');
        return Str::contains($title, 'Seeder') ? $title : $title.'Seeder';
    }
}
