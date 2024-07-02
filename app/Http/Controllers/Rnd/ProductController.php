<?php

namespace App\Http\Controllers\Rnd;

use App\Helper\SysMenu;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    //controller product management
    protected $sysModuleName = 'product';
    private static $url;

    public function __construct()
    {
        static::$url = \route('product');
    }
    /**
     * initialize permission
     */
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
        return \view('rnd.product.index', ['moduleFn' => $moduleFn]);
    }
    /**
     * @method for datatable product
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

        $query = Product::select('*');

        if ($globalSearch) {
            $query->where('product_code', 'like', '%' . $globalSearch . '%')
                ->orWhere('product_name', 'like', '%' . $globalSearch . '%')
                ->orWhere('product_function', 'like', '%' . $globalSearch . '%')
                ->orWhere('product_application', 'like', '%' . $globalSearch . '%');
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
            $data['code'] = $value->product_code;
            $data['name'] = $value->product_name;
            $data['function'] = $value->product_function;
            $data['application'] = $value->product_application;
            $data['action'] = '';
            if (in_array('edit', $moduleFn)) {
                $data['action'] = '<button id="#btn-edit" class="btn btn-sm btn-primary btn-edit" data-edit="' . base64_encode($value->id) . '" data-toggle="modal" data-target="#modal-edit-product" titlr="edit"><i class="fas fa-edit " aria-hidden="true"></i></button>';
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
     * handle request save data product
     * @return json
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_code' => 'required|max:100',
            'product_function' => 'required|max:255',
            'product_application' => 'required|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 403);
        }
        $user = Auth::user();
        $createdProduct = Product::create([
            'product_code' => $request->product_code,
            'product_name' => $request->product_name,
            'product_function' => $request->product_function,
            'product_application' => $request->product_application,
            'created_by' => $user->name,
        ]);

        return response()->json(['success' => true, 'message' => 'Data saved!'], 200);
    }
    /**
     * handle request update data product
     * @return json
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_code' => 'required|max:100',
            'product_function' => 'required|max:255',
            'product_application' => 'required|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 403);
        }
        $user = Auth::user();
        $updateProduct = Product::find(base64_decode($request->formValue));
        $updateProduct->update([
            'product_code' => $request->product_code,
            'product_name' => $request->product_name,
            'product_function' => $request->product_function,
            'product_application' => $request->product_application,
            'created_by' => $user->name,
        ]);

        return response()->json(['success' => true, 'message' => 'Update success!'], 200);
    }
    /**
     * handle for request delete data
     * @param array
     * @return json
     */
    public function destroy(Request $request)
    {
        $ids = $request->dValue;
        $environmentalData = Product::whereIn('id', $ids);
        $environmentalData->delete();
        return \response()->json(['success' => true, 'message' => 'Data Deleted'], 200);
    }
}
