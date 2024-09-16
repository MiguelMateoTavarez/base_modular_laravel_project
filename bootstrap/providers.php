<?php

return [
    App\Providers\AppServiceProvider::class,
    Modules\Crm\Providers\CrmServiceProvider::class,
    Modules\Security\Providers\SecurityServiceProvider::class,
    Modules\Authentication\Providers\AuthenticationServiceProvider::class,
    Modules\Accesscontrol\Providers\AccesscontrolServiceProvider::class,
];
