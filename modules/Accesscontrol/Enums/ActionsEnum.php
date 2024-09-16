<?php

namespace Modules\Accesscontrol\Enums;

enum ActionsEnum: string
{
    case VIEW = 'view';
    case CREATE = 'create';
    case UPDATE = 'update';
    case DELETE = 'delete';
    case EXPORT = 'export';
}
