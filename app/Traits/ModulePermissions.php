<?php

namespace App\Traits;

use App\Helper\SysMenu;

trait ModulePermissions
{
    /**
     * traits handle initialize module permission
     * @param moduleName null
     * @return eloquent array
     */
    public function permission($moduleName = null)
    {
        return SysMenu::menuSetingPermission($moduleName);
    }
}
