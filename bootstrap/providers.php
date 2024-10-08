<?php

return [
    App\Providers\AppServiceProvider::class,
    Modules\Authentication\Providers\AuthenticationServiceProvider::class,
    Modules\Accesscontrol\Providers\AccesscontrolServiceProvider::class,
    Modules\Modulename\Providers\ModulenameServiceProvider::class,
];
