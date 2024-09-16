<?php

namespace Modules\Accesscontrol\Enums;

enum ActionsEnum: string
{
    case ASSIGN = 'assign';
    case CREATE = 'create';
    case DELETE = 'delete';
    case EXPORT = 'export';
    case IMPORT = 'import';
    case REMOVE = 'remove';
    case RESTORE = 'restore';
    case SEND = 'send';
    case UPDATE = 'update';
    case VIEW = 'view';
    case ASSIGN_ALL = 'assign-all';
    case CREATE_ALL = 'create-all';
    case DELETE_ALL = 'delete-all';
    case EXPORT_ALL = 'export-all';
    case IMPORT_ALL = 'import-all';
    case REMOVE_ALL = 'remove-all';
    case RESTORE_ALL = 'restore-all';
    case SEND_ALL = 'send-all';
    case UPDATE_ALL = 'update-all';
    case VIEW_ALL = 'view-all';
}
