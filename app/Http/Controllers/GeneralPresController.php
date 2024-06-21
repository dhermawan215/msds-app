<?php

namespace App\Http\Controllers;

use App\Helper\SysMenu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\MasterGeneralPrecautionaryStatements;

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
        if (!isset($modulePermission->is_akses) || $modulePermission->is_akses == 0) {
            return \view('forbiden-403');
        }
        $moduleFn = \json_decode($modulePermission->fungsi, true);
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
            $data['cbox'] = '';
            if (in_array('delete', $moduleFn)) {
                $data['cbox'] = '<input type="checkbox" class="data-menu-cbox" value="' . $value->id . '">';
            }
            $data['rnum'] = $i;
            $data['code'] = $value->code;
            $data['desc'] = $value->description;
            $data['lang'] = $value->language;
            $data['action'] = '';
            if (in_array('edit', $moduleFn) && in_array('detail', $moduleFn)) {
                $data['action'] = '<div class="d-flex">
                <a href="' . \route('general_precautionary.edit', \base64_encode($value->id)) . '" class="btn btn-primary btn-sm mr-2"><i class="fas fa-edit " aria-hidden="true"></i>Edit</a>
                <a href="' . \route('general_precautionary.detail', \base64_encode($value->id)) . '" class="btn btn-success btn-sm mr-2"><i class="fa fa-eye" aria-hidden="true"></i>Detail</a>
                </div>';
            } else if (in_array('detail', $moduleFn)) {
                $data['action'] = '<a href="' . \route('general_precautionary.detail', \base64_encode($value->id)) . '" class="btn btn-success btn-sm"><i class="fa fa-eye" aria-hidden="true"></i>Detail</a>';
            } else if (in_array('edit', $moduleFn)) {
                $data['action'] = '<a href="' . \route('general_precautionary.edit', \base64_encode($value->id)) . '" class="btn btn-primary btn-sm"><i class="fas fa-edit " aria-hidden="true"></i>Edit</a>';
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
     * @method handle for add data general precautionary
     * @return view
     */
    public function add()
    {
        $modulePermission = $this->modulePermission();
        $moduleFn = \json_decode($modulePermission->fungsi, true);
        if (!$modulePermission->is_akses || !in_array('add', $moduleFn)) {
            return \view('forbiden-403');
        }
        return \view('pages.precaution-statements.general-precautionary.add', ['url' => static::$url]);
    }
    /**
     * handling for request save data from view 
     * @return json
     */
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

        $created = MasterGeneralPrecautionaryStatements::create([
            'code' => $request->code,
            'description' => $request->description,
            'language' => $request->language,
            'created_by' => $user->name
        ]);

        return \response()->json(['success' => true, 'message' => 'Data saved!', 'url' => static::$url], 200);
    }
    /**
     * this method handle request detail data
     * @param id 
     * @return view with array
     */
    public function detail($id)
    {
        $modulePermission = $this->modulePermission();
        $moduleFn = \json_decode($modulePermission->fungsi, true);
        if (!$modulePermission->is_akses || !in_array('detail', $moduleFn)) {
            return \view('forbiden-403');
        }

        $data = MasterGeneralPrecautionaryStatements::select('code', 'description', 'language')->find(\base64_decode($id));
        return \view('pages.precaution-statements.general-precautionary.detail', ['url' => static::$url, 'value' => $data]);
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
        $data = MasterGeneralPrecautionaryStatements::find(\base64_decode($id));
        return \view('pages.precaution-statements.general-precautionary.edit', ['url' => static::$url, 'value' => $data]);
    }
    /**
     * this method handle request update data
     * @param id 
     * @return json
     */
    public function update(Request $request, $id)
    {
        $dataDb = MasterGeneralPrecautionaryStatements::find(\base64_decode($id));

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
        return \response()->json(['success' => true, 'message' => 'Update success!', 'url' => static::$url], 200);
    }
    /**
     * handle for request delete data
     * @param array
     * @return json
     */
    public function delete(Request $request)
    {
        $ids = $request->dValue;
        $environmentalData = MasterGeneralPrecautionaryStatements::whereIn('id', $ids);
        $environmentalData->delete();

        return \response()->json(['success' => true, 'message' => 'Data Deleted'], 200);
    }
}
