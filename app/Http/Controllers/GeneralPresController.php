<?php

namespace App\Http\Controllers;

use App\Helper\SysMenu;
use App\Models\MasterGeneralPrecautionaryStatements;
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
    /**
     * @method for datatable environmental hazard
     * @return json
     */
    public function listData(Request $request)
    {
        $modulePermission = $this->modulePermission();
        $moduleFn = \json_decode($modulePermission->fungsi, true);

        $draw = $request['draw'];
        $offset = $request['start'] ? $request['start'] : 0;
        $limit = $request['length'] ? $request['length'] : 15;
        $globalSearch = $request['search']['value'];

        $query = MasterGeneralPrecautionaryStatements::select('*');

        if ($globalSearch) {
            $query->where('code', 'like', '%' . $globalSearch . '%')
                ->orWhere('description', 'like', '%' . $globalSearch . '%');
        }

        $recordsFiltered = $query->count();

        $resData = $query->skip($offset)
            ->take($limit)
            ->get();

        $recordsTotal = $resData->count();

        $data = [];
        $i = $offset + 1;
        $arr = [];

        foreach ($resData as $key => $value) {
            $data['cbox'] = '<input type="checkbox" class="data-menu-cbox" value="' . $value->id . '">';
            $data['rnum'] = $i;
            $data['code'] = $value->code;
            $data['desc'] = $value->description;
            $data['lang'] = $value->language;
            $data['action'] = '';
            if (in_array('edit', $moduleFn) && in_array('detail', $moduleFn)) {
                $data['action'] = '<div class="d-flex">
                <a href="' . \route('environmental_hazard.edit', \base64_encode($value->id)) . '" class="btn btn-primary btn-sm mr-2"><i class="fas fa-edit " aria-hidden="true"></i>Edit</a>
                <a href="' . \route('environmental_hazard.detail', \base64_encode($value->id)) . '" class="btn btn-success btn-sm mr-2"><i class="fa fa-eye" aria-hidden="true"></i>Detail</a>
                </div>';
            } else if (in_array('detail', $moduleFn)) {
                $data['action'] = '<a href="' . \route('environmental_hazard.detail', \base64_encode($value->id)) . '" class="btn btn-success btn-sm"><i class="fa fa-eye" aria-hidden="true"></i>Detail</a>';
            } else if (in_array('edit', $moduleFn)) {
                $data['action'] = '<a href="' . \route('environmental_hazard.edit', \base64_encode($value->id)) . '" class="btn btn-primary btn-sm"><i class="fas fa-edit " aria-hidden="true"></i>Edit</a>';
            }

            $arr[] = $data;
            $i++;
        }

        return \response()->json([
            'draw' => $draw,
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data' => $arr,
        ]);
    }
}
