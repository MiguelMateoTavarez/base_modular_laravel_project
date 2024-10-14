<?php

namespace App\Console\Commands;

use App\Console\shared\CommandFactory;
use Illuminate\Contracts\Filesystem\FileNotFoundException;

class CreateSeederForModule extends CommandFactory
{
    protected $signature = 'make:module-seeder {module} {seeder} {--p|path= : Custom path}';

    protected $description = 'Create a seeder for a module';

    protected string $directoryPath = 'Database/Seeders';

    protected string $stubPath = '/Console/Stubs/seeder.stub';

    /**
     * @throws FileNotFoundException
     */
    public function handle(): void
    {
        parent::handle();

        $basePath = $this->getBasePath($this->getCustomPath());
        $seederName = $this->capitalize($this->argument('seeder'));

        $this->setPlaceHolders($seederName);

        $seederPath = $this->getResourcePath($basePath, $seederName);

        $this->verifyIfResourceExists($seederPath, 'Seeder already exists.');

        $this->createDirectoryForResource($basePath);
        $this->createResource($seederPath);

        $this->info("{$seederName} created successfully for the module {$this->moduleName}");
    }
}
