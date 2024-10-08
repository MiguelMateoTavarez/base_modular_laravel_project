<?php

namespace App\Console\Commands;

use App\Console\shared\CustomPathTrait;
use Illuminate\Console\Command;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

class CreateRequestForModule extends Command
{
    use CustomPathTrait;

    protected $signature = 'make:module-request {module} {request} {--p|path= : Custom path}';
    protected $description = 'Create a request for a module';
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
            ? base_path('modules' . DIRECTORY_SEPARATOR . $moduleName . DIRECTORY_SEPARATOR . 'Http/Requests')
            : base_path('modules' . DIRECTORY_SEPARATOR . $moduleName . DIRECTORY_SEPARATOR . 'Http/Requests/' . $customPath);
        $requestName = $this->getTitleFormatted();

        $requestPath = "{$basePath}/{$requestName}.php";

        if($this->files->exists($requestPath)){
            $this->warn('The file already exists');
            return;
        }

        if(!$this->files->isDirectory($basePath)){
            $this->files->makeDirectory($basePath,0755, true);
        }

        $modelStub = app_path("/Console/Stubs/request.stub");
        $stubContent = $this->files->get($modelStub);

        $stubContent = str_replace('{{ requestName }}', $requestName, $stubContent);
        $stubContent = str_replace('{{ moduleName }}', $moduleName, $stubContent);
        $stubContent = str_replace('{{ namespace }}', $this->getNameSpace(), $stubContent);

        $this->files->put($requestPath, $stubContent);

        $this->info("{$requestName} created successfully for the module {$moduleName}");
    }

    private function getTitleFormatted()
    {
        $title = $this->argument('request');
        return Str::contains($title, 'Request') ? $title : $title.'Request';
    }
}
