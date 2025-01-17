<?php

namespace App\Enum;
enum EnumRoles: string
{
    case ROLE_ADMIN = 'administrateur';
    case ROLE_USER = 'utilisateur';
}