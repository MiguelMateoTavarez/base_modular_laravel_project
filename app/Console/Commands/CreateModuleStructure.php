<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Console\Helper\ProgressBar;

class CreateModuleStructure extends Command
{
    protected $signature = 'make:module {name}';
    protected $description = 'Create a new module with the necessary directory structure';
    protected $files;

    public function __construct(Filesystem $files)
    {
        parent::__construct();
        $this->files = $files;
    }

    public function handle()
    {
        $moduleName = $this->argument('name');
        $basePath = base_path("Modules/{$moduleName}");

        $directories = [
            'Database/factories',
            'Database/migrations',
            'Database/seeders',
            'Eloquents/Services',
            'Eloquents/Contract',
            'Enums',
            'Http/Controllers',
            'Http/Middleware',
            'Http/Requests',
            'Http/Resources',
            'Models',
            'Policies',
            'Providers',
            'Routes',
        ];

        $progressBar = $this->output->createProgressBar(count($directories));

        $progressBar->start();

        foreach($directories as $dir) {
            usleep(25000);
            $this->createDirectory("{$basePath}/{$dir}");
            $progressBar->advance();
        }

        $progressBar->finish();

        $this->output->writeln('');

        $this->info("Module {$moduleName} structure created successfully");
    }

    protected function createDirectory($path)
    {
        if(!$this->files->isDirectory($path)){
            $this->files->makeDirectory($path, 0755, true, true);
            $gitkeepPath = "{$path}/.gitkeep";
            $this->files->put($gitkeepPath, "");
        }else {
            $this->info("Directory already exists: {$path}");
            exit();
        }
    }
}
