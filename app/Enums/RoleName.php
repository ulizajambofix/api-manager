<?php

namespace App\Enums;

enum RoleName: string
{
    case Admin = 'admin';
    case Developer = 'developer';
    case Viewer = 'viewer';
}
