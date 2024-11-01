<?php

namespace App\Http\Controllers\Rnd;

use App\Traits\LogoUpload;
use Illuminate\Http\Request;
use App\Models\SampleRequest;
use App\Traits\UserLogRecord;
use App\Traits\ModulePermissions;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\SampleRequestDetails;
use App\Models\SampleRequestProduct;
use Illuminate\Support\Facades\Auth;
use App\Repository\SampleRndRepository;
use Illuminate\Support\Facades\Validator;
use App\Models\SampleRequestProductDocument;
use App\Notifications\SendEmailWhenSampleFinish;
use Carbon\Carbon;
use Illuminate\Support\Facades\Notification;

class SampleRequestRndController extends Controller
{
    //controller for module sample request rnd and wh
    use ModulePermissions;
    use UserLogRecord;
    use LogoUpload;
    protected $sysModuleName = 'rnd_sample_request';
    const valuePermission = [
        'change_status',
        'confirm',
        'detail',
        'print'
    ];
    const approvalValueDesc = ['pending', 'process', 'finish'];
    const approvalValue = ['0', '1', '2'];
    const iconApproveValue = ['fa fa-clock', 'fa fa-paper-plane', 'fa fa-check'];
    const sampleStatusCode = ['0', '1', '2', '3', '4', '5', '6'];
    //if sample status in db null, the data will be display pending 
    const sampleStatusDesc = ['Requested', 'Confirm', 'Ready', 'Pick up', 'Accepted by customer', 'Reviewed', 'Cancel'];
    const deliveryBy = ['Pick up by customer', 'Expedition', 'Pick up by sales'];
    private static $url;
    protected $sampleRndRepo;

    public function __construct(SampleRndRepository $sampleRndRepository)
    {
        static::$url = route($this->sysModuleName);
        $this->sampleRndRepo = $sampleRndRepository;
    }

    public function index()
    {
        $modulePermission = $this->permission($this->sysModuleName);
        if (!isset($modulePermission->is_akses) || $modulePermission->is_akses == 0) {
            return \view('forbiden-403');
        }
        $moduleFn = \json_decode($modulePermission->fungsi, true);
        return \view('rnd.sample-request.index', ['moduleFn' => $moduleFn]);
    }

    /**
     * method data table
     * @return json
     */
    public function list(Request $request)
    {
        $modulePermission = $this->permission($this->sysModuleName);
        $moduleFn = \json_decode($modulePermission->fungsi, true);

        $draw = $request['draw'];
        $offset = $request['start'] ? $request['start'] : 0;
        $limit = $request['length'] ? $request['length'] : 15;
        $globalSearch = $request['search']['value'];

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

        if ($request->sample_status != '7') {
            $query->where('sample_status', $request->sample_status);
        }

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

            $data['rnum'] = $i;
            $data['id'] = $value->sample_ID;
            $data['subject'] = $value->subject;
            $data['request'] = $value->request_date;
            $data['delivery'] = $value->delivery_date;
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
            //if sample status confirm and permission confirm is enable
            if (static::sampleStatusCode[1] == $value->sample_status && in_array(static::valuePermission[1], $moduleFn)) {
                $data['action'] = '<a href="' . \route('rnd_sample_request.change_status', $value->sample_ID) . '" class="btn btn-sm btn-warning btn-confirm-product-assign" title="confirm product assign"><i class="fa fa-check" aria-hidden="true"></i></a>
                <a href="' . \route('rnd_sample_request.detail', $value->sample_ID) . '"class="btn btn-sm btn-outline-success btn-detail" title="detail sample"><i class="fa fa-eye" aria-hidden="true"></i></a>';
            } else {
                $data['action'] = '<a href="' . \route('rnd_sample_request.detail', $value->sample_ID) . '"class="btn btn-sm btn-outline-success btn-detail" title="detail sample"><i class="fa fa-eye" aria-hidden="true"></i></a>';
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
     * method view detail
     * @return view
     */
    public function detail($sampleId)
    {
        $modulePermission = $this->permission($this->sysModuleName);
        if (!isset($modulePermission)) {
            return \view('forbiden-403');
        }
        $moduleFn = \json_decode($modulePermission->fungsi, true);
        if (!$modulePermission->is_akses || !in_array(static::valuePermission[2], $moduleFn)) {
            return \view('forbiden-403');
        }
        $sampleDetailData = $this->sampleRndRepo->getDetailOfSample($sampleId);
        return \view('rnd.sample-request.detail-sample', $sampleDetailData);
    }
    /**
     * method handle detail sample request product, sample request can be confirm the product if end
     */
    public function detailSampleRequestProduct($sampleId)
    {
        $modulePermission = $this->permission($this->sysModuleName);
        if (!isset($modulePermission)) {
            return \view('forbiden-403');
        }
        $moduleFn = \json_decode($modulePermission->fungsi, true);
        if (!$modulePermission->is_akses || !in_array(static::valuePermission[1], $moduleFn)) {
            return \view('forbiden-403');
        }
        return \view('rnd.sample-request.confirm-sample-product', [
            'javascriptID' => 'confirm-sample-product',
            'sampleID' => $sampleId,
            'homeUrl' => static::$url,
        ]);
    }
    /**
     * method handle data for datatable sample request product
     */
    public function listSampleProduct(Request $request)
    {
        $userLogin = Auth::user();
        $draw = $request['draw'];
        $offset = $request['start'] ? $request['start'] : 0;
        $limit = $request['length'] ? $request['length'] : 15;
        $globalSearch = $request['search']['value'];
        // get sample data
        $sample = $this->sampleRndRepo->getSampleId($request->sampleID);
        $query = SampleRequestProduct::select('*')->with(['sampleProduct:id,product_code,product_function', 'sampleProductUser:id,name,email'])
            ->where('sample_id', $sample->id);

        if ($globalSearch) {
            // searching product_code inside relation of smapleProduct
            $query->where(function ($subQuery) use ($globalSearch) {
                $subQuery->where('qty', 'like', '%' . $globalSearch . '%')
                    ->orWhere('label_name', 'like', '%' . $globalSearch . '%')
                    ->orWhereHas('sampleProduct', function ($subQueryHas) use ($globalSearch) {
                        $subQueryHas->where('product_code', 'like', '%' . $globalSearch . '%');
                    });
            });
        }

        $finishedSampleProduct = $this->sampleRndRepo->getFinishedSampleProduct($sample->id);

        $recordsFiltered = $query->count();
        $resData = $query->skip($offset)
            ->take($limit)
            ->get();
        $recordsTotal = $resData->count();

        $data = [];
        $i = $offset + 1;
        $arr = [];

        foreach ($resData as $key => $value) {
            $data['rnum'] = $i;
            $data['product'] = $value->sampleProduct ? $value->sampleProduct->product_code . '-' . $value->sampleProduct->product_function : 'data not found';
            $data['qty'] = $value->qty;
            $data['label'] = $value->label_name;
            $data['creator'] = $value->sampleProductUser ? $value->sampleProductUser->name : 'empty data';
            $data['action'] = '';
            //user login equal to assign, so action add batch/ghs, and click finish enable
            if ($userLogin->id == $value->sampleProductUser->id) {
                //if data sample request detail null/0, creator can't finished the process
                $countSampleReqDetail = $this->sampleRndRepo->getCountSampleRequestDetails($value->sample_id, $value->product_id);
                if ($countSampleReqDetail == 0) {
                    $data['action'] = '<button class="btn btn-sm btn-success btn-add-batch" data-toggle="modal" data-target="#modal-add-sample-detail"" title="add batch" data-pr="' . \base64_encode($value->product_id) . '" data-sr="' . \base64_encode($value->sample_id) . '" data-srp="' . \base64_encode($value->id) . '"><i class="fa fa-plus-square"></i></button>';
                    //if data ghs/batch is available (filled) and status unfinished, so user must be finished the process
                } elseif ($countSampleReqDetail != 0 && $value->finished == 0) {
                    $data['action'] = '<button class="btn btn-sm btn-outline-success text-white btn-finished" data-srp="' . \base64_encode($value->id) . '" title="finish the process"><i class="fa fa-check-circle"></i></button>';
                } else {
                    $data['action'] = '<button class="btn btn-sm btn-outline-info btn-inf" data-srp="' . \base64_encode($value->id) . '" data-pr="' . \base64_encode($value->product_id) . '" data-sr="' . \base64_encode($value->sample_id) . '" title="infomation" data-toggle="modal" data-target="#modal-info-sample-detail"><i class="fa fa-info-circle"></i></button>
                    <button class="btn btn-sm btn-success btn-print" data-vsrp="' . \base64_encode($value->id) . '" data-vpr="' . \base64_encode($value->product_id) . '" data-vsr="' . \base64_encode($value->sample_id) . '" title="Print label" data-toggle="modal" data-target="#modal-print-label"><i class="fa fa-print"></i></button>
                    <button class="btn btn-sm btn-danger btn-delete-label" data-srp="' . \base64_encode($value->id) . '" data-pr="' . \base64_encode($value->product_id) . '" data-sr="' . \base64_encode($value->sample_id) . '" title="delete data label"><i class="fa fa-trash"></i></button>
                    <button class="btn btn-sm btn-warning btn-upload-msdspds" data-srp="' . \base64_encode($value->id) . '" title="upload msds & pds" data-toggle="modal" data-target="#modal-upload-msdspds"><i class="fa fa-upload" aria-hidden="true"></i></button>';
                }
            } else {
                $data['action'] = '<button class="btn btn-sm btn-outline-info btn-inf" data-srp="' . \base64_encode($value->id) . '" data-pr="' . \base64_encode($value->product_id) . '" data-sr="' . \base64_encode($value->sample_id) . '" title="infomation" data-toggle="modal" data-target="#modal-info-sample-detail"><i class="fa fa-info-circle"></i></button>';
            }

            $arr[] = $data;
            $i++;
        }

        return \response()->json([
            'draw' => $draw,
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data' => $arr,
            'finished' => $finishedSampleProduct,
            'rnd_status' => $sample->rnd_status
        ]);
    }
    /**
     * method handle dropdown ghs
     */
    public function ghsDropdown(Request $request)
    {
        $items = $this->sampleRndRepo->getGhsDropdown($request);
        return response()->json(['success' => true, 'total_count' => $items['recordsTotal'], 'items' => $items['items']], 200);
    }
    /**
     * method get batch number when batch type lab
     */
    public function batchNumberLab(Request $request)
    {
        $bulanTgl = date('Ymd');
        try {
            DB::beginTransaction();
            $batchNumber = $this->sampleRndRepo->getBatchNumber();
            $nextBatchNumber = (int) substr($batchNumber ? $batchNumber->batch_number : 0, 12, 3);
            $periodBatchNumber = (int) substr($batchNumber ? $batchNumber->batch_number : 0, 0, 8);
            if ($bulanTgl == $periodBatchNumber) {
                $outBatchQuee = '02';
            } else {
                $outBatchQuee = '01';
            }
            $addNextBatchNumber = $nextBatchNumber + 1;
            $finalBatchNumber = $bulanTgl . '.' . $outBatchQuee . '.' . sprintf("%03s", $addNextBatchNumber);
            DB::commit();
            return \response()->json(['success' => true, 'data' => $finalBatchNumber, 'message' => 'success'], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return \response()->json(['success' => false, 'data' => null, 'message' => 'error!'], 200);
        }
    }
    /**
     * method store sample request detail(batch,qty,ghs)
     */
    public function storeSampleReqDetail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'batch_type' => 'required',
            'batch_number' => 'required',
            'netto' => 'required',
            'ghs' => 'required',
            'released_by' => 'required',
        ]);

        if ($validator->fails()) {
            return \response()->json($validator->errors(), 403);
        }
        $getSampleRequestor = $this->sampleRndRepo->getRequestorSampleRequest(\base64_decode($request->srVal));
        try {
            DB::beginTransaction();
            $data = [
                'srVal' => $request->srVal,
                'srpVal' => $request->srpVal,
                'prVal' => $request->prVal,
                'batch_type' => $request->batch_type,
                'batch_number' => $request->batch_number,
                'product_remarks' => $request->product_remarks,
                'released_by' => $request->released_by,
                'netto' => $request->netto,
                'ghs' => $request->ghs,
                'requestor' => $getSampleRequestor->sampleRequestor->name,
                'manufacture_date' => $request->manufacture_date,
                'expired_date' => $request->expired_date,
            ];
            $this->sampleRndRepo->storeSampleDetail($data);
            DB::commit();
            return \response()->json(['success' => \true, 'message' => 'success!'], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return \response()->json(['success' => \false, 'message' => 'error!'], 500);
        }
    }
    /**
     * method handle finished the sample product
     */
    public function finished(Request $request)
    {
        try {
            $this->sampleRndRepo->finishedSampleProduct($request->srp);
            return \response()->json(['success' => true, 'message' => 'sample request product was finished'], 200);
        } catch (\Throwable $th) {
            return \response()->json(['success' => true, 'message' => 'error, try again!'], 500);
        }
    }
    /**
     * method print label sample request product
     */
    public function labelPrint(Request $request)
    {
        $modulePermission = $this->permission($this->sysModuleName);
        if (!isset($modulePermission)) {
            return \view('forbiden-403');
        }
        $moduleFn = \json_decode($modulePermission->fungsi, true);
        if (!$modulePermission->is_akses || !in_array(static::valuePermission[3], $moduleFn)) {
            return \view('forbiden-403');
        }

        $sample_id = $request->query('vsr');
        $sampleReqproduct_id = $request->query('vsrp');
        $product_id = $request->query('vpr');
        $retain = $request->query('retain');
        $copy = $request->query('copy');

        try {
            $sampleReqDetail = $this->sampleRndRepo->getSampleRequestDetails($sample_id, $sampleReqproduct_id, $product_id);
            $ghs = json_decode($sampleReqDetail->ghs);
            $ghsData = $this->sampleRndRepo->getGhsSampleRequestDetails($ghs);

            return \view(
                'rnd.sample-request.label-print',
                ['copy' => $copy, 'retain' => $retain, 'ghsPicture' => $ghsData, 'sampleDetail' => $sampleReqDetail]
            );
        } catch (\Throwable $th) {
            abort(503);
        }
    }
    /**
     * method get information sample request product and sample request detail
     */
    public function information(Request $request)
    {
        $data = [
            'sampleProductId' => base64_decode($request->nodeVsrp),
            'sampleId' => base64_decode($request->nodeVsr),
            'productId' => base64_decode($request->nodeVpr)
        ];

        try {
            $data = $this->sampleRndRepo->getInformation($data);
            $product = $data['product'];
            $detail = $data['detail'];
            if ($product->finished == 1) {
                $finished = 'finished';
            } else {
                $finished = 'pending';
            }

            $response = [
                'finished' => $finished,
                'assign' => $product->sampleProductUser ? $product->sampleProductUser->name : 'empty data',
                'batch_type' => $detail ? $detail->batch_type : 'empty data',
                'batch_number' => $detail ? $detail->batch_number : 'empty data',
                'product_remarks' => $detail ? $detail->product_remarks : 'empty data',
                'released_by' => $detail ? $detail->released_by : 'empty data',
                'expired_date' => $detail ? $detail->expired_date : 'empty data',
                'manufacture_date' => $detail ? $detail->manufacture_date : 'empty data',
            ];
            return response()->json(['success' => true, 'data' => $response], 200);
        } catch (\Throwable $th) {
            return response()->json(['success' => false, 'message' => 'please try again'], 500);
        }
    }
    /**
     * method delete ghs label if the label wrong
     */
    public function deleteLabelGhs(Request $request)
    {
        $data = [
            'sampleProductId' => base64_decode($request->nVsrp),
            'sampleId' => base64_decode($request->nVsr),
            'productId' => base64_decode($request->nVpr)
        ];

        try {
            $this->sampleRndRepo->deleteSampleReqDetail($data);
            return response()->json(['success' => true], 200);
        } catch (\Throwable $th) {
            return response()->json(['success' => false], 500);
            //throw $th;
        }
    }
    /**
     * finish the sample when sample creator clikc submit
     * (belum)
     */
    public function submitSampleRequest(Request $request)
    {
        try {
            DB::beginTransaction();
            //update the sample request data
            $this->sampleRndRepo->updateSampleWhenSubmit($request->sampleId, $request->rnd_note);
            //create log
            $userSession = Auth::user();
            $createLog = [
                'user_id' => $userSession->id,
                'email' => $userSession->email,
                'ip_address' => $request->ip(),
                'log_user_agent' => $request->header('user-agent'),
                'activity' => 'finish & submit sample: ' . $request->sampleId,
                'status' => 'true',
                'date_time' => Carbon::now(),
            ];
            $this->logUserActivity($createLog);
            //get sample content for email
            $contentEmail = $this->sampleRndRepo->sampleForContentEmail($request->sampleId);
            //container the content email 
            $contentNotification = [
                'sample_id' => $contentEmail->sample_ID,
                'sample_subject' => $contentEmail->subject,
                'sample_pic' => 'Sample PIC',
                'request_date' => $contentEmail->request_date,
                'delivery_date' => $contentEmail->delivery_date,
                'sample_creator_note' => $contentEmail->rnd_note,
                'sample_creator_time' => $contentEmail->rnd_approve_at,
                'sample_token' => $contentEmail->token,
            ];
            DB::commit();
            //get user sample pic
            $userSamplePic = $this->sampleRndRepo->getUserSamplePic();
            // send notification
            $sendNotification = Notification::send($userSamplePic, new SendEmailWhenSampleFinish($contentNotification));

            return response()->json(['success' => true, 'message' => 'submit success', 'url' => static::$url], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'something went wrong!'], 200);
        }
    }
    /**
     * data table for list msds/pds uploaded in sample request product
     */
    public function listMsdsPds(Request $request)
    {
        $draw = $request['draw'];
        $offset = $request['start'] ? $request['start'] : 0;
        $limit = $request['length'] ? $request['length'] : 15;
        $globalSearch = $request['search']['value'];
        $query = SampleRequestProductDocument::where('sample_req_product_id', base64_decode($request->srp));

        if ($globalSearch) {
            $query->where(function ($q) use ($globalSearch) {
                $q->where('document_category', 'like', '%' . $globalSearch . '%')
                    ->orWhere('document_name', 'like', '%' . $globalSearch . '%');
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
            $data['rnum'] = $i;
            $data['category'] = $value->document_category;
            $data['name'] = $value->document_name;
            $data['path'] = asset($value->document_path);
            $data['action'] = '
            <button class="btn btn-sm btn-preview btn-success" data-toggle="modal" data-target="#modal-preview-docoment" title="preview-document"><i class="fa fa-eye" aria-hidden="true"></i></button>
            <button class="btn btn-sm btn-danger btn-delete-doc" data-dc="' . base64_encode($value->id) . '" title="delete"><i class="fa fa-trash" aria-hidden="true"></i></button>';
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
     * method handle store data of file msds/pds
     */
    public function storeMsdsPds(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'document_category' => 'required',
            'file_upload' => 'required|mimes:pdf|max:2048'
        ]);

        if ($validator->fails()) {
            return \response()->json($validator->errors(), 403);
        }

        if ($request->hasFile('file_upload')) {
            $fileLogo = $request->file('file_upload');
            $path = $this->storeLogo($fileLogo, 'assets/msds-pds');
        }

        $data = [
            'sample_product_id' => base64_decode($request->srp),
            'document_name' => $fileLogo->getClientOriginalName(),
            'document_path' => $path,
            'document_category' => $request->document_category
        ];

        try {
            $this->sampleRndRepo->storeDataFileMsds($data);
            return response()->json(['success' => true, 'message' => 'upload success'], 200);
        } catch (\Throwable $th) {
            return response()->json(['success' => false, 'message' => 'something went wrong'], 500);
        }
    }
    /**
     * method delete the document & data of sample request product document(msds/pds)
     */
    public function deleteMsdsPds(Request $request)
    {
        $documentData = $this->sampleRndRepo->deleteDataFileMsds($request->docVl);

        try {
            //delete document
            $path = parse_url($documentData->document_path);
            $strPathFile = str_replace('\\', '/', $path['path']);
            $unlink = $this->deleteLogo($strPathFile);
            //delete from table
            $documentData->delete();
            return response()->json(['success' => true, 'message' => 'delete success'], 200);
        } catch (\Throwable $th) {
            return response()->json(['success' => false, 'message' => 'something went wrong'], 500);
        }
    }
}
