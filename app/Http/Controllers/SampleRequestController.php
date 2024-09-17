<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use App\Models\SampleSource;
use Illuminate\Http\Request;
use App\Models\SampleRequest;
use App\Services\ProductService;
use App\Services\CustomerService;
use App\Traits\ModulePermissions;
use Illuminate\Support\Facades\DB;
use App\Models\SampleRequestProduct;
use Illuminate\Support\Facades\Auth;
use App\Models\SampleRequestCustomer;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Notification;
use App\Notifications\SalesSendRequestOfSample;
use App\Traits\UserLogRecord;
use Carbon\Carbon;

class SampleRequestController extends Controller
{
    //controller for user (sales) sample request
    use ModulePermissions;
    use UserLogRecord;
    protected $sysModuleName = 'sample_request';
    const valuePermission = [
        'add',
        'edit',
        'delete',
        'detail',
        'customer_detail_add',
        'customer_detail_edit',
        'customer_detail_delete',
        'product_add',
        'product_edit',
        'product_delete'
    ];
    const approvalValueDesc = ['pending', 'process', 'finish'];
    const approvalValue = ['0', '1', '2'];
    const iconApproveValue = ['fa fa-clock', 'fa fa-paper-plane', 'fa fa-check'];
    const sampleStatusCode = ['0', '1', '2', '3', '4', '5', '6'];
    //if sample status in db null, the data will be display pending 
    const sampleStatusDesc = ['Requested', 'Confirm', 'Ready', 'Pick up', 'Accepted by customer', 'Reviewed', 'Cancel'];
    const deliveryBy = ['Pick up by customer', 'Expedition', 'Pick up by sales'];
    private static $url;
    protected $customerService;
    protected $productService;

    public function __construct()
    {
        static::$url = route('sample_request');
        $this->customerService = new CustomerService;
        $this->productService = new ProductService;
    }
    public function index()
    {
        $modulePermission = $this->permission($this->sysModuleName);
        if (!isset($modulePermission->is_akses) || $modulePermission->is_akses == 0) {
            return \view('forbiden-403');
        }
        $moduleFn = \json_decode($modulePermission->fungsi, true);
        return \view('pages.sample-request.index', ['moduleFn' => $moduleFn]);
    }

    public function listOfSample(Request $request)
    {
        $modulePermission = $this->permission($this->sysModuleName);
        $moduleFn = \json_decode($modulePermission->fungsi, true);

        $draw = $request['draw'];
        $offset = $request['start'] ? $request['start'] : 0;
        $limit = $request['length'] ? $request['length'] : 15;
        $globalSearch = $request['search']['value'];
        $user = Auth::user();

        $query = SampleRequest::select(
            'id',
            'sample_ID',
            'subject',
            'request_date',
            'delivery_date',
            'sample_status',
            'delivery_date',
            'sample_pic_status',
            'rnd_status',
            'cs_status'
        );
        $query->where('requestor', $user->id);

        if ($globalSearch) {
            $query->where(function ($q) use ($globalSearch) {
                $q->where('sample_ID', 'like', '%' . $globalSearch . '%')
                    ->orWhere('subject', 'like', '%' . $globalSearch . '%')
                    ->orWhere('request_date', 'like', '%' . $globalSearch . '%')
                    ->orWhere('delivery_date', 'like', '%' . $globalSearch . '%');
            });
        }

        $recordsFiltered = $query->count();
        $resData = $query->skip($offset)
            ->take($limit)->orderBy('created_at', 'desc')
            ->get();
        $recordsTotal = $resData->count();

        $data = [];
        $i = $offset + 1;
        $arr = [];

        foreach ($resData as $key => $value) {
            $data['cbox'] = '';
            if (in_array(static::valuePermission[2], $moduleFn)) {
                if (static::approvalValue[0] == $value->sample_pic_status && static::approvalValue[0] == $value->rnd_status && static::approvalValue[0] == $value->cs_status) {
                    $data['cbox'] = '<input type="checkbox" class="data-menu-cbox" value="' . $value->id . '">';
                }
            }
            $data['rnum'] = $i;
            $data['id'] = $value->sample_ID;
            $data['subject'] = $value->subject;
            $data['request'] = $value->request_date;
            $data['delivery'] = $value->delivery_date;
            $data['pic'] = $value->sample_pic;
            //check status pic
            switch ($value->sample_pic_status) {
                case static::approvalValue[1]:
                    $samplePic = static::iconApproveValue[1];
                    break;
                case static::approvalValue[2]:
                    $samplePic = static::iconApproveValue[2];
                    break;
                case static::approvalValue[0]:
                    $samplePic = static::iconApproveValue[0];
                    break;
                default:
                    $samplePic = 'fa fa-minus';
                    break;
            }
            //check status creator/rnd
            switch ($value->rnd_status) {
                case static::approvalValue[1]:
                    $sampleRnd = static::iconApproveValue[1];
                    break;
                case static::approvalValue[2]:
                    $sampleRnd = static::iconApproveValue[2];
                    break;
                case static::approvalValue[0]:
                    $sampleRnd = static::iconApproveValue[0];
                    break;
                default:
                    $sampleRnd = 'fa fa-minus';
                    break;
            }
            //check status cs
            switch ($value->cs_status) {
                case static::approvalValue[1]:
                    $sampleCs = static::iconApproveValue[1];
                    break;
                case static::approvalValue[2]:
                    $sampleCs = static::iconApproveValue[2];
                    break;
                case static::approvalValue[0]:
                    $sampleCs = static::iconApproveValue[0];
                    break;
                default:
                    $sampleCs = 'fa fa-minus';
                    break;
            }
            //check status sample
            switch ($value->sample_status) {
                case static::sampleStatusCode[0]:
                    $sampleStatus = static::sampleStatusDesc[0];
                    break;
                case static::sampleStatusCode[1]:
                    $sampleStatus = static::sampleStatusDesc[1];
                    break;
                case static::sampleStatusCode[2]:
                    $sampleStatus = static::sampleStatusDesc[2];
                    break;
                case static::sampleStatusCode[3]:
                    $sampleStatus = static::sampleStatusDesc[3];
                    break;
                case static::sampleStatusCode[4]:
                    $sampleStatus = static::sampleStatusDesc[4];
                    break;
                case static::sampleStatusCode[5]:
                    $sampleStatus = static::sampleStatusDesc[5];
                    break;
                case static::sampleStatusCode[6]:
                    $sampleStatus = static::sampleStatusDesc[6];
                    break;
                default:
                    $sampleStatus = 'Pending';
                    break;
            }

            $data['pic'] = '<i class="' . $samplePic . '"></i>';
            $data['creator'] = '<i class="' . $sampleRnd . '"></i>';
            $data['cs'] = '<i class="' . $sampleCs . '"></i>';
            $data['status'] = $sampleStatus;
            $data['action'] = '';
            // jika status sample pic, rnd dan cs masih pending dan status sample requested(null)
            if (static::approvalValue[0] == $value->sample_pic_status && static::approvalValue[0] == $value->rnd_status && static::approvalValue[0] == $value->cs_status && is_null($value->sample_status)) {
                //jika edit, detail, product true
                if (in_array(static::valuePermission[1], $moduleFn) && in_array(static::valuePermission[3], $moduleFn) && in_array(static::valuePermission[7], $moduleFn)) {
                    $data['action'] = '<a href="' . route('sample_request.edit', $value->sample_ID) . '" class="btn btn-sm btn-primary" title="Edit sample"><i class="fas fa-edit" aria-hidden="true"></i></a>
                    <a href="' . route('sample_request.detail', $value->sample_ID) . '" class="btn btn-sm btn-success" title="Detail of sample"><i class="fas fa-eye" aria-hidden="true"></i></a>
                    <a href="' . route('sample_request.product_add', $value->sample_ID) . '" class="btn btn-sm btn-warning mt-1" title="Product Detail"><i class="fa fa-tags" aria-hidden="true"></i></a>';
                }
                //jika edit, detail true
                elseif (in_array(static::valuePermission[1], $moduleFn) && in_array(static::valuePermission[3], $moduleFn)) {
                    $data['action'] = '<a href="' . route('sample_request.edit', $value->sample_ID) . '" class="btn btn-sm btn-primary" title="Edit sample"><i class="fas fa-edit" aria-hidden="true"></i></a>
                    <a href="' . route('sample_request.detail', $value->sample_ID) . '" class="btn btn-sm btn-success" title="Detail of sample"><i class="fas fa-eye" aria-hidden="true"></i></a>';
                }
                //jika edit, product true
                elseif (in_array(static::valuePermission[1], $moduleFn) && in_array(static::valuePermission[7], $moduleFn)) {
                    $data['action'] = '<a href="' . route('sample_request.edit', $value->sample_ID) . '" class="btn btn-sm btn-primary" title="Edit sample"><i class="fas fa-edit" aria-hidden="true"></i></a>
                     <a href="' . route('sample_request.product_add', $value->sample_ID) . '" class="btn btn-sm btn-warning mt-1" title="Product Detail"><i class="fa fa-tags" aria-hidden="true"></i></a>';
                }
                //jika  detail, product true
                elseif (in_array(static::valuePermission[3], $moduleFn) && in_array(static::valuePermission[7], $moduleFn)) {
                    $data['action'] = '<a href="' . route('sample_request.product_add', $value->sample_ID) . '" class="btn btn-sm btn-warning mt-1" title="Product Detail"><i class="fa fa-tags" aria-hidden="true"></i></a>
                    <a href="' . route('sample_request.detail', $value->sample_ID) . '" class="btn btn-sm btn-success" title="Detail of sample"><i class="fas fa-eye" aria-hidden="true"></i></a>';
                }
                //jika edit true
                elseif (in_array(static::valuePermission[1], $moduleFn)) {
                    $data['action'] = '<a href="' . route('sample_request.edit', $value->sample_ID) . '" class="btn btn-sm btn-primary" title="Edit sample"><i class="fas fa-edit" aria-hidden="true"></i></a>';
                }
                //jika detail true
                elseif (in_array(static::valuePermission[3], $moduleFn)) {
                    $data['action'] = '<a href="' . route('sample_request.detail', $value->sample_ID) . '" class="btn btn-sm btn-success" title="Detail of sample"><i class="fas fa-eye" aria-hidden="true"></i></a>';
                }
                //jika product true
                elseif (in_array(static::valuePermission[3], $moduleFn)) {
                    $data['action'] = '<a href="' . route('sample_request.product_add', $value->sample_ID) . '" class="btn btn-sm btn-warning mt-1" title="Product Detail"><i class="fa fa-tags" aria-hidden="true"></i></a>';
                }
            } elseif (static::sampleStatusCode[4] == $value->sample_status) {
                $data['action'] = '<a href="#" class="btn btn-sm btn-outline-success mt-1" title="Change status"><i class="fa fa-toggle-on" aria-hidden="true"></i></a>
                <a href="' . route('sample_request.detail', $value->sample_ID) . '" class="btn btn-sm btn-success" title="Detail of sample"><i class="fas fa-eye" aria-hidden="true"></i></a>';
            } else {
                $data['action'] = '<a href="' . route('sample_request.detail', $value->sample_ID) . '" class="btn btn-sm btn-success" title="Detail of sample"><i class="fas fa-eye" aria-hidden="true"></i></a>';
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
     * view 
     * @return view
     */
    public function createSample()
    {
        $modulePermission = $this->permission($this->sysModuleName);
        $moduleFn = \json_decode($modulePermission->fungsi, true);
        if (!$modulePermission->is_akses || !in_array(static::valuePermission[0], $moduleFn)) {
            return \view('forbiden-403');
        }
        $bulanTgl = date('md');
        $huruf = "SRF-";
        $zki = "-ZKI-";
        try {
            DB::beginTransaction();
            $sampleID = SampleRequest::select('id', 'sample_ID')
                ->where('id', function ($query) {
                    $query->select(DB::raw('MAX(id)'))->from('sample_requests');
                })
                ->first();
            $sampleIDOrder = (int) substr($sampleID->sample_ID, 13, 4);
            $sampleIDOrderAdd = $sampleIDOrder + 1;
            $sampleNo = $huruf . $bulanTgl . $zki . sprintf("%04s", $sampleIDOrderAdd);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
        }
        $sampleSource = SampleSource::select('id', 'name')->get();
        return \view('pages.sample-request.create-sample', [
            'url' => static::$url,
            'sampleID' => $sampleNo,
            'sampleSource' => $sampleSource
        ]);
    }
    /**
     * store sample request
     * @return json
     */
    public function storeSampleRequest(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'sample_id' => 'unique:sample_requests,sample_ID',
            'subject' => 'required|max:200',
            'request_date' => 'required',
            'delivery_date' => 'required',
            'sample_source' => 'required',
        ]);

        if ($validator->fails()) {
            return \response()->json($validator->errors(), 403);
        }
        try {
            //store the data
            DB::beginTransaction();
            $requestor = Auth::user();
            $token = date('Ym') . Str::random(32) . date('ds');
            $createdSampleRequest = SampleRequest::create([
                'sample_ID' => $request->sample_id,
                'subject' => $request->subject,
                'requestor' => $requestor->id,
                'request_date' => $request->request_date,
                'delivery_date' => $request->delivery_date,
                'delivery_by' => $request->delivery_by,
                'requestor_note' => $request->requestor_note,
                'sample_source_id' => $request->sample_source,
                'sample_pic_status' => 0,
                'rnd_status' => 0,
                'cs_status' => 0,
                'token' => $token
            ]);
            DB::commit();
            return response()->json(['success' => true, 'message' => 'success create sample', 'url' => route('sample_request.customer_detail_add', $createdSampleRequest->sample_ID)], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'somtehing went wrong, please try again!', 'url'], 200);
        }
    }
    /**
     * view 
     * @return view
     */
    public function editSample($id)
    {
        $modulePermission = $this->permission($this->sysModuleName);
        $moduleFn = \json_decode($modulePermission->fungsi, true);
        if (!$modulePermission->is_akses || !in_array(static::valuePermission[0], $moduleFn)) {
            return \view('forbiden-403');
        }
        $sample = SampleRequest::select('sample_ID', 'subject', 'requestor', 'request_date', 'delivery_date', 'delivery_by', 'requestor_note', 'sample_source_id')
            ->with(['sampleRequestor:id,name', 'sampleSource:id,name'])
            ->where('sample_ID', $id)->first();
        $sampleSource = SampleSource::select('id', 'name')->get();
        return \view('pages.sample-request.edit-sample', [
            'url' => static::$url,
            'sample' => $sample,
            'sampleSource' => $sampleSource
        ]);
    }
    /**
     * update sample request
     * @return json
     */
    public function updateSample(Request $request)
    {
        $sampleRequest = SampleRequest::where('sample_ID', $request->sample_id);
        $validator = Validator::make($request->all(), [
            'subject' => 'required|max:200',
            'request_date' => 'required',
            'delivery_date' => 'required',
            'sample_source' => 'required',
        ]);

        if ($validator->fails()) {
            return \response()->json($validator->errors(), 403);
        }
        $sampleRequest->update([
            'subject' => $request->subject,
            'request_date' => $request->request_date,
            'delivery_date' => $request->delivery_date,
            'delivery_by' => $request->delivery_by,
            'requestor_note' => $request->requestor_note,
            'sample_source_id' => $request->sample_source,
        ]);
        return response()->json(['success' => true, 'message' => 'Update success', 'url' => static::$url], 200);
    }
    /**
     * delete sample, sample customer and sample product
     * @return json
     */
    public function destroySample(Request $request)
    {
        $ids = $request->dValue;
        $deleteSampleReq = SampleRequest::whereIn('id', $ids)->delete();
        $deleteSampleReqCustomer = SampleRequestCustomer::whereIn('sample_id', $ids)->delete();
        $deleteSampleReqProduct = SampleRequestProduct::whereIn('sample_id', $ids)->delete();

        return response()->json(['success' => true, 'message' => 'Delete success'], 200);
    }
    /**
     * detail sample request
     */
    public function detailSample($id)
    {
        $modulePermission = $this->permission($this->sysModuleName);
        $moduleFn = \json_decode($modulePermission->fungsi, true);
        if (!$modulePermission->is_akses || !in_array(static::valuePermission[3], $moduleFn)) {
            return \view('forbiden-403');
        }

        $sampleRequestData = SampleRequest::select('id', 'sample_ID', 'subject', 'requestor', 'request_date', 'delivery_date', 'delivery_by', 'requestor_note', 'sample_source_id')
            ->with(['sampleRequestor:id,name', 'sampleSource:id,name'])
            ->where('sample_ID', $id)->first();
        $sampleRequestCustomer = SampleRequestCustomer::with('sampleCustomer')->where('sample_id', $sampleRequestData->id)->first();

        return view('pages.sample-request.detail-sample', [
            'sample' => $sampleRequestData,
            'sampleCustomer' => $sampleRequestCustomer
        ]);
    }
    /**
     * local method get sample request data
     * @return object data
     */
    private function getSampleRequest($sampleID)
    {
        $sampleRequest = SampleRequest::select('id', 'sample_ID')
            ->where('sample_ID', $sampleID)->first();
        return $sampleRequest;
    }
    // --- sample request customer detail start ---
    /**
     * create sample request customer detail
     * @return view
     */
    public function createDetailCustomer($id)
    {
        $modulePermission = $this->permission($this->sysModuleName);
        $moduleFn = \json_decode($modulePermission->fungsi, true);
        if (!$modulePermission->is_akses || !in_array(static::valuePermission[4], $moduleFn)) {
            return \view('forbiden-403');
        }
        return view('pages.sample-request.create-sample-customer', [
            'sampleID' => $id,
            'urlBack' => route('sample_request'),
            'javascriptID' => 'sample-customer'
        ]);
    }
    /**
     * method for dropdown select customer
     */
    public function customerDropdown(Request $request)
    {
        $items = $this->customerService->getCustomer($request);

        return response()->json(['success' => true, 'total_count' => $items['recordsTotal'], 'items' => $items['items']], 200);
    }
    /**
     * method for dropdown select customer detail
     */
    public function customerDetailDropdown(Request $request)
    {
        $customerDetail = $this->customerService->getAddressPic($request);
        return response()->json(['success' => true, 'items' => $customerDetail], 200);
    }
    /**
     * store the customer detail of sample request
     * @return json
     */
    public function storeCustomerDetail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer' => 'required',
        ]);

        if ($validator->fails()) {
            return \response()->json($validator->errors(), 403);
        }
        $sample = $this->getSampleRequest($request->sample_id);

        $createSampleRequestCustomer = SampleRequestCustomer::create([
            'sample_id' => $sample->id,
            'customer_id' => $request->customer,
            'customer_pic' => $request->customer_pic,
            'delivery_address' => $request->delivery_address,
        ]);
        return response()->json(['success' => true, 'message' => 'Data saved!', 'url' => route('sample_request.product_add', $sample->sample_ID)], 200);
    }
    // --- sample request customer detail end ---
    //--- sample product detail start ----
    /**
     * create sample request product detail
     * @return view
     */
    public function createDetailProduct($id)
    {
        $modulePermission = $this->permission($this->sysModuleName);
        $moduleFn = \json_decode($modulePermission->fungsi, true);
        if (!$modulePermission->is_akses || !in_array(static::valuePermission[7], $moduleFn)) {
            return \view('forbiden-403');
        }
        $sampleData = SampleRequest::select('sample_ID', 'sample_status')->where('sample_ID', $id)->first();
        return view('pages.sample-request.create-sample-product', [
            'sampleID' => $sampleData->sample_ID,
            'urlBack' => route('sample_request'),
            'javascriptID' => 'sample-product',
            'moduleFn' => $moduleFn,
            'sampleStatus' => $sampleData->sample_status,
        ]);
    }
    /**
     * method for dropdown select customer
     */
    public function productDropdown(Request $request)
    {
        $items = $this->productService->getProduct($request);
        return response()->json(['success' => true, 'total_count' => $items['recordsTotal'], 'items' => $items['items']], 200);
    }
    /**
     * handle datatable for sample request product
     * @return json
     */
    public function listOfproductDetail(Request $request)
    {
        $modulePermission = $this->permission($this->sysModuleName);
        $moduleFn = \json_decode($modulePermission->fungsi, true);

        $draw = $request['draw'];
        $offset = $request['start'] ? $request['start'] : 0;
        $limit = $request['length'] ? $request['length'] : 15;
        $globalSearch = $request['search']['value'];
        // get sample data
        $sample = $this->getSampleRequest($request->sampleID);

        $query = SampleRequestProduct::select('*')->with('sampleProduct:id,product_code,product_function');
        $query->where('sample_id', $sample->id);

        if ($globalSearch) {
            $query->where(function ($q) use ($globalSearch) {
                $q->where('qty', 'like', '%' . $globalSearch . '%')
                    ->orWhere('label_name', 'like', '%' . $globalSearch . '%');
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
            if (in_array(static::valuePermission[9], $moduleFn)) {
                $data['cbox'] = '<input type="checkbox" class="data-menu-cbox" value="' . $value->id . '">';
            }
            $data['rnum'] = $i;
            $data['product'] = $value->sampleProduct ? $value->sampleProduct->product_code . '-' . $value->sampleProduct->product_function : 'data not found';
            $data['qty'] = $value->qty;
            $data['label'] = $value->label_name;
            $data['action'] = '';
            if (in_array(static::valuePermission[8], $moduleFn)) {
                $data['action'] = '<button id="#btn-edit" class="btn btn-sm btn-primary btn-edit" data-edit="' . base64_encode($value->id) . '" data-toggle="modal" data-target="#modal-edit-sample-product" title="edit"><i class="fas fa-edit " aria-hidden="true"></i></button>';
            }
            $arr[] = $data;
            $i++;
        }

        return \response()->json([
            'draw' => $draw,
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data' => $arr,
            'recordOfDataProduct' => $recordsTotal
        ]);
    }
    /**
     * store the sample product data
     * @return json
     */
    public function storeProductDetail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product' => 'required',
            'qty' => 'required',
            'label_name' => 'required',
        ]);

        if ($validator->fails()) {
            return \response()->json($validator->errors(), 403);
        }
        $sample = $this->getSampleRequest($request->sample_id);
        $createProductDetail = SampleRequestProduct::create([
            'sample_id' => $sample->id,
            'product_id' => $request->product,
            'qty' => $request->qty,
            'label_name' => $request->label_name
        ]);
        return response()->json(['success' => true, 'message' => 'Data saved!'], 200);
    }
    /**
     * delete sample product data
     * @param multiple/single id
     */
    public function destroyProductDetail(Request $request)
    {
        $ids = $request->dValue;
        SampleRequestProduct::whereIn('id', $ids)->delete();
        return response()->json(['success' => true, 'message' => 'Delete success'], 200);
    }
    /**
     * edit product detail
     */
    public function editProductDetail(Request $request)
    {
        $productDetail = SampleRequestProduct::select('qty', 'label_name', 'product_id')
            ->with('sampleProduct:id,product_code,product_function')
            ->where('id', base64_decode($request->sampleProduct))->first();

        return response()->json(['success' => true, 'data' => $productDetail], 200);
    }
    /**
     * update the sample product data
     * @return json
     */
    public function updateProductDetail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product' => 'required',
            'qty' => 'required',
            'label_name' => 'required',
        ]);

        if ($validator->fails()) {
            return \response()->json($validator->errors(), 403);
        }
        $productSample = SampleRequestProduct::find(base64_decode($request->formValue));
        $productSample->update([
            'product_id' => $request->product,
            'qty' => $request->qty,
            'label_name' => $request->label_name,
        ]);
        return response()->json(['success' => true, 'message' => 'Update success!'], 200);
    }
    /**
     * handle mail send notification to sample pic
     */
    public function sendRequest(Request $request)
    {
        $sampleRequest = SampleRequest::where('sample_ID', $request->sampleID);
        //get sample data
        $sampleData = $sampleRequest->with('sampleRequestor')->first();
        //get sample pic data
        $samplePic = User::whereHas('userGroup', function ($query) {
            $query->where('name', 'SAMPLE_PIC');
        })->get();
        //content email
        $content = [
            'sample_pic_name' => 'Sample PIC',
            'sample_id' => $sampleData->sample_ID,
            'sample_subject' => $sampleData->subject,
            'request_date' => $sampleData->request_date,
            'delivery_date' => $sampleData->delivery_date,
            'sample_requestor' => $sampleData->sampleRequestor->name,
            'sample_token' => $sampleData->token,
        ];
        //create token expired
        $tokenExpiredAt = Carbon::now()->addMinutes(30);

        try {
            DB::beginTransaction();
            //update sample
            $updateSample = $sampleRequest->update([
                'sample_status' => 0,
                //convert array of id from db to array json and save to field sample_pic
                'sample_pic' => json_encode($samplePic->pluck('id')->toArray()),
                'sample_pic_status' => 1,
                'token_expired_at' => $tokenExpiredAt
            ]);
            //send notification to sample pic
            $sendNotif = Notification::send($samplePic, new SalesSendRequestOfSample($content));
            //create user log
            $dataUserLogSendRequest = [
                'user_id' => Auth::user()->id,
                'email' => Auth::user()->email,
                'date_time' => Carbon::now()->toDateTimeString(),
                'ip_address' => $request->ip(),
                'log_user_agent' => $request->header('user-agent'),
                'activity' => 'send request sample ' . $sampleData->sample_ID,
                'status' => 'true'
            ];

            $this->logUserActivity($dataUserLogSendRequest);
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Sample has been requested', 'url' => static::$url], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Something went wrong, please try again', 'url' => static::$url], 500);
        }
    }
    /**
     * handle preview of sample
     * @return view
     */
    public function preview($token)
    {
        $sampleRequestData = SampleRequest::select('id', 'sample_ID', 'subject', 'requestor', 'request_date', 'delivery_date', 'delivery_by', 'requestor_note', 'sample_source_id', 'token', 'token_expired_at')
            ->with(['sampleRequestor:id,name', 'sampleSource:id,name'])
            ->where('token', $token)->first();
        $sampleRequestCustomer = SampleRequestCustomer::with('sampleCustomer')->where('sample_id', $sampleRequestData->id)->first();
        $sampleRequestProduct = SampleRequestProduct::with('sampleProduct')->where('sample_id', $sampleRequestData->id)->get();
        //jika token ada dan waktu token kuran
        if ($sampleRequestData->token && Carbon::parse($sampleRequestData->token_expired_at) < Carbon::now()) {
            return \abort('403', 'token expired');
        }

        return view('pages.sample-request.preview-sample', [
            'sample' => $sampleRequestData,
            'sampleCustomer' => $sampleRequestCustomer,
            'sampleProducts' => $sampleRequestProduct
        ]);
    }
}
