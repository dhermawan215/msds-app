<?php

namespace App\Http\Controllers\Rnd;

use Illuminate\Http\Request;
use App\Traits\ModulePermissions;
use App\Http\Controllers\Controller;
use App\Repository\StoragePreRepository;
use Illuminate\Support\Facades\Validator;
use App\Models\MasterStoragePrecautionaryStatements;
use Illuminate\Support\Facades\Auth;

class StoragePresController extends Controller
{
    //Storage Precautionary Controller
    use ModulePermissions;

    protected $sysModuleName = 'storage_precautionary';
    const valuePermission = ['add', 'edit', 'delete', 'detail'];
    private static $url;
    protected $storagePreRepository;

    public function __construct(StoragePreRepository $storagePreRepository)
    {
        $this->storagePreRepository = $storagePreRepository;
        static::$url = \route($this->sysModuleName);
    }
    /**
     * @return view
     */
    public function index()
    {
        $modulePermission = $this->permission($this->sysModuleName);
        if (!isset($modulePermission->is_akses) || $modulePermission->is_akses == 0) {
            return \view('forbiden-403');
        }
        $moduleFn = \json_decode($modulePermission->fungsi, true);
        return \view('pages.precaution-statements.storage.index', ['moduleFn' => $moduleFn]);
    }
    /**
     * datatable for storage precautionary statement
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

        $query = MasterStoragePrecautionaryStatements::select('*');

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
            if (in_array(static::valuePermission[2], $moduleFn)) {
                $data['cbox'] = '<input type="checkbox" class="data-menu-cbox" value="' . $value->id . '">';
            }
            $data['rnum'] = $i;
            $data['code'] = $value->code;
            $data['desc'] = $value->description;
            $data['lang'] = $value->language;
            $data['action'] = '';
            if (in_array(static::valuePermission[1], $moduleFn) && in_array(static::valuePermission[3], $moduleFn)) {
                $data['action'] = '<div class="d-flex">
                <a href="' . \route('storage_precautionary.edit', \base64_encode($value->id)) . '" class="btn btn-primary btn-sm mr-2" title="edit"><i class="fas fa-edit " aria-hidden="true"></i></a>
                <button class="btn btn-sm btn-success btn-detail" title="detail" data-toggle="modal" data-target="#modal-detail-storage-precautionary" data-dtl="' . base64_encode($value->id) . '"><i class="fa fa-eye" aria-hidden="true"></i></button>
                </div>';
            } else if (in_array(static::valuePermission[3], $moduleFn)) {
                $data['action'] = '<button class="btn btn-sm btn-success btn-detail" title="detail" data-toggle="modal" data-target="#modal-detail-storage-precautionary" data-dtl="' . base64_encode($value->id) . '"><i class="fa fa-eye" aria-hidden="true"></i></button>';
            } else if (in_array(static::valuePermission[1], $moduleFn)) {
                $data['action'] = '<a href="' . \route('storage_precautionary.edit', \base64_encode($value->id)) . '" class="btn btn-primary btn-sm mr-2" title="edit"><i class="fas fa-edit " aria-hidden="true"></i></a>';
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
     * store data
     * @return json
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required',
            'description' => 'required',
            'language' => 'required'
        ]);

        if ($validator->fails()) {
            return \response()->json($validator->errors(), 403);
        }
        $data = [
            'code' => $request->code,
            'description' => $request->description,
            'language' => $request->language,
            'created_by' => Auth::user()->name,
        ];
        $this->storagePreRepository->save($data);
        return \response()->json(['success' => true, 'message' => 'Data saved!'], 200);
    }
    /**
     * detail data
     * @return json
     */
    public function detail(Request $request)
    {
        $detailData = $this->storagePreRepository->showDetail(\base64_decode($request->dl));
        return \response()->json(['success' => \true, 'data' => $detailData], 200);
    }
    /**
     * edit data
     */
    public function edit($id)
    {
        $modulePermission = $this->permission($this->sysModuleName);
        if (!isset($modulePermission)) {
            return \view('forbiden-403');
        }
        $moduleFn = \json_decode($modulePermission->fungsi, true);
        if (!$modulePermission->is_akses || !in_array(static::valuePermission[1], $moduleFn)) {
            return \view('forbiden-403');
        }
        $detailData = $this->storagePreRepository->showDetail(\base64_decode($id));
        return \view('pages.precaution-statements.storage.edit', ['url' => static::$url, 'value' => $detailData]);
    }
    /**
     * handle update data
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required',
            'description' => 'required',
            'language' => 'required'
        ]);

        if ($validator->fails()) {
            return \response()->json($validator->errors(), 403);
        }

        $this->storagePreRepository->updateData($request);
        return \response()->json(['success' => true, 'message' => 'Update success!', 'url' => static::$url], 200);
    }
    /**
     * delete data
     */
    public function destroy(Request $request)
    {
        $ids = $request->dValue;
        $this->storagePreRepository->deleteData($ids);
        return \response()->json(['success' => true, 'message' => 'Delete success!'], 200);
    }
}
