<?php

namespace App\Console\shared;

trait CustomPathTrait
{
    private function capitalizeDirectoryName($str)
    {
        return ucfirst($str);
    }

    private function getClearCustomCapitalizedPath()
    {
        $pathExploded = explode('/', implode($this->clearBackSlash()));

        $pathCapitalized = array_map(function($str){
            return ucfirst($str);
        }, $pathExploded);

        return implode('/',$pathCapitalized);
    }

    private function clearBackSlash()
    {
        $pathSplited = str_split($this->option('path'));

        if ($pathSplited[0] == '/') {
            array_shift($pathSplited);
        }

        return $pathSplited;
    }

    private function getCustomPath()
    {
        if (is_null($this->option('path'))) {
            return $this->directoryPath;
        }

        return $this->directoryPath.'/'.$this->getClearCustomCapitalizedPath();
    }

    public function getNameSpace()
    {
        $pathFormattedForNamespace = str_replace('/', '\\', $this->getCustomPath());

        return "Modules\\{$this->argument('module')}\\$pathFormattedForNamespace";
    }
}
