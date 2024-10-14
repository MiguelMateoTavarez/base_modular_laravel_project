<?php

namespace App\Console\shared;

trait CustomPathTrait
{
    protected function capitalizeDirectoryName($str): string
    {
        return ucfirst($str);
    }

    protected function getClearCustomCapitalizedPath(): string
    {
        $pathExploded = explode('/', implode($this->clearBackSlash()));

        $pathCapitalized = array_map(function ($str) {
            return ucfirst($str);
        }, $pathExploded);

        return implode('/', $pathCapitalized);
    }

    protected function clearBackSlash(): array
    {
        $pathSplited = str_split($this->option('path'));

        if ($pathSplited[0] == '/') {
            array_shift($pathSplited);
        }

        return $pathSplited;
    }

    protected function getCustomPath(): string
    {
        if (array_key_exists('path', $this->options()) && ! is_null($this->option('path'))) {
            return $this->directoryPath.'/'.$this->getClearCustomCapitalizedPath();
        }

        return $this->directoryPath;
    }

    protected function getNameSpace(): string
    {
        $pathFormattedForNamespace = str_replace('/', '\\', $this->getCustomPath());

        return "Modules\\{$this->argument('module')}\\$pathFormattedForNamespace";
    }
}
