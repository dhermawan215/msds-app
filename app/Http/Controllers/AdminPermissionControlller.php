<?php

namespace App\Http\Controllers;

use App\Helper\SysMenu;
use App\Models\SysModulMenu;
use App\Models\SysUserGroup;
use App\Models\SysUserModulRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminPermissionControlller extends Controller
{
    protected $sysModuleName = 'permission_management';

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
        $moduleFn = \json_decode(isset($modulePermission->fungsi), true);
        if (!isset($modulePermission->is_akses)) {
            return \view('forbiden-403');
        }
        return \view('admin.permission.index', ['moduleFn' => $moduleFn]);
    }

    public function tableData(Request $request)
    {
        $modulePermission = $this->modulePermission();
        $moduleFn = \json_decode($modulePermission->fungsi, true);

        $draw = $request['draw'];
        $offset = $request['start'] ? $request['start'] : 0;
        $limit = $request['length'] ? $request['length'] : 15;
        $globalSearch = $request['search']['value'];

        $query = SysModulMenu::select('*');

        if ($globalSearch) {
            $query->where('name', 'like', '%' . $globalSearch . '%')
                ->orWhere('route_name', 'like', '%' . $globalSearch . '%');
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
            $data['rnum'] = $i;
            $data['name'] = $value->name;
            $data['path'] = $value->link_path;
            $data['action'] = '';
            if (in_array('add', $moduleFn) && in_array('edit', $moduleFn)) {
                $data['action'] = '<div class="d-flex">
            <a href="' . \route('admin_permission.add', \base64_encode($value->id)) . '" class="text-primary text-decoration-none mr-1" title="Add Permission"> <i class="fa fa-plus-square"></i></a>
            <a href="' . \route('admin_permission.edit', \base64_encode($value->id)) . '" class="text-warning     text-decoration-none mr-1" title="Edit Permission"> <i class="fas fa-user-edit"></i></a>
            </div>';
            } else if (in_array('edit', $moduleFn)) {
                $data['action'] = '<div class="d-flex">
                <a href="' . \route('admin_permission.edit', \base64_encode($value->id)) . '" class="text-warning     text-decoration-none mr-1" title="Edit Permission"> <i class="fas fa-user-edit"></i></a>
                </div>';
            } else if (in_array('add', $moduleFn)) {
                $data['action'] = '<div class="d-flex">
                <a href="' . \route('admin_permission.add', \base64_encode($value->id)) . '" class="text-primary text-decoration-none mr-1" title="Add Permission"> <i class="fa fa-plus-square"></i></a>
                </div>';
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

    public function add($id)
    {
        $modulePermission = $this->modulePermission();
        $moduleFn = \json_decode($modulePermission->fungsi, true);

        if (!$modulePermission->is_akses || !in_array('add', $moduleFn)) {
            return \view('forbiden-403');
        }
        $menu = SysModulMenu::find(\base64_decode($id));
        $userGroup = SysUserGroup::all();
        return \view('admin.permission.add', ['module' => $id, 'userGroup' => $userGroup, 'menu' => $menu]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'is_akses' => 'required',
            'fungsi' => 'required',
        ], [
            'fungsi.required' => 'field function is required'
        ]);

        if ($validator->fails()) {
            return \response()->json($validator->errors(), 403);
        }
        $requestAll = $request->all();

        // convert function value (string to array), return array
        $fungsiArray = \explode(',', $request->fungsi);
        // convert to json 
        $requestAll['fungsi'] = \json_encode($fungsiArray);

        // save to db
        SysUserModulRole::create([
            'sys_modul_id' => \base64_decode($requestAll['moduleValue']),
            'sys_user_group_id' => $requestAll['groupValue'],
            'is_akses' => $requestAll['is_akses'],
            'fungsi' => $requestAll['fungsi']
        ]);

        $url = route('admin_permission');

        return \response()->json(['success' => \true, 'message' => 'data saved!', 'url' => $url]);
    }

    public function edit($id)
    {
        $modulePermission = $this->modulePermission();
        $moduleFn = \json_decode($modulePermission->fungsi, true);

        if (!$modulePermission->is_akses || !in_array('edit', $moduleFn)) {
            return \view('forbiden-403');
        }
        $menu = SysModulMenu::find(\base64_decode($id));
        $userGroup = SysUserGroup::all();
        return \view('admin.permission.edit', ['module' => $id, 'userGroup' => $userGroup, 'menu' => $menu]);
    }

    // function for response ajax
    public function dataEdit(Request $request)
    {
        $moduleValue = \base64_decode($request->mValue);
        $groupUserValue = $request->gValue;
        unset($request->_token);

        $permissionData = SysUserModulRole::where('sys_modul_id', $moduleValue)
            ->where('sys_user_group_id', $groupUserValue)->first();
        $data = [];

        if (\is_null($permissionData)) {
            return \response()->json(['success' => false, 'data' => 'null'], 404);
        }

        if ($permissionData->is_akses == '1') {
            $text = 'Yes';
        } else {
            $text = 'No';
        }
        $data['formValue'] = \base64_encode($permissionData->id);
        $data['id'] = $permissionData->is_akses;
        $data['text'] = $text;
        $fungsiFromDb = \json_decode($permissionData->fungsi, \true);
        $data['fungsi'] = \implode(',', $fungsiFromDb);

        return \response()->json(['success' => true, 'data' => $data], 200);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'is_akses' => 'required',
            'fungsi' => 'required',
        ], [
            'fungsi.required' => 'field function is required'
        ]);

        if ($validator->fails()) {
            return \response()->json($validator->errors(), 403);
        }

        // find data
        $sysUserModuleRoles = SysUserModulRole::find(\base64_decode($request->formValue));
        $sysModuleId = \base64_decode($request->moduleValue);
        $sysUserGroupId = $request->groupValue;

        $fungsiArray = \explode(',', $request->fungsi);
        // convert to json 
        $fungsi = \json_encode($fungsiArray);

        $sysUserModuleRoles->update([
            'sys_modul_id' => $sysModuleId,
            'sys_user_group_id' => $sysUserGroupId,
            'is_akses' => $request->is_akses,
            'fungsi' => $fungsi
        ]);

        return \response()->json(['success' => true, 'message' => 'Data was updated!'], 200);
    }
}
