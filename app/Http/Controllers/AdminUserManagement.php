<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Helper\SysMenu;
use App\Models\SysUserGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminUserManagement extends Controller
{
    protected $sysModuleName = 'user_management';

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
        return \view('admin.users-management.index', ['moduleFn' => $moduleFn]);
    }

    public function tableData(Request $request)
    {
        $modulePermission = $this->modulePermission();
        $moduleFn = \json_decode($modulePermission->fungsi, true);

        $draw = $request['draw'];
        $offset = $request['start'] ? $request['start'] : 0;
        $limit = $request['length'] ? $request['length'] : 15;
        $globalSearch = $request['search']['value'];

        $query = User::with('userGroup')->select('*');
        $query->where('sys_group_id', '>', '1');
        if ($globalSearch) {
            $query->where('name', 'like', '%' . $globalSearch . '%')
                ->orWhere('email', 'like', '%' . $globalSearch . '%');
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
            $data['email'] = $value->email;
            $data['roles'] = $value->userGroup->name;
            // checkbox status active
            if ('1' == $value->is_active) {
                $check = 'checked';
            } else {
                $check = '';
            }

            $status = '<div class=""><input class="activeuser" type="checkbox" data-toggle="' . \base64_encode($value->id) . '" id="customSwitch1" ' . $check . '></div>';

            $data['status'] = $status;

            if (in_array('edit', $moduleFn) && \in_array('change_password', $moduleFn)) {
                $data['action'] = '  <div class="d-flex">
                <a href="' . \route('admin_user_management.edit', \base64_encode($value->id)) . '" class="text-primary text-decoration-none mr-1" title="edit-user-data"> <i class="fas fa-user-edit"></i></a>
                <a href="' . route('admin_user_management.change_password', \base64_encode($value->id)) . '" class="text-danger text-decoration-none mr-1" title="change-password"> <i class="fa fa-unlock-alt text-danger" aria-hidden="true"></i></a>
                </div>';
            } else {
                $data['action'] = '';
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

    public function registerUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email|max:200',
            'password' => 'required|string|min:8|regex:/[a-z]/|regex:/[A-Z]/|regex:/[0-9]/|regex:/[@$!%*#?&]/'
        ]);

        if ($validator->fails()) {
            return \response()->json($validator->errors(), 403);
        }

        // create user
        $registerUser = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'sys_group_id' => $request->roles,
            'is_active' => $request->is_active,
        ]);

        return \response()->json(['success' => \true, 'data' => 'success'], 200);
    }
    // function change active or disactive user
    public function changeActiveUser(Request $request)
    {
        $id = \base64_decode($request->cbxValue);

        $userActive = User::find($id);

        $userActive->update([
            'is_active' => (int) $request->acValue
        ]);

        return \response()->json(['success' => true, 'data' => 'user active has been changed'], 200);
    }

    // function view edit user data
    public function editUserData($id)
    {
        $modulePermission = $this->modulePermission();
        $moduleFn = \json_decode($modulePermission->fungsi, true);
        if (!$modulePermission->is_akses && !\in_array('edit', $moduleFn)) {
            return \view('forbiden-403');
        }

        $user = User::with('userGroup')->find(\base64_decode($id));
        $roles = SysUserGroup::where('id', '>', '1')->get();

        return \view('admin.users-management.edit-user', ['user' => $user, 'roles' => $roles]);
    }

    public function updateUserData(Request $request)
    {
        $userData = User::find(\base64_decode($request->form_value));

        if ($userData->email != $request->email) {
            // validasi untuk email yang berbeda
            $rules = [
                'name' => 'required|string',
                'email' => 'required|string|email|unique:users,email|max:200',
            ];
        } else {
            $rules = [
                'name' => 'required|string',
                'email' => 'required|string|email|max:200',
            ];
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return \response()->json($validator->errors(), 403);
        }

        // update
        $userData->update([
            'name' => $request->name,
            'email' => $request->email,
            'is_active' => $request->is_active,
            'sys_group_id' => $request->roles
        ]);

        return \response()->json(['success' => true, 'data' => 'data has been updated'], 200);
    }

    public function changePassword($id)
    {
        $modulePermission = $this->modulePermission();
        $moduleFn = \json_decode($modulePermission->fungsi, true);
        if (!$modulePermission->is_akses && !\in_array('change_password', $moduleFn)) {
            return \view('forbiden-403');
        }

        $user = User::select('id', 'name')->find(\base64_decode($id));
        return \view('admin.users-management.change-password', ['user' => $user]);
    }

    public function updatePassword(Request $request, $id)
    {
        $userData = User::find(\base64_decode($id));
        $validator = Validator::make($request->all(), [
            'new_password' => 'required|string|min:8|regex:/[a-z]/|regex:/[A-Z]/|regex:/[0-9]/|regex:/[@$!%*#?&]/|same:password_confirmation',
            'password_confirmation' => 'required|string|min:8|regex:/[a-z]/|regex:/[A-Z]/|regex:/[0-9]/|regex:/[@$!%*#?&]/'
        ]);

        if ($validator->fails()) {
            return \response()->json($validator->errors(), 403);
        }

        $userData->update(['password' => Hash::make($request->new_password)]);
        return \response()->json(['success' => true, 'data' => 'password has been updated', 'url' => \route('admin.user_mg')]);
    }
}
