<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\CustomerDetail;
use Illuminate\Http\Request;
use App\Traits\ModulePermissions;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    //controller for customer module
    use ModulePermissions;
    protected $sysModuleName = 'customer';
    const valuePermission = ['add', 'edit', 'delete', 'detail', 'detail_add', 'detail_edit', 'detail_delete'];
    private static $url;

    public function __construct()
    {
        static::$url = route('customer');
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
        return \view('pages.customer.index', ['moduleFn' => $moduleFn]);
    }
    /**
     * @method for datatable customer
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
        $user = Auth::user();

        $query = Customer::select('id', 'customer_code', 'customer_name');
        if (0 == $request->customer_filter) {
            $query->where('user_id', $user->id);
        }

        if ($globalSearch) {
            $query->where(function ($q) use ($globalSearch) {
                $q->where('customer_code', 'like', '%' . $globalSearch . '%')
                    ->orWhere('customer_name', 'like', '%' . $globalSearch . '%');
            });
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
            $data['name'] = $value->customer_name;
            $data['code'] = $value->customer_code;
            $data['action'] = '';
            if (in_array(static::valuePermission[1], $moduleFn) && in_array(static::valuePermission[3], $moduleFn)) {
                $data['action'] = '<button id="#btn-edit" class="btn btn-sm btn-primary btn-edit" data-edit="' . base64_encode($value->id) . '" data-toggle="modal" data-target="#modal-edit-customer" title="edit"><i class="fas fa-edit " aria-hidden="true"></i></button>
                <a href="' . route('customer.detail', base64_encode($value->id)) . '" class="btn btn-sm btn-success" title="Add customer detail"><i class="fa fa-plus" aria-hidden="true"></i> Customer Detail</a>';
            } elseif (in_array(static::valuePermission[1], $moduleFn)) {
                $data['action'] = '<button id="#btn-edit" class="btn btn-sm btn-primary btn-edit" data-edit="' . base64_encode($value->id) . '" data-toggle="modal" data-target="#modal-edit-customer" title="edit"><i class="fas fa-edit " aria-hidden="true"></i></button>';
            } elseif (in_array(static::valuePermission[3], $moduleFn)) {
                $data['action'] = '<a href="' . route('customer.detail', base64_encode($value->id)) . '" class="btn btn-sm btn-success" title="Add customer detail"><i class="fa fa-plus" aria-hidden="true"></i> Customer Detail</a>';
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
     * handle save data
     * @return json
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer_name' => 'required|max:150',
            'customer_code' => 'nullable',
        ]);

        if ($validator->fails()) {
            return \response()->json($validator->errors(), 403);
        }
        $user = Auth::user();
        $date = Carbon::now();
        $createdCustomer = Customer::create([
            'customer_code' => $request->customer_code,
            'customer_name' => $request->customer_name,
            'user_id' => $user->id,
            'customer_registered_at' => $date->toDateString()
        ]);
        return \response()->json(['success' => \true, 'message' => 'Data saved!', 'url' => route('customer.detail', base64_encode($createdCustomer->id))], 200);
    }
    /**
     * handle update data
     * @return json
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer_name' => 'required|max:150',
            'customer_code' => 'nullable',
        ]);

        if ($validator->fails()) {
            return \response()->json($validator->errors(), 403);
        }
        $updateCustomer = Customer::find(base64_decode($request->formValue));
        $updateCustomer->update([
            'customer_code' => $request->customer_code,
            'customer_name' => $request->customer_name,
        ]);
        return \response()->json(['success' => \true, 'message' => 'Update success!'], 200);
    }
    /**
     * @param array single/multiple
     * @return json
     */
    public function destroy(Request $request)
    {
        $ids = $request->dValue;
        //delete customer data
        $customerData = Customer::whereIn('id', $ids);
        $customerData->delete();
        //delete customer detail data
        $customerDetail = CustomerDetail::whereIn('customer_id', $ids)->delete();
        return \response()->json(['success' => \true, 'message' => 'Delete success!'], 200);
    }
    //customer detail
    /**
     * @param single encode id
     * @return view
     */
    public function customerDetail($id)
    {
        $modulePermission = $this->permission($this->sysModuleName);
        if (!isset($modulePermission)) {
            return \view('forbiden-403');
        }
        $moduleFn = \json_decode($modulePermission->fungsi, true);
        if (!$modulePermission->is_akses || !in_array(static::valuePermission[3], $moduleFn)) {
            return \view('forbiden-403');
        }

        $customerData = Customer::select('id', 'customer_name')
            ->where('id', base64_decode($id))->first();

        return \view('pages.customer.customer-detail', ['moduleFn' => $moduleFn, 'customer' => $customerData]);
    }
    /**
     * @method for datatable customer detail
     * @return json
     */
    public function listDataCustomerDetail(Request $request)
    {
        $modulePermission = $this->permission($this->sysModuleName);
        $moduleFn = \json_decode($modulePermission->fungsi, true);

        $draw = $request['draw'];
        $offset = $request['start'] ? $request['start'] : 0;
        $limit = $request['length'] ? $request['length'] : 15;
        $globalSearch = $request['search']['value'];

        $query = CustomerDetail::select('id', 'customer_pic', 'customer_phone', 'customer_address');
        $query->where('customer_id', base64_decode($request->customer));

        if ($globalSearch) {
            $query->where(function ($q) use ($globalSearch) {
                $q->where('customer_pic', 'like', '%' . $globalSearch . '%')
                    ->orWhere('customer_phone', 'like', '%' . $globalSearch . '%')
                    ->orWhere('customer_address', 'like', '%' . $globalSearch . '%');
            });
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
            if (in_array(static::valuePermission[6], $moduleFn)) {
                $data['cbox'] = '<input type="checkbox" class="data-menu-cbox" value="' . $value->id . '">';
            }
            $data['rnum'] = $i;
            $data['pic'] = $value->customer_pic;
            $data['phone'] = $value->customer_phone;
            $data['address'] = $value->customer_address;
            $data['action'] = '';
            if (in_array(static::valuePermission[5], $moduleFn)) {
                $data['action'] = '<button id="#btn-edit" class="btn btn-sm btn-primary btn-edit" data-edit="' . base64_encode($value->id) . '" data-toggle="modal" data-target="#modal-edit-customer-detail" title="edit"><i class="fas fa-edit " aria-hidden="true"></i></button>';
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
     * store customer detail
     * @return json
     */
    public function storeCustomerDetail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer_pic' => 'required|max:150',
            'customer_phone' => 'required|max:200',
            'customer_address' => 'required'
        ]);

        if ($validator->fails()) {
            return \response()->json($validator->errors(), 403);
        }
        $createdCustomerDetail = CustomerDetail::create([
            'customer_id' => base64_decode($request->form_customer),
            'customer_pic' => $request->customer_pic,
            'customer_phone' => $request->customer_phone,
            'customer_address' => $request->customer_address
        ]);

        return \response()->json(['success' => \true, 'message' => 'Data saved!'], 200);
    }
    /**
     * store customer detail
     * @return json
     */
    public function updateCustomerDetail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer_pic' => 'required|max:150',
            'customer_phone' => 'required|max:200',
            'customer_address' => 'required'
        ]);

        if ($validator->fails()) {
            return \response()->json($validator->errors(), 403);
        }
        $customerDetail = CustomerDetail::find(base64_decode($request->formValue));
        $customerDetail->update([
            'customer_pic' => $request->customer_pic,
            'customer_phone' => $request->customer_phone,
            'customer_address' => $request->customer_address
        ]);

        return \response()->json(['success' => \true, 'message' => 'Update success!'], 200);
    }
    /**
     * delete customer detail
     * @param multiple/single id
     * @return json
     */
    public function destroyCustomerDetail(Request $request)
    {
        $ids = $request->dValue;
        $customerDetail = CustomerDetail::whereIn('id', $ids)->delete();
        return \response()->json(['success' => \true, 'message' => 'Delete success!'], 200);
    }
}
