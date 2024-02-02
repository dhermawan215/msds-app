<?php

namespace App\Http\Controllers;

use App\Helper\SysMenu;
use App\Models\SysModulMenu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AdminModul extends Controller
{
    protected $sysModuleName = 'module_management';

    private function modulePermission()
    {
        return SysMenu::menuSetingPermission($this->sysModuleName);
    }

    public function index()
    {
        $modulePermission = $this->modulePermission();
        $moduleFn = \json_decode($modulePermission->fungsi, true);

        if ($modulePermission->is_akses) {

            return \view('admin.modul.index', ['moduleFn' => $moduleFn]);
        }

        return \view('forbiden-403');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'route_name' => 'required',
            'link_path' => 'required',
            'description' => 'required',
        ]);

        if ($validator->fails()) {
            return \response()->json($validator->errors(), 403);
        }

        // save data
        $created_by = Auth::user()->name;

        $save = SysModulMenu::create([
            'name' => $request->name,
            'route_name' => $request->route_name,
            'link_path' => $request->link_path,
            'description' => $request->description,
            'icon' => $request->icon,
            'created_by' => $created_by
        ]);

        return \response()->json(['success' => true, 'data' => 'module added'], 200);
    }

    public function tableData(Request $request)
    {
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
            $data['route'] = $value->route_name;
            $data['path'] = $value->link_path;
            $data['action'] = '<div class="d-flex">
                <a href="' . \route('admin_module.edit', \base64_encode($value->id)) . '" class="text-primary text-decoration-none mr-1" title="edit-module"> <i class="fas fa-edit"></i></a>
                </div>';
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

    public function edit($id)
    {
        $modulePermission = $this->modulePermission();
        $moduleFn = \json_decode($modulePermission->fungsi, true);
        if (!$modulePermission->is_akses && !\in_array('edit', $moduleFn)) {
            return \view('forbiden-403');
        }

        $moduleData = SysModulMenu::find(\base64_decode($id));

        return \view('admin.modul.edit', ['moduleData' => $moduleData]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'route_name' => 'required',
            'link_path' => 'required',
            'description' => 'required',
        ]);

        if ($validator->fails()) {
            return \response()->json($validator->errors(), 403);
        }
        // update
        $moduleData = SysModulMenu::find(\base64_decode($id));
        $moduleData->update([
            'name' => $request->name,
            'route_name' => $request->route_name,
            'link_path' => $request->link_path,
            'description' => $request->description,
            'icon' => $request->icon,
        ]);

        $redirect = \route('admin_module');

        return \response()->json(['success' => true, 'data' => 'update success', 'redirect' => $redirect], 200);
    }
}
