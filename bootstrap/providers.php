<?php

return [
    App\Providers\AppServiceProvider::class,
    Modules\Authentication\Providers\AuthenticationServiceProvider::class,
    Modules\Accesscontrol\Providers\AccesscontrolServiceProvider::class,
    Modules\Testmodule\Providers\TestmoduleServiceProvider::class,
    Modules\TestModule\Providers\TestModuleServiceProvider::class,
];
