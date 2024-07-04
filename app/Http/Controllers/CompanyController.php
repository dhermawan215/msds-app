<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Traits\LogoUpload;
use App\Traits\ModulePermissions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CompanyController extends Controller
{
    use LogoUpload;
    use ModulePermissions;
    //controller for company module
    protected $sysModuleName = 'company';
    const valuePermission = ['add', 'edit', 'delete', 'detail', 'change_logo'];

    private static $url;

    public function __construct()
    {
        static::$url = \route('company');
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
        return \view('admin.company.index', ['moduleFn' => $moduleFn]);
    }
    /**
     * handle save data company
     * @return json
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'company_name' => 'required|string|max:50',
            'phone' => 'required',
            'address' => 'required',
            'logo' => 'required|mimes:png,jpg|max:1024'
        ]);

        if ($validator->fails()) {
            return \response()->json($validator->errors(), 403);
        }

        $user = Auth::user();
        if ($request->hasFile('logo')) {
            $fileLogo = $request->file('logo');
            $path = $this->storeLogo($fileLogo, 'assets/company');
        }

        $createdCompany = Company::create([
            'name' => $request->company_name,
            'phone' => $request->phone,
            'address' => $request->address,
            'logo' => $path,
            'created_by' => $user->name,
        ]);
        return \response()->json(['success' => \true, 'message' => 'Data saved!'], 200);
    }
    /**
     * @method for datatable environmental hazard
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

        $query = Company::select('id', 'name', 'logo');

        if ($globalSearch) {
            $query->where('name', 'like', '%' . $globalSearch . '%');
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
            $data['logo'] = $value->logo ? '<img width="100px" height="100px"  src="' . asset($value->logo) . '" class="img-fluid" alt="' . $value->name . '">' : 'Image not found';
            $data['name'] = $value->name;
            $data['action'] = '';
            if (in_array(static::valuePermission[1], $moduleFn) && in_array(static::valuePermission[3], $moduleFn) && in_array(static::valuePermission[4], $moduleFn)) {
                $data['action'] = '<button id="btn-edit" class="btn btn-sm btn-primary btn-edit" data-edit="' . base64_encode($value->id) . '" data-toggle="modal" data-target="#modal-edit-company" title="edit"><i class="fas fa-edit " aria-hidden="true"></i></button>
                <button id="btn-detail" class="btn btn-sm btn-success btn-detail" title="detail" data-detail="' . base64_encode($value->id) . '" data-toggle="modal" data-target="#modal-detail-company"><i class="fa fa-eye" aria-hidden="true"></i></button>
                <button id="btn-change-logo" class="btn btn-sm btn-outline-danger btn-change-logo" data-change="' . base64_encode($value->id) . '" data-toggle="modal" data-target="#modal-change-logo" title="change logo"><i class="fa fa-retweet" aria-hidden="true"></i></button>';
            } elseif (in_array(static::valuePermission[1], $moduleFn)) {
                $data['action'] = '<button id="btn-edit" class="btn btn-sm btn-primary btn-edit" data-edit="' . base64_encode($value->id) . '" data-toggle="modal" data-target="#modal-edit-company" title="edit"><i class="fas fa-edit " aria-hidden="true"></i></button>';
            } elseif (in_array(static::valuePermission[3], $moduleFn)) {
                $data['action'] = '<button id="btn-detail" class="btn btn-sm btn-success btn-detail" title="detail" data-detail="' . base64_encode($value->id) . '" data-toggle="modal" data-target="#modal-detail-company"><i class="fa fa-eye" aria-hidden="true"></i></button>';
            } elseif (in_array(static::valuePermission[4], $moduleFn)) {
                $data['action'] = '<button id="btn-change-logo" class="btn btn-sm btn-outline-danger btn-change-logo" data-change="' . base64_encode($value->id) . '" data-toggle="modal" data-target="#modal-change-logo" title="change logo"><i class="fa fa-retweet" aria-hidden="true"></i></button>';
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
     * handle get detail data
     * @return json data
     */
    public function show(Request $request)
    {
        $company = Company::select('name', 'phone', 'address')
            ->where('id', base64_decode($request->sVal))->first();

        return response()->json(['success' => true, 'data' => $company], 200);
    }
    /**
     * handle update data
     * @return json
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'company_name' => 'required|string|max:50',
            'phone' => 'required',
            'address' => 'required',
        ]);
        if ($validator->fails()) {
            return \response()->json($validator->errors(), 403);
        }

        $companyData = Company::find(base64_decode($request->formValue));
        $companyData->update([
            'name' => $request->company_name,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);
        return \response()->json(['success' => \true, 'message' => 'Update success!'], 200);
    }
    /**
     * handle update logo 
     * @return json
     */
    public function updateLogo(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'logo' => 'required|mimes:png,jpg|max:1024'
        ]);
        if ($validator->fails()) {
            return \response()->json($validator->errors(), 403);
        }

        $companyData = Company::find(base64_decode($request->formValue));
        if ($request->hasFile('logo')) {
            //cek path file from db
            if (!is_null($companyData->logo)) {
                $pathFile = parse_url($companyData->logo);
                $strPathFile = str_replace('\\', '/', $pathFile['path']);
                //delete old logo
                $unlinkOldFile = $this->deleteLogo($strPathFile);
                //store new logo
                $fileLogo = $request->file('logo');
                $pathNewFile = $this->storeLogo($fileLogo, 'assets/company');
            } else {
                //store logo
                $fileLogo = $request->file('logo');
                $pathNewFile = $this->storeLogo($fileLogo, 'assets/company');
            }
        }
        //update data
        $companyData->update([
            'logo' => $pathNewFile
        ]);
        return \response()->json(['success' => \true, 'message' => 'Update logo success!'], 200);
    }
    /**
     * handle delete data
     * @return json
     */
    public function destroy(Request $request)
    {
        $ids = $request->dValue;
        $companyLogo = Company::select('logo')->whereIn('id', $ids)->get();
        $companyLogoCollect = collect($companyLogo);

        foreach ($companyLogoCollect as $value) {
            $pathFileLogo = str_replace('\\', '/', $value['logo']);
            $unlinkLogo = $this->deleteLogo($pathFileLogo);
        }
        $companyData = Company::whereIn('id', $ids);
        //delete data
        $companyData->delete();

        return response()->json(['success' => true, 'message' => 'Delete success!'], 200);
    }
}
