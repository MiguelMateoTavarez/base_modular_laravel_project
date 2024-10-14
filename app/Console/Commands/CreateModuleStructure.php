<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

class CreateModuleStructure extends Command
{
    protected $signature = 'make:module {module}';

    protected $description = 'Create a new module with the necessary directory structure';

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
        $moduleName = $this->argument('module');
        $basePath = base_path("modules/$moduleName");

        if ($this->files->isDirectory($basePath)) {
            $this->warn("The module $moduleName already exists");

            return;
        }

        $directories = [
            'Database/Migrations',
            'Database/Seeders',
            'Eloquents/Services',
            'Eloquents/Contracts',
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

        foreach ($directories as $dir) {
            usleep(25000);
            $this->createDirectory("$basePath/$dir", $moduleName);
            $progressBar->advance();
        }

        $this->addModuleProviderToProviders($moduleName);

        $progressBar->finish();

        $this->output->writeln('');

        $this->info("Module $moduleName structure created successfully");
    }

    /**
     * @throws FileNotFoundException
     */
    protected function createDirectory(string $path, string $moduleName): void
    {
        $this->files->makeDirectory($path, 0755, true, true);
        if (Str::contains($path, 'Providers')) {
            $this->createProviderClass($moduleName, $path);
        }
        if (Str::contains($path, 'Routes')) {
            $this->createApiFile($moduleName, $path);
        }
        $gitKeepPath = "$path/.gitkeep";
        $this->files->put($gitKeepPath, '');
    }

    /**
     * @throws FileNotFoundException
     */
    private function createProviderClass(string $moduleName, string $providerPath): void
    {
        $modelStub = app_path('/Console/Stubs/provider.stub');
        $stubContent = $this->files->get($modelStub);
        $stubContent = str_replace('{{ moduleName }}', $moduleName, $stubContent);
        $this->files->put("$providerPath/{$moduleName}ServiceProvider.php", $stubContent);
    }

    /**
     * @throws FileNotFoundException
     */
    private function createApiFile(string $moduleName, string $apiPath): void
    {
        $modelStub = app_path('/Console/Stubs/api.stub');
        $stubContent = $this->files->get($modelStub);
        $stubContent = str_replace('{{ moduleName }}', strtolower($moduleName), $stubContent);
        $this->files->put("$apiPath/api.php", $stubContent);
    }

    /**
     * @throws FileNotFoundException
     */
    private function addModuleProviderToProviders($moduleName): void
    {
        $providersPath = base_path('bootstrap/providers.php');
        $providerClass = "Modules\\$moduleName\\Providers\\{$moduleName}ServiceProvider::class,";

        $content = $this->files->get($providersPath);
        echo PHP_EOL;

        if (! Str::contains($content, $providerClass)) {
            $newProviderEntry = "    $providerClass".PHP_EOL.'];';
            $newContent = Str::replace('];', $newProviderEntry, $content);
            $this->files->put($providersPath, $newContent);
            $this->info("Service Provider {$providerClass} added to providers.php");

            return;
        }
        $this->info("Service Provider {$providerClass} it's already exists in providers.php");
    }
}
