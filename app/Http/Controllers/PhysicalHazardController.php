<?php

namespace App\Http\Controllers;

use App\Helper\SysMenu;
use App\Models\MasterPhysicalHazard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PhysicalHazardController extends Controller
{
    protected $sysModuleName = 'physical_hazard';

    private static $url;

    public function __construct()
    {
        static::$url = \route('physical_hazard');
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
        if (!isset($modulePermission->is_akses)) {
            return \view('forbiden-403');
        }
        $moduleFn = \json_decode($modulePermission->fungsi, true);
        return \view('pages.physical-hazard.index', ['moduleFn' => $moduleFn]);
    }

    public function tableData(Request $request)
    {
        $modulePermission = $this->modulePermission();
        $moduleFn = \json_decode($modulePermission->fungsi, true);

        $draw = $request['draw'];
        $offset = $request['start'] ? $request['start'] : 0;
        $limit = $request['length'] ? $request['length'] : 15;
        $globalSearch = $request['search']['value'];

        $query = MasterPhysicalHazard::select('*');

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
            $data['rnum'] = $i;
            $data['code'] = $value->code;
            $data['desc'] = $value->description;
            $data['lang'] = $value->language;
            $data['action'] = '';
            if (in_array('detail', $moduleFn) && in_array('delete', $moduleFn) && in_array('edit', $moduleFn)) {
                $data['action'] = '<div class="d-flex">
                <a href="' . \route('physical_hazard.edit', \base64_encode($value->id)) . '" class="btn btn-primary btn-sm mr-2"><i class="fas fa-edit " aria-hidden="true"></i>Edit</a>
                <a href="' . \route('physical_hazard.detail', \base64_encode($value->id)) . '" class="btn btn-success btn-sm mr-2"><i class="fa fa-eye" aria-hidden="true"></i>Detail</a>
                <button class="btn btn-danger btn-sm btn-delete-data" data-button="' . \base64_encode($value->id) . '"><i class="fa fa-trash" aria-hidden="true"></i>Delete</button>
                </div>';
            } else if (in_array('delete', $moduleFn)) {
                $data['action'] = '<button class="btn btn-danger btn-sm btn-delete-data" data-button="' . \base64_encode($value->id) . '"><i class="fa fa-trash" aria-hidden="true"></i>Delete</button>';
            } else if (in_array('detail', $moduleFn)) {
                $data['action'] = '<a href="' . \route('physical_hazard.detail', \base64_encode($value->id)) . '" class="btn btn-success btn-sm"><i class="fa fa-eye" aria-hidden="true"></i>Detail</a>';
            } else if (in_array('edit', $moduleFn)) {
                $data['action'] = '<a href="' . \route('physical_hazard.edit', \base64_encode($value->id)) . '" class="btn btn-primary btn-sm"><i class="fas fa-edit " aria-hidden="true"></i>Edit</a>';
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

    public function add()
    {
        $modulePermission = $this->modulePermission();
        $moduleFn = \json_decode($modulePermission->fungsi, true);
        if (!$modulePermission->is_akses || !in_array('add', $moduleFn)) {
            return \view('forbiden-403');
        }

        return \view('pages.physical-hazard.add');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|string|max:50',
            'description' => 'required',
            'language' => 'required',
        ]);

        if ($validator->fails()) {
            return \response()->json($validator->errors(), 403);
        }
        $user = Auth::user();

        $created = MasterPhysicalHazard::create([
            'code' => $request->code,
            'description' => $request->description,
            'language' => $request->language,
            'created_by' => $user->name
        ]);

        return \response()->json(['success' => true, 'message' => 'Data saved!', 'url' => static::$url], 200);
    }

    public function detail($id)
    {
        $modulePermission = $this->modulePermission();
        $moduleFn = \json_decode($modulePermission->fungsi, true);
        if (!$modulePermission->is_akses || !in_array('detail', $moduleFn)) {
            return \view('forbiden-403');
        }

        $dataPhysical = MasterPhysicalHazard::find(\base64_decode($id));

        return \view('pages.physical-hazard.detail', ['dataPhysical' => $dataPhysical]);
    }

    public function edit($id)
    {
        $modulePermission = $this->modulePermission();
        $moduleFn = \json_decode($modulePermission->fungsi, true);
        if (!$modulePermission->is_akses || !in_array('edit', $moduleFn)) {
            return \view('forbiden-403');
        }

        $dataDb = MasterPhysicalHazard::find(\base64_decode($id));

        return \view('pages.physical-hazard.edit', ['value' => $dataDb]);
    }

    public function update(Request $request, $id)
    {
        $dataDb = MasterPhysicalHazard::find(\base64_decode($id));

        $validator = Validator::make($request->all(), [
            'code' => 'required|string|max:50',
            'description' => 'required',
            'language' => 'required',
        ]);

        if ($validator->fails()) {
            return \response()->json($validator->errors(), 403);
        }

        $dataDb->update([
            'code' => $request->code,
            'description' => $request->description,
            'language' => $request->language
        ]);

        return \response()->json(['success' => true, 'message' => 'Data Updated!', 'url' => static::$url], 200);
    }

    public function delete($id)
    {
        $dataDb = MasterPhysicalHazard::find(\base64_decode($id));
        $dataDb->delete();

        return \response()->json(['success' => true, 'message' => 'Data Deleted!'], 200);
    }
}
