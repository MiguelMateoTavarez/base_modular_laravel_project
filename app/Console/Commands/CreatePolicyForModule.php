<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;
use Modules\Security\Models\Role;

class CreatePolicyForModule extends Command
{
    protected $signature = 'make:module-policy
        {module}
        {policy}
        {--m|model= : The model that the policy applies to}';
    protected $description = 'Create a policy for a module';
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
        $basePath = base_path("modules/{$moduleName}/Policies");

        $policyName = $this->argument('policy');

        $modelName = Str::title($this->option('model'));

        if(!$modelName){
            $this->error('The --model or -m option is required');
            return;
        }

        if(!class_exists("Modules\\{$moduleName}\\Models\\{$modelName}")){
            $this->error("The model '{$modelName}' doesn't exists");
            return;
        }

        $policyPath = "{$basePath}/{$policyName}.php";

        if(!$this->files->isDirectory($basePath)){
            $this->files->makeDirectory($basePath,0755, true);
        }

        $modelStub = app_path("/Console/Stubs/policy.stub");
        $stubContent = $this->files->get($modelStub);

        $stubContent = str_replace('{{ policyName }}', $policyName, $stubContent);
        $stubContent = str_replace('{{ moduleName }}', $moduleName, $stubContent);
        $stubContent = str_replace('{{ modelName }}', $modelName, $stubContent);
        $stubContent = str_replace('{{ moduleInjected }}', Str::lower($modelName), $stubContent);

        $this->files->put($policyPath, $stubContent);

        $this->info("Model {$policyName} created successfully for the module {$moduleName}");
    }
}
