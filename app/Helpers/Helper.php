<?php

namespace App\Helpers;

class Helper
{

    public static function has_role($role)
    {
        if (in_array('super-admin', auth()->user()?->roles()->pluck('slug')->toArray()) || in_array('super-user', auth()->user()?->roles()->pluck('slug')->toArray())) {
            return true;
        } else {
            if (in_array($role, auth()->user()?->roles()->pluck('slug')->toArray())) {
                return true;
            } else {
                return false;
            }
        }
    }

    public static function is_super_admin()
    {
        if (in_array('super-admin', auth()->user()?->roles()->pluck('slug')->toArray())) {
            return true;
        } else {
            return false;
        }
    }

    public static function has_permission($permission)
    {
        if (in_array('super-admin', auth()->user()?->roles()->pluck('slug')->toArray()) || in_array('super-user', auth()->user()?->roles()->pluck('slug')->toArray())) {
            return true;
        } else {
            // in_array($permission, auth()->user()?->permissions()->pluck('slug')->toArray())
            if (in_array($permission,  auth()->user()?->roles->pluck('permissions')->flatten()->pluck('slug')->unique()->toArray())) {
                return true;
            } else {
                return false;
            }
        }
    }
}
