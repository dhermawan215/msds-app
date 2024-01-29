<?php

namespace App\Helper;

use App\Models\SysModulMenu;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use function PHPUnit\Framework\isNull;

class SysMenu
{
    public static function menuSetingPermission($sysMenuName)
    {
        $auth = Auth::user();

        $menu = DB::table('sys_user_modul_roles AS a')
            ->select('a.*')
            ->join('sys_modul_menus AS b', 'a.sys_modul_id', '=', 'b.id')
            ->where('a.sys_user_group_id', $auth->sys_group_id)
            ->where('b.name', $sysMenuName)
            ->first();
        return $menu;
    }

    public static function getRouteName($sysMenuName)
    {
        $menu = SysModulMenu::where('name', $sysMenuName)
            ->first();

        return is_null($menu) ? Null : $menu->route_name;
    }
}
