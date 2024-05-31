<?php

namespace App\Helper;

use App\Models\SysModulMenu;
use App\Models\SysUserModulRole;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Facade;

class SysMenu extends Facade
{
    // menu permission in controller
    public static function menuSetingPermission($sysMenuName)
    {
        $auth = Auth::user();

        $menu = DB::table('sys_user_modul_roles AS a')
            ->select('a.*', 'b.name')
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

        return is_null($menu) ? \null : $menu->route_name;
    }

    // menu permission in sidebar
    public static function menuActivePermission()
    {
        $auth = Auth::user();
        $menu = DB::table('sys_user_modul_roles AS a')
            ->select('a.*', 'b.*')
            ->join('sys_modul_menus AS b', 'a.sys_modul_id', '=', 'b.id')
            ->where('a.sys_user_group_id', $auth->sys_group_id)
            ->where('is_akses', '1')
            ->orderBy('order_menu', 'ASC')
            ->get();

        return $menu;
    }
}
