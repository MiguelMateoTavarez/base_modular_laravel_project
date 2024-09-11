<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

class CreateMigrationForModule extends Command
{
    protected $signature = 'make:module-migration {module} {migration}';
    protected $description = 'Create a migration for a module';
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
        $basePath = base_path("modules/{$moduleName}/Database/Migrations");
        $timestamp = date('Y_m_d_His');
        $migrationName = $this->argument('migration');
        $tableName = $this->extractTableName($migrationName);
        $snakeCaseMigration = Str::snake($migrationName);

        $migrationsPath = "{$basePath}/{$timestamp}_{$snakeCaseMigration}.php";

        if(!$this->files->isDirectory($basePath)){
            $this->files->makeDirectory($basePath,0755, true);
        }

        $modelStub = match(true){
            Str::contains($migrationName, 'create') => app_path("/Console/Stubs/migration_create.stub"),
            default =>app_path("/Console/Stubs/migration_modify.stub")
        };
        $stubContent = $this->files->get($modelStub);

        $stubContent = str_replace('{{ table }}', $tableName, $stubContent);
        $stubContent = str_replace('{{ moduleName }}', $moduleName, $stubContent);

        $this->files->put($migrationsPath, $stubContent);

        $this->info("Migration {$migrationName} created successfully for the module {$moduleName}");
    }

    /**
     * Extract the name based on migration name
     *
     * @param string $migrationName
     * @return string
     */
    protected function extractTableName(string $migrationName): string
    {
        return Str::plural(match(true){
            Str::startsWith($migrationName, 'create') => Str::snake(Str::between($migrationName, 'create_', '_table')),
            Str::startsWith($migrationName, 'add') => Str::snake(Str::between($migrationName, '_to_', '_table')),
        });
    }
}
