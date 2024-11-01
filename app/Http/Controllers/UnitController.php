<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use App\Helper\SysMenu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UnitController extends Controller
{
    //controller admin unit
    protected $sysModuleName = 'unit';
    private static $url;

    public function __construct()
    {
        static::$url = \route('unit');
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
        $modulePermission = $this->modulePermission();
        if (!isset($modulePermission->is_akses) || $modulePermission->is_akses == 0) {
            return \view('forbiden-403');
        }
        $moduleFn = \json_decode($modulePermission->fungsi, true);
        return \view('admin.unit.index', ['moduleFn' => $moduleFn]);
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

        $query = Unit::select('*');

        if ($globalSearch) {
            $query->where('unit_name', 'like', '%' . $globalSearch . '%');
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
            $data['name'] = $value->unit_name;
            $data['action'] = '';
            if (in_array('edit', $moduleFn)) {
                $data['action'] = '<button id="#btn-edit" class="btn btn-sm btn-primary btn-edit" data-edit="' . base64_encode($value->id) . '" data-toggle="modal" data-target="#modal-edit-unit"><i class="fas fa-edit " aria-hidden="true"></i>Edit</button>';
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
     * handle for request save data
     * @return json
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'unit_name' => 'required|string|max:50',
        ]);

        if ($validator->fails()) {
            return \response()->json($validator->errors(), 403);
        }
        $user = Auth::user();
        $createdUnit = Unit::create([
            'unit_name' => $request->unit_name,
            'created_by' => $user->name,
        ]);

        return \response()->json(['success' => true, 'message' => 'Data saved!'], 200);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'unit_name' => 'required|string|max:50',
        ]);

        if ($validator->fails()) {
            return \response()->json($validator->errors(), 403);
        }

        $unit = Unit::find(base64_decode($request->formValue));
        $unit->update([
            'unit_name' => $request->unit_name,
        ]);

        return \response()->json(['success' => true, 'message' => 'Update success!'], 200);
    }
    /**
     * handle for request delete data
     * @param array
     * @return json
     */
    public function destroy(Request $request)
    {
        $ids = $request->dValue;
        $environmentalData = Unit::whereIn('id', $ids);
        $environmentalData->delete();
        return \response()->json(['success' => true, 'message' => 'Data Deleted'], 200);
    }
}
