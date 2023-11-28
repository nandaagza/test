<?php
namespace App\Enums;

enum Role:string
{
    case ADMIN = 'admin';
    case SUPERVISOR ='supervisor';
    case SURVEYOR ='surveryor';

    public static function __callStatic($name, $arguments)
    {
        return constant("self::{$name}")->value;
    }
}
