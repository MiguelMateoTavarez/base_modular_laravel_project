<?php

namespace App\Console\Commands;

use App\Console\shared\CommandFactory;
use Illuminate\Contracts\Filesystem\FileNotFoundException;

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
        parent::handle();

        $basePath = $this->getBasePath($this->getCustomPath());
        $enumName = $this->capitalize($this->argument('enum'));

        $this->setPlaceHolders($enumName);

        $enumPath = $this->getResourcePath($basePath, $enumName);

        $this->verifyIfResourceExists($enumPath, 'Enum already exists.');

        $this->createDirectoryForResource($basePath);
        $this->createResource($enumPath);

        $this->info("{$enumName} created successfully for the module {$this->moduleName}");
    }
}
