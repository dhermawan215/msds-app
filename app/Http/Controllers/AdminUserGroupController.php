<?php

namespace App\Http\Controllers;

use App\Helper\SysMenu;
use Illuminate\Support\Str;
use App\Models\SysUserGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AdminUserGroupController extends Controller
{
    //admin user group controller
    protected $sysModuleName = 'user_group';

    private static $url;

    public function __construct()
    {
        static::$url = \route('user_group');
    }

    private function modulePermission()
    {
        return SysMenu::menuSetingPermission($this->sysModuleName);
    }

    public function index()
    {
        /**
         * check permission this module(security update)
         */
        $modulePermission = $this->modulePermission();
        if (!isset($modulePermission->is_akses) || $modulePermission->is_akses == 0) {
            return \view('forbiden-403');
        }
        $moduleFn = \json_decode($modulePermission->fungsi, true);
        return \view('admin.user-group.index', ['moduleFn' => $moduleFn]);
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

        $query = SysUserGroup::select('*');

        if ($globalSearch) {
            $query->where('name', 'like', '%' . $globalSearch . '%');
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
            $data['cbox'] = '';
            if (in_array('delete', $moduleFn)) {
                $data['cbox'] = '<input type="checkbox" class="data-menu-cbox" value="' . $value->id . '">';
            }
            $data['rnum'] = $i;
            $data['name'] = $value->name;
            $data['id_group'] = $value->id_group;
            $data['action'] = '';
            if (in_array('edit', $moduleFn)) {
                $data['action'] = '<a href="' . \route('user_group.edit', \base64_encode($value->id)) . '" class="btn btn-primary btn-sm"><i class="fas fa-edit " aria-hidden="true"></i>Edit</a>';
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
    /**
     * @method handle save user group
     * @return json
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:50',
        ]);

        if ($validator->fails()) {
            return \response()->json($validator->errors(), 403);
        }
        $user = Auth::user();
        $nameToLower = Str::lower($request->name);
        SysUserGroup::create([
            'name' => $request->name,
            'id_group' => Str::slug($nameToLower, '-'),
            'created_by' => $user->name,
        ]);

        return \response()->json(['success' => true, 'message' => 'Data saved!'], 200);
    }
    /**
     * this method handle request edit data
     * @param id 
     * @return view with array
     */
    public function edit($id)
    {
        $modulePermission = $this->modulePermission();
        $moduleFn = \json_decode($modulePermission->fungsi, true);
        if (!$modulePermission->is_akses || !in_array('edit', $moduleFn)) {
            return \view('forbiden-403');
        }
        $data = SysUserGroup::find(\base64_decode($id));
        return \view('admin.user-group.edit', ['url' => static::$url, 'value' => $data]);
    }
    /**
     * @method handle update user group
     * @return json
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:50',
        ]);

        if ($validator->fails()) {
            return \response()->json($validator->errors(), 403);
        }
        $user = Auth::user();
        $nameToLower = Str::lower($request->name);
        $userGroup = SysUserGroup::find(base64_decode($id));

        $userGroup->update([
            'name' => $request->name,
            'id_group' => Str::slug($nameToLower, '-')
        ]);

        return \response()->json(['success' => true, 'message' => 'Update success', 'url' => static::$url], 200);
    }
    /**
     * handle delete data
     * @return json
     */
    public function delete(Request $request)
    {
        $ids = $request->dValue;
        $environmentalData = SysUserGroup::whereIn('id', $ids);
        $environmentalData->delete();

        return \response()->json(['success' => true, 'message' => 'Data Deleted'], 200);
    }
}
