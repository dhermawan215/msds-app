<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Models\CustomerDetail;
use Illuminate\Support\Carbon;
use App\Traits\ModulePermissions;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class AdminCustomerController extends Controller
{
    //controller for admin customer module
    use ModulePermissions;
    protected $sysModuleName = 'admin_customer';
    const valuePermission = ['add', 'edit', 'delete', 'detail', 'detail_add', 'detail_edit', 'detail_delete'];
    private static $url;

    public function __construct()
    {
        static::$url = route('admin_customer');
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
        return \view('admin.customer.index', ['moduleFn' => $moduleFn]);
    }
    /**
     * @method for datatable product
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

        $query = Customer::select('id', 'customer_code', 'customer_name', 'customer_registered_at', 'user_id')
            ->with('customerUser:id,name');

        if ($globalSearch) {
            $query->where('customer_code', 'like', '%' . $globalSearch . '%')
                ->orWhere('customer_name', 'like', '%' . $globalSearch . '%');
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
            $data['sales'] = $value->customerUser ? $value->customerUser->name : 'data not found';
            $data['register'] = Carbon::create($value->customer_registered_at)->toFormattedDateString();
            $data['action'] = '';
            if (in_array(static::valuePermission[1], $moduleFn) && in_array(static::valuePermission[3], $moduleFn)) {
                $data['action'] = '<a href="' . route('admin_customer.edit', base64_encode($value->id)) . '" class="btn btn-sm btn-primary btn-edit"><i class="fas fa-edit " aria-hidden="true"></i></a>
                <a href="' . route('admin_customer.detail', base64_encode($value->id)) . '" class="btn btn-sm btn-success" title="Add customer detail"><i class="fa fa-plus" aria-hidden="true"></i> Customer Detail</a>';
            } elseif (in_array(static::valuePermission[1], $moduleFn)) {
                $data['action'] = '<a href="' . route('admin_customer.edit', base64_encode($value->id)) . '" class="btn btn-sm btn-primary btn-edit"><i class="fas fa-edit " aria-hidden="true"></i></a>';
            } elseif (in_array(static::valuePermission[3], $moduleFn)) {
                $data['action'] = '<a href="' . route('admin_customer.detail', base64_encode($value->id)) . '" class="btn btn-sm btn-success" title="Add customer detail"><i class="fa fa-plus" aria-hidden="true"></i> Customer Detail</a>';
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
            'sales' => 'required'
        ]);

        if ($validator->fails()) {
            return \response()->json($validator->errors(), 403);
        }

        $date = Carbon::now();
        $createdCustomer = Customer::create([
            'customer_code' => $request->customer_code,
            'customer_name' => $request->customer_name,
            'user_id' => $request->sales,
            'customer_registered_at' => $date->toDateString()
        ]);
        return \response()->json(['success' => \true, 'message' => 'Data saved!'], 200);
    }
    /**
     * handle edit data
     * @param id
     * @return view
     */
    public function edit($id)
    {
        $modulePermission = $this->permission($this->sysModuleName);
        $moduleFn = \json_decode($modulePermission->fungsi, true);
        if (!$modulePermission->is_akses || !in_array(static::valuePermission[1], $moduleFn)) {
            return \view('forbiden-403');
        }
        $customerData = Customer::select('id', 'customer_name', 'customer_code', 'user_id')
            ->with('customerUser:id,name')->where('id', base64_decode($id))->first();
        $user = User::select('id', 'name')->get();
        // dd($customerData);
        return view('admin.customer.edit', ['value' => $customerData, 'user' => $user]);
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
            'sales' => 'required'
        ]);

        if ($validator->fails()) {
            return \response()->json($validator->errors(), 403);
        }
        $updateCustomer = Customer::find(base64_decode($request->formValue));
        $updateCustomer->update([
            'customer_code' => $request->customer_code,
            'customer_name' => $request->customer_name,
            'user_id' => $request->sales
        ]);
        return \response()->json(['success' => \true, 'message' => 'Update success!', 'url' => route('admin_customer')], 200);
    }
    /**
     * @param array single/multiple
     * @return json
     */
    public function destroy(Request $request)
    {
        $ids = $request->dValue;
        //delete
        $customerData = Customer::whereIn('id', $ids);
        $customerData->delete();
        //delete customer detail
        $customerDetail = CustomerDetail::whereIn('customer_id', $ids)->delete();
        return \response()->json(['success' => \true, 'message' => 'Delete success!'], 200);
    }
    /**
     * handle user for register customer
     * @return json
     */
    public function userCustomer(Request $request)
    {
        $data = [];
        $resultCount = 20;
        $perPage = $request->page;
        $offset = ($perPage - 1) * $resultCount;
        $user = User::select('id', 'name');

        if ($request->search) {
            $user->where('name', 'like', '%' . $request->search . '%');
        }

        $resData = $user->skip($offset)
            ->take($resultCount)->get();
        $recordsTotal = $resData->count();

        if ($resData->isEmpty()) {
            $data['id'] = 0;
            $data['text'] = 'empty';
            $arr[] = $data;
        }

        foreach ($resData as $key => $value) {
            $data['id'] = $value->id;
            $data['text'] = $value->name;
            $arr[] = $data;
        }

        return response()->json(['success' => true, 'total_count' => $recordsTotal, 'items' => $arr], 200);
    }
    //customer detail
    /**
     * @param single encode id
     * @return view
     */
    public function customerDetail($id)
    {
        $modulePermission = $this->permission($this->sysModuleName);
        $moduleFn = \json_decode($modulePermission->fungsi, true);
        if (!$modulePermission->is_akses || !in_array(static::valuePermission[3], $moduleFn)) {
            return \view('forbiden-403');
        }

        $customerData = Customer::select('id', 'customer_name')
            ->where('id', base64_decode($id))->first();

        return \view('admin.customer.customer-detail', ['moduleFn' => $moduleFn, 'customer' => $customerData]);
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
