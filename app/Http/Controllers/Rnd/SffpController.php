<?php

namespace App\Http\Controllers\Rnd;

use App\Models\MasterSsfp;
use Illuminate\Http\Request;
use App\Traits\ModulePermissions;
use App\Repository\SffpRepository;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SffpController extends Controller
{
    //controller module special fire fighting procedures
    use ModulePermissions;
    protected $sysModuleName = 'sffp';
    const valuePermission = ['add', 'edit', 'delete'];
    protected static $url;
    protected $sffpRepo;

    public function __construct(SffpRepository $sffpRepository)
    {
        $this->sffpRepo = $sffpRepository;
        static::$url = \route($this->sysModuleName);
    }

    public function index()
    {
        $modulePermission = $this->permission($this->sysModuleName);
        if (!isset($modulePermission->is_akses) || $modulePermission->is_akses == 0) {
            return \view('forbiden-403');
        }
        $moduleFn = \json_decode($modulePermission->fungsi, true);
        return \view('pages.msds.sffp.index', ['moduleFn' => $moduleFn]);
    }
    /**
     * datatable for sffp
     * @return json
     */
    public function listData(Request $request)
    {
        $modulePermission = $this->permission($this->sysModuleName);
        $moduleFn = \json_decode($modulePermission->fungsi, true);
        $draw = $request['draw'];
        $offset = $request['start'] ? $request['start'] : 0;
        $limit = $request['length'] ? $request['length'] : 15;
        $globalSearch = $request['search']['value'];

        $query = MasterSsfp::select('*');

        if ($globalSearch) {
            $query->where('notes', 'like', '%' . $globalSearch . '%')
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
            if (in_array(static::valuePermission[2], $moduleFn)) {
                $data['cbox'] = '<input type="checkbox" class="data-menu-cbox" value="' . $value->id . '">';
            }
            $data['rnum'] = $i;
            $data['desc'] = $value->description;
            $data['lang'] = $value->language;
            $data['note'] = $value->notes;
            $data['action'] = '';
            if (in_array(static::valuePermission[1], $moduleFn)) {
                $data['action'] = '<div class="d-flex">
                <button class="btn btn-sm btn-success btn-edit" title="edit" data-toggle="modal" data-target="#modal-edit-sffp" data-ed="' . base64_encode($value->id) . '"><i class="fa fa-edit" aria-hidden="true"></i></button>
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
    /**
     * method handle save data
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'description' => 'required',
            'language' => 'required'
        ]);

        if ($validator->fails()) {
            return \response()->json($validator->errors(), 403);
        }
        $data = [
            'notes' => $request->notes,
            'description' => $request->description,
            'language' => $request->language,
            'created_by' => Auth::user()->name,
        ];
        try {
            $this->sffpRepo->saveSffp($data);
            return \response()->json(['success' => true, 'message' => 'Data saved!'], 200);
        } catch (\Throwable $th) {
            return \response()->json(['success' => true, 'message' => 'Something went wrong'], 500);
        }
    }
    /**
     * method handle edit data
     */
    public function edit(Request $request)
    {
        try {
            $sffpData = $this->sffpRepo->detailSffp(\base64_decode($request->de));
            $data = [
                'description' => $sffpData->description,
                'notes' => $sffpData->notes,
            ];
            switch ($sffpData->language) {
                case 'EN':
                    $data['lang'] = 'Eglish';
                    $data['lang_value'] = 'EN';
                    break;

                default:
                    $data['lang'] = 'Indonesia';
                    $data['lang_value'] = 'ID';
                    break;
            }

            //convert data to array
            return \response()->json(['success' => \true, 'data' => $data], 200);
        } catch (\Throwable $th) {
            return \response()->json(['success' => \true, 'data' => 'Something went wrong'], 500);
        }
    }
    /**
     * method update data
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'description' => 'required',
            'language' => 'required'
        ]);

        if ($validator->fails()) {
            return \response()->json($validator->errors(), 403);
        }

        try {
            $this->sffpRepo->updateSffp($request);
            return \response()->json(['success' => \true, 'message' => 'Update success'], 200);
        } catch (\Throwable $th) {
            return \response()->json(['success' => \true, 'message' => 'Something went wrong'], 500);
        }
    }
    /**
     * method delete data
     */
    public function destroy(Request $request)
    {
        try {
            $this->sffpRepo->deleteSffp($request->dValue);
            return \response()->json(['success' => \true, 'message' => 'Delete success!'], 200);
        } catch (\Throwable $th) {
            return \response()->json(['success' => \true, 'message' => 'Something went wrong'], 500);
        }
    }
}
