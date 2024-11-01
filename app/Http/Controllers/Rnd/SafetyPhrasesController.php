<?php

namespace App\Http\Controllers\Rnd;

use Illuminate\Http\Request;
use App\Traits\ModulePermissions;
use App\Http\Controllers\Controller;
use App\Models\MasterSafetyPhrases;
use App\Repository\SafetyPhrasesRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SafetyPhrasesController extends Controller
{
    //controller for module risk phrases - regulatory informatio
    use ModulePermissions;
    protected $sysModuleName = 'safety_phrases';
    const valuePermission = ['add', 'edit', 'delete'];
    protected static $url;
    protected $safetyPhraseRepo;

    public function __construct(SafetyPhrasesRepository $safetyPhrasesRepository)
    {
        $this->safetyPhraseRepo = $safetyPhrasesRepository;
    }

    public function index()
    {
        $modulePermission = $this->permission($this->sysModuleName);
        if (!isset($modulePermission->is_akses) || $modulePermission->is_akses == 0) {
            return \view('forbiden-403');
        }
        $moduleFn = \json_decode($modulePermission->fungsi, true);
        return \view('pages.msds.safety-phrases.index', ['moduleFn' => $moduleFn]);
    }

    /**
     * datatable for pmif
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

        $query = MasterSafetyPhrases::select('*');

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
            $data['desc'] = $value->description;
            $data['lang'] = $value->language;
            $data['code'] = $value->code;
            $data['action'] = '';
            if (in_array(static::valuePermission[1], $moduleFn)) {
                $data['action'] = '<div class="d-flex">
                <button class="btn btn-sm btn-success btn-edit" title="edit" data-toggle="modal" data-target="#modal-edit-safety-phrases" data-ed="' . base64_encode($value->id) . '"><i class="fa fa-edit" aria-hidden="true"></i></button>
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
        try {
            $this->safetyPhraseRepo->saveSafetyPhrases($data);
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
            $safetyData = $this->safetyPhraseRepo->detailSafetyPhrases(\base64_decode($request->de));
            $data = [
                'description' => $safetyData->description,
                'code' => $safetyData->code,
            ];
            switch ($safetyData->language) {
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
            'code' => 'required',
            'description' => 'required',
            'language' => 'required'
        ]);

        if ($validator->fails()) {
            return \response()->json($validator->errors(), 403);
        }
        try {
            $this->safetyPhraseRepo->updateSafetyPhrases($request);
            return \response()->json(['success' => true, 'message' => 'Update success'], 200);
        } catch (\Throwable $th) {
            return \response()->json(['success' => true, 'message' => 'Something went wrong'], 500);
        }
    }
    /**
     * method delete data
     */
    public function destroy(Request $request)
    {
        try {
            $this->safetyPhraseRepo->deleteSafetyPhrases($request->dValue);
            return \response()->json(['success' => \true, 'message' => 'Delete success!'], 200);
        } catch (\Throwable $th) {
            return \response()->json(['success' => \true, 'message' => 'Something went wrong'], 500);
        }
    }
}
