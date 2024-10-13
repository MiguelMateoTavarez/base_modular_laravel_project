<?php

namespace App\Console\Commands;

use App\Console\shared\CommandFactory;
use Illuminate\Console\Command;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

class CreateEnumForModule extends CommandFactory
{
    protected $signature = 'make:module-enum {module} {enum} {--p|path= : Custom path}';
    protected $description = 'Create an enum for a module';

    protected string $directoryPath = 'Enums';
    protected string $stubPath = '/Console/Stubs/enum.stub';

    /**
     * @throws FileNotFoundException
     */
    public function handle(): void
    {
        $moduleName = $this->capitalize($this->argument('module'));
        $basePath = $this->getBasePath($this->getCustomPath(), $moduleName);
        $enumName = $this->capitalize($this->argument('enum'));

        $this->setPlaceHolders($enumName, $moduleName);

        $enumPath = $this->getResourcePath($basePath, $enumName);

        $this->verifyIfResourceExists($enumPath, 'Enum already exists.');

        $this->createDirectoryForResource($basePath);
        $this->createResource($enumPath);

        $this->info("{$enumName} created successfully for the module {$moduleName}");
    }
}
