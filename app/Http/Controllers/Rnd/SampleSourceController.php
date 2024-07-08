<?php

namespace App\Http\Controllers\Rnd;

use App\Models\SampleSource;
use Illuminate\Http\Request;
use App\Traits\ModulePermissions;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class SampleSourceController extends Controller
{
    //controller for sample source
    use ModulePermissions;
    protected $sysModuleName = 'sample_source';
    protected $nameOfModule = 'sample-source';
    const valuePermission = ['add', 'edit', 'delete'];
    private static $url;

    public function __construct()
    {
        static::$url = route($this->sysModuleName);
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
        return \view('rnd.sample-source.index', ['moduleFn' => $moduleFn, 'nameOfModule' => $this->nameOfModule]);
    }
    /**
     * @method for datatable sample source
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

        $query = SampleSource::select('*');

        if ($globalSearch) {
            $query->where('name', 'like', '%' . $globalSearch . '%')
                ->orWhere('address', 'like', '%' . $globalSearch . '%');
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
            $data['name'] = $value->name;
            $data['address'] = $value->address;
            $data['action'] = '';
            if (in_array(static::valuePermission[1], $moduleFn)) {
                $data['action'] = '<button id="#btn-edit" class="btn btn-sm btn-primary btn-edit" data-edit="' . base64_encode($value->id) . '" data-toggle="modal" data-target="#modal-edit-' . $this->nameOfModule . '" titlr="edit"><i class="fas fa-edit " aria-hidden="true"></i></button>';
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
     * handle request save data sample source
     * @return json
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'source_name' => 'required|max:100',
            'address' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 403);
        }

        $created = SampleSource::create([
            'name' => $request->source_name,
            'address' => $request->address,
        ]);

        return response()->json(['success' => true, 'message' => 'Data saved!'], 200);
    }
    /**
     * handle request update data sample source
     * @return json
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'source_name' => 'required|max:100',
            'address' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 403);
        }

        SampleSource::find(base64_decode($request->formValue))->update([
            'name' => $request->source_name,
            'address' => $request->address,
        ]);

        return response()->json(['success' => true, 'message' => 'Update success!'], 200);
    }
    /**
     * delete sample source @param multiple/single id
     * @return json 
     */
    public function destroy(Request $request)
    {
        $ids = $request->dValue;
        SampleSource::whereIn('id', $ids)->delete();
        return \response()->json(['success' => true, 'message' => 'Data Deleted'], 200);
    }
}
