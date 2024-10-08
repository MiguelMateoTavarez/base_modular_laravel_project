<?php

namespace App\Console\Commands;

use App\Console\shared\CustomPathTrait;
use Illuminate\Console\Command;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

class CreateServiceForModule extends Command
{
    use CustomPathTrait;

    protected $signature = 'make:module-service {module} {service} {--i|interface= : The interface to implement} {--p|path= : Custom path}';
    protected $description = 'Create a service for a module';
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
        $customPath = $this->getCustomPath();
        $basePath = is_null($customPath)
            ? base_path('modules' . DIRECTORY_SEPARATOR . $moduleName . DIRECTORY_SEPARATOR . 'Eloquents/Services')
            : base_path('modules' . DIRECTORY_SEPARATOR . $moduleName . DIRECTORY_SEPARATOR . 'Eloquents/Services/' . $customPath);
        $seederName = $this->getTitleFormatted();
        $interfaceName = $this->option('interface');

        $seederPath = "{$basePath}/{$seederName}.php";

        if($this->files->exists($seederPath)){
            $this->warn('The file already exists');
            return;
        }

        if(!$this->files->exists(base_path("modules/{$moduleName}/Eloquents/Contracts/{$interfaceName}.php"))){
            $this->error("The interface '{$interfaceName}' doesn't exists");
            return;
        }

        if(!$this->files->isDirectory($basePath)){
            $this->files->makeDirectory($basePath,0755, true);
        }

        $modelStub = $interfaceName
            ? app_path("/Console/Stubs/service_contract.stub")
            : app_path("/Console/Stubs/service_no_contract.stub");

        $stubContent = $this->files->get($modelStub);

        $stubContent = str_replace('{{ serviceName }}', $seederName, $stubContent);
        $stubContent = str_replace('{{ moduleName }}', $moduleName, $stubContent);
        $stubContent = str_replace('{{ namespace }}', $this->getNameSpace(), $stubContent);

        if($interfaceName){
            $stubContent = str_replace('{{ interfaceName }}', $interfaceName, $stubContent);
        }

        $this->files->put($seederPath, $stubContent);

        $this->info("{$seederName} created successfully for the module {$moduleName}");
    }

    private function getTitleFormatted()
    {
        $title = $this->argument('service');
        return Str::contains($title, 'Service') ? $title : $title.'Service';
    }
}
