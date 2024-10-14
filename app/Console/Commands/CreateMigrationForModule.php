<?php

namespace App\Console\Commands;

use AllowDynamicProperties;
use App\Console\shared\CommandFactory;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Str;

#[AllowDynamicProperties]
class CreateMigrationForModule extends CommandFactory
{
    protected $signature = 'make:module-migration {module} {migration}';

    protected $description = 'Create a migration for a module';

    protected string $directoryPath = 'Database/Migrations';

    protected string $stubPath = '/Console/Stubs/migration_create.stub';

    /**
     * @throws FileNotFoundException
     */
    public function handle(): void
    {
        parent::handle();

        $basePath = $this->getBasePath($this->getCustomPath());
        $migrationName = $this->argument('migration');
        $tableName = $this->extractTableName($migrationName);
        $snakeCaseMigration = Str::snake($migrationName);

        $this->setPlaceHolders($tableName);

        $migrationsPath = $this->getResourcePath($basePath, $snakeCaseMigration);

        $this->createDirectoryForResource($basePath);

        $this->createResource($migrationsPath);

        $this->info("Migration {$migrationName} created successfully for the module {$this->moduleName}");
    }

    /**
     * Extract the name based on migration name
     */
    protected function extractTableName(string $migrationName): string
    {
        return Str::plural(match (true) {
            Str::startsWith($migrationName, 'create') => Str::snake(Str::between($migrationName, 'create_', '_table')),
            Str::startsWith($migrationName, 'add') => Str::snake(Str::between($migrationName, '_to_', '_table')),
            Str::startsWith($migrationName, 'modify') => Str::snake(Str::between($migrationName, 'modify_', '_table')),
        });
    }

    protected function getStubPath(): string
    {
        return match (true) {
            Str::contains($this->argument('migration'), 'create') => app_path('/Console/Stubs/migration_create.stub'),
            default => app_path('/Console/Stubs/migration_modify.stub')
        };
    }

    protected function setPlaceHolders($resourceName): void
    {
        $this->placeHolders = [
            '{{ table }}' => $resourceName,
            '{{ moduleName }}' => $this->moduleName,
        ];
    }

    protected function getResourcePath(string $basePath, string $resourceName): string
    {
        $timestamp = date('Y_m_d_His');

        return "{$basePath}/{$timestamp}_{$resourceName}.php";
    }
}
