<?php

namespace App\Http\Controllers\Rnd;

use App\Models\Ghs;
use App\Traits\LogoUpload;
use Illuminate\Http\Request;
use App\Traits\ModulePermissions;
use App\Http\Controllers\Controller;
use App\Repository\GhsRepository;
use Illuminate\Support\Facades\Validator;

class GhsController extends Controller
{
    use LogoUpload;
    use ModulePermissions;

    protected $sysModuleName = 'ghs';
    const valuePermission = ['add', 'edit', 'delete'];
    private static $url;

    protected $ghsRepository;

    public function __construct(GhsRepository $ghsRepository)
    {
        static::$url = \route('ghs');
        $this->ghsRepository = $ghsRepository;
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
        return \view('rnd.ghs.index', ['moduleFn' => $moduleFn]);
    }
    /**
     * @method for datatable ghs
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

        $query = Ghs::select('*');

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
            $data['logo'] = $value->path ? '<img width="100px" height="100px"  src="' . asset($value->path) . '" class="img-fluid" alt="' . $value->name . '">' : 'Image not found';
            $data['names'] = $value->name;
            $data['action'] = '';
            if (in_array(static::valuePermission[1], $moduleFn)) {
                $data['action'] = '<button id="btn-edit" class="btn btn-sm btn-primary btn-edit" data-eg="' . base64_encode($value->id) . '" data-toggle="modal" data-target="#modal-edit-ghs" title="edit"><i class="fas fa-edit " aria-hidden="true"></i></button>';
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
     * save data ghs
     * @return json
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:50',
            'picture' => 'required|mimes:png,jpg|max:1024'
        ]);

        if ($validator->fails()) {
            return \response()->json($validator->errors(), 403);
        }

        if ($request->hasFile('picture')) {
            $fileLogo = $request->file('picture');
            $path = $this->storeLogo($fileLogo, 'assets/ghs');
        }

        $data = [
            'name' => $request->name,
            'path' => $path,
        ];
        $this->ghsRepository->storeGhs($data);
        return \response()->json(['success' => \true, 'message' => 'Success!'], 200);
    }
    /**
     * update data ghs
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:50',
            'picture' => 'nullable|mimes:png,jpg|max:1024'
        ]);

        if ($validator->fails()) {
            return \response()->json($validator->errors(), 403);
        }

        $ghsData = Ghs::find(\base64_decode($request->formValue));
        if ($request->hasFile('picture')) {
            //cek path file from db
            if (!is_null($ghsData->path)) {
                $pathFile = parse_url($ghsData->path);
                $strPathFile = str_replace('\\', '/', $pathFile['path']);
                //delete old logo
                $unlinkOldFile = $this->deleteLogo($strPathFile);
                //store new logo
                $fileLogo = $request->file('picture');
                $pathNewFile = $this->storeLogo($fileLogo, 'assets/ghs');
            } else {
                //store logo
                $fileLogo = $request->file('picture');
                $pathNewFile = $this->storeLogo($fileLogo, 'assets/ghs');
            }

            //update with image
            $data = [
                'name' => $request->name,
                'path' => $pathNewFile
            ];
            $update = $this->ghsRepository->updateWithImage($data, $ghsData);
        }
        // update without imagge
        $data = ['name' => $request->name];
        $update = $this->ghsRepository->updateWithoutImage($data, $ghsData);
        return \response()->json(['success' => true, 'message' => 'Update success'], 200);
    }
    /**
     * delete data
     */
    public function destroy(Request $request)
    {
        $ids = $request->dValue;
        $ghs = Ghs::whereIn('id', $ids)->get();
        foreach ($ghs as $value) {
            $pathFileLogo = str_replace('\\', '/', $value->path);
            $unlinkLogo = $this->deleteLogo($pathFileLogo);
        }
        $this->ghsRepository->destroyGhs($ids);

        return \response()->json(['success' => true, 'message' => 'Delete success'], 200);
    }
}
