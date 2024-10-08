<?php

namespace App\Console\shared;

trait CustomPathTrait
{
    public function getCustomPath()
    {
        if(is_null($this->option('path'))){
            return null;
        }

        $pathSplited = str_split($this->option('path'));

        if($pathSplited[0] == '/'){
            array_shift($pathSplited);
        }

        return implode($pathSplited);
    }

    public function getNameSpace()
    {
        if(is_null($this->option('path'))){
            return "Modules\\{$this->argument('module')}\\Http\\Controllers";
        }

        $pathFormattedForNamespace = str_replace('/', '\\', $this->getCustomPath());

        return "Modules\\{$this->argument('module')}\\Http\\Controllers\\$pathFormattedForNamespace;";
    }
}
