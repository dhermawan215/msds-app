<?php

namespace App\Http\Controllers;

use App\Helper\SysMenu;
use Illuminate\Http\Request;

class GeneralPresController extends Controller
{
    /**
     * controller for module general precautionary statement
     */
    protected $sysModuleName = 'general_precautionary';

    private static $url;

    public function __construct()
    {
        static::$url = \route('general_precautionary');
    }

    private function modulePermission()
    {
        return SysMenu::menuSetingPermission($this->sysModuleName);
    }
    /**
     * @return view
     */
    public function index()
    {
        /**
         * check permission this module(security update)
         */
        $modulePermission = $this->modulePermission();
        $moduleFn = \json_decode(isset($modulePermission->fungsi), true);
        if (!isset($modulePermission->is_akses)) {
            return \view('forbiden-403');
        }
        return \view('pages.precaution-statements.general-precautionary.index', ['moduleFn' => $moduleFn]);
    }
}
