<?php

namespace App\Http\Controllers\Pic;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\SampleRequest;
use App\Traits\UserLogRecord;
use App\Traits\ModulePermissions;
use App\Repository\UserRepository;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\SampleRequestProduct;
use App\Notifications\NotificationForCustomerService;
use App\Notifications\NotificationForSalesWhenPickup;
use Illuminate\Support\Facades\Auth;
use App\Notifications\SamplePicAssign;
use App\Repository\SamplePicRepository;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Notification;

class SampleRequestPicController extends Controller
{
    //controller sample request for pic
    use ModulePermissions;
    use UserLogRecord;
    protected $sysModuleName = 'pic_sample_request';
    const valuePermission = [
        'change_status',
        'assign',
        'detail',
    ];
    const approvalValueDesc = ['pending', 'process', 'finish'];
    const approvalValue = ['0', '1', '2'];
    const iconApproveValue = ['fa fa-clock', 'fa fa-paper-plane', 'fa fa-check'];
    const sampleStatusCode = ['0', '1', '2', '3', '4', '5', '6'];
    //if sample status in db null, the data will be display pending 
    const sampleStatusDesc = ['Requested', 'Confirm', 'Ready', 'Pick up', 'Accepted by customer', 'Reviewed', 'Cancel'];
    const deliveryBy = ['Pick up by customer', 'Expedition', 'Pick up by sales'];
    private static $url;

    protected $samplePicRepository;
    protected $userRepository;

    public function __construct(SamplePicRepository $samplePicRepository, UserRepository $userRepository)
    {
        $this->samplePicRepository = $samplePicRepository;
        $this->userRepository = $userRepository;
        static::$url = \route('pic_sample_request');
    }

    public function index()
    {
        $modulePermission = $this->permission($this->sysModuleName);
        if (!isset($modulePermission->is_akses) || $modulePermission->is_akses == 0) {
            return \view('forbiden-403');
        }
        $moduleFn = \json_decode($modulePermission->fungsi, true);
        return \view('pic.sample-request.index', ['moduleFn' => $moduleFn]);
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
            'delivery_by',
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
            if ($value->delivery_by == 0) {
                $deliveryBy = static::deliveryBy[0];
            } elseif ($value->delivery_by == 1) {
                $deliveryBy = static::deliveryBy[1];
            } else {
                $deliveryBy = static::deliveryBy[2];
            }
            $data['delivery_by'] = $deliveryBy;
            $data['pic'] = '<i class="' . $samplePic . '"></i>';
            $data['creator'] = '<i class="' . $sampleRnd . '"></i>';
            $data['cs'] = '<i class="' . $sampleCs . '"></i>';
            $data['status'] = $sampleStatus;
            $data['action'] = '';
            //jika status request dan izin asign ada maka
            if (static::sampleStatusCode[0] == $value->sample_status && in_array(static::valuePermission[1], $moduleFn)) {
                //check if sample request product assign null
                $sampleUnSign = $this->samplePicRepository->countUnSignSampleProduct($value->id);
                switch ($sampleUnSign) {
                    case 'false':
                        $data['action'] = ' <a href="' . \route('pic_sample_request.detail', $value->sample_ID) . '"class="btn btn-sm btn-outline-success btn-detail" title="detail sample"><i class="fa fa-eye" aria-hidden="true"></i></a>';
                        break;
                    case 0:
                        $data['action'] = '<a href="' . \route('pic_sample_request.detail', $value->sample_ID) . '"class="btn btn-sm btn-outline-success btn-detail" title="detail sample"><i class="fa fa-eye" aria-hidden="true"></i></a>';
                        break;
                    default:
                        $data['action'] = '<a href="' . \route('pic_sample_request.assign', $value->sample_ID) . '" class="btn btn-sm btn-warning btn-product-assign" title="product assign"><i class="fa fa-toggle-off" aria-hidden="true"></i></a>
                        <a href="' . \route('pic_sample_request.detail', $value->sample_ID) . '"class="btn btn-sm btn-outline-success btn-detail" title="detail sample"><i class="fa fa-eye" aria-hidden="true"></i></a>';
                        break;
                }
            }
            //jika status  ready dan izin change status ada
            elseif (static::sampleStatusCode[1] == $value->sample_status && in_array(static::valuePermission[1], $moduleFn)) {
                $data['action'] = '<a href="' . \route('pic_sample_request.detail', $value->sample_ID) . '"class="btn btn-sm btn-outline-success btn-detail" title="detail sample"><i class="fa fa-eye" aria-hidden="true"></i></a>
                <button class="btn btn-sm btn-outline-danger btn-open-tr" data-tr="' . base64_encode($value->id) . '" title="open transaction"><i class="fa fa-envelope-open" aria-hidden="true"></i></button>';
            }
            //jika status ready
            elseif (static::sampleStatusCode[2] == $value->sample_status && in_array(static::valuePermission[1], $moduleFn)) {
                $data['action'] = '<a href="' . \route('pic_sample_request.change_status', $value->sample_ID) . '" class="btn btn-sm btn-info"><i class="fa fa-toggle-on" aria-hidden="true"></i></a>
                <a href="' . \route('pic_sample_request.detail', $value->sample_ID) . '"class="btn btn-sm btn-outline-success btn-detail" title="detail sample"><i class="fa fa-eye" aria-hidden="true"></i></a>';
            } else {
                if ($value->delivery_by == 1) {
                    $deliveryMenu = '<button class="btn btn-sm btn-danger btn-delivery" title="detail sample delivery" data-toggle="modal" data-target="#modal-delivery-information" data-dl="' . base64_encode($value->id) . '"><i class="fa fa-truck" aria-hidden="true"></i></button>';
                } else {
                    $deliveryMenu = '';
                }
                $data['action'] = '<a href="' . \route('pic_sample_request.detail', $value->sample_ID) . '"class="btn btn-sm btn-outline-success btn-detail" title="detail sample"><i class="fa fa-eye" aria-hidden="true"></i></a>
               ' . $deliveryMenu;
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
        $moduleFn = \json_decode($modulePermission->fungsi, true);
        if (!$modulePermission->is_akses || !in_array(static::valuePermission[2], $moduleFn)) {
            return \view('forbiden-403');
        }
        $sampleDetailData = $this->samplePicRepository->detailOfSample($sampleId);
        return \view('pic.sample-request.detail-sample', ['data' => $sampleDetailData]);
    }
    /**
     * method user list dropdown for assign feature
     * @return json
     */
    public function listUserForAssign(Request $request)
    {
        $items = $this->userRepository->getListofUser($request);
        return response()->json(['success' => true, 'total_count' => $items['recordsTotal'], 'items' => $items['items']], 200);
    }
    /**
     * method assiign sample
     * send email
     * @return json
     */
    public function assignSample(Request $request)
    {
        $getSampleData = $this->samplePicRepository->getSampleId($request->as);
        $getUserSampleProduct = $this->samplePicRepository->getUserInSampleProduct($getSampleData->id);
        // get user data from sample product and convert to unique array
        $userLab = array_values(array_unique($getUserSampleProduct->pluck('sampleProductUser.id')->toArray()));
        //get email and name for email receipt
        $userContentReceipent = $getUserSampleProduct->pluck('sampleProductUser.name', 'sampleProductUser.email')->toArray();
        //get the unique array when duplicate value of array
        $userNameDearUnique = array_values(array_unique($getUserSampleProduct->pluck('sampleProductUser.name')->toArray()));
        //convert to string as: jhon, doe, etc
        $userNameDear = implode(',', \json_decode(json_encode($userNameDearUnique)));

        $idSample = $getSampleData->id;
        $picNote = $request->pic_note;
        try {
            //update data assign process
            DB::beginTransaction();
            $updateSample = $this->samplePicRepository->updateSampleWhenAssign(
                $data = [
                    'rnd' => \json_encode($userLab),
                    'sample_pic_note' => $picNote
                ],
                $idSample
            );
            DB::commit();

            $sampleContent = $this->samplePicRepository->sampleForContentEmail($idSample);

            $content = [
                'rnd_name' => $userNameDear,
                // 'rnd_email' => $userContent->email,
                'sample_id' => $sampleContent->sample_ID,
                'sample_subject' => $sampleContent->subject,
                'requestor' => $sampleContent->sampleRequestor->name,
                'request_date' => $sampleContent->request_date,
                'delivery_date' => $sampleContent->delivery_date,
                'sample_pic' => Auth::user()->name,
                'sample_pic_note' => $sampleContent->sample_pic_note,
                'sample_token' => $sampleContent->token,
            ];

            $recipents = $userContentReceipent;
            $sendNotif = Notification::route('mail', $recipents)->notify(new SamplePicAssign($content));

            return \response()->json(['success' => \true, 'message' => 'Assign success', 'url' => static::$url], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return \response()->json(['success' => \false, 'message' => 'Something went wrong!, please try again'], 500);
        }
    }
    /**
     * method open transaction of sample request
     * @return json
     */
    public function openTransactionSampleRequest(Request $request)
    {
        $openTransaction = $this->samplePicRepository->openTransactionOfSampleRequest(\base64_decode($request->tr));
        $user = Auth::user();
        $data = [
            'user_id' => $user->id,
            'email' => $user->email,
            'date_time' => Carbon::now()->toDateTimeString(),
            'ip_address' => $request->ip(),
            'log_user_agent' => $request->header('user-agent'),
            'activity' => $user->name . ' open sample request, ID: ' . $openTransaction,
            'status' => 'true',
        ];
        $recordUserLog = $this->logUserActivity($data);

        return \response()->json(['success' => true, 'message' => 'Success open transaction'], 200);
    }
    /**
     * method change status
     */
    public function changeStatus($id)
    {
        $modulePermission = $this->permission($this->sysModuleName);
        $moduleFn = \json_decode($modulePermission->fungsi, true);
        if (!$modulePermission->is_akses || !in_array(static::valuePermission[0], $moduleFn)) {
            return \view('forbiden-403');
        }

        $sampleData = $this->samplePicRepository->sampleForChangeStatus($id);
        return \view('pic.sample-request.change-status', ['data' => $sampleData]);
    }
    /**
     * method get delivery information
     * @return json
     */
    public function deliveryInformation(Request $request)
    {
        $deliveryInformation = $this->samplePicRepository->getSampleDelivery(\base64_decode($request->dl));

        return \response()->json(['success' => \true, 'data' => $deliveryInformation], 200);
    }
    /**
     * nethod update chage status
     */
    public function updateChangeStatus(Request $request)
    {
        //get data sample data before check delivery mode
        $sampleData = $this->samplePicRepository->sampleForChangeStatus($request->sample_ID);
        //jika sample delivery mode expedition
        //create log
        $user = Auth::user();
        $data = [
            'user_id' => $user->id,
            'email' => $user->email,
            'date_time' => Carbon::now()->toDateTimeString(),
            'ip_address' => $request->ip(),
            'log_user_agent' => $request->header('user-agent'),
            'activity' => $user->name . ' change sample status to pickup, ID: ' . $request->sample_ID,
            'status' => 'true',
        ];
        $this->logUserActivity($data);
        if ($sampleData->delivery_by == '1') {
            $response = $this->sendExpedition($request, $user);
        } else {
            $response = $this->sendPickup($request, $user);
        }

        return response()->json(['success' => $response['success'], 'message' => $response['message'], 'url' => $response['url'] ? $response['url'] : null], $response['http']);
    }
    /**
     * method view detail sample product and use to assign
     */
    public function detailSampleProduct($sampleId)
    {
        $modulePermission = $this->permission($this->sysModuleName);
        $moduleFn = \json_decode($modulePermission->fungsi, true);
        if (!$modulePermission->is_akses || !in_array(static::valuePermission[1], $moduleFn)) {
            return \view('forbiden-403');
        }
        return \view('pic.sample-request.assign-sample-product', [
            'javascriptID' => 'assign-sample-product',
            'sampleID' => $sampleId,
            'homeUrl' => static::$url,
        ]);
    }
    /**
     * datatable for list sample product
     */
    public function listSampleProduct(Request $request)
    {
        $draw = $request['draw'];
        $offset = $request['start'] ? $request['start'] : 0;
        $limit = $request['length'] ? $request['length'] : 15;
        $globalSearch = $request['search']['value'];
        // get sample data
        $sample = $this->samplePicRepository->getSampleId($request->sampleID);
        $sampleUnsign = $this->samplePicRepository->countUnSignSampleProduct($sample->id);
        $query = SampleRequestProduct::select('*')->with('sampleProduct:id,product_code,product_function')
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
            $data['action'] = '';
            if (is_null($value->assign_to)) {
                $data['action'] = '<button class="btn btn-sm btn-outline-warning btn-assign" data-assg="' . \base64_encode($value->id) . '" data-toggle="modal" data-target="#modal-assign-sample-product" title="assign this product"><i class="fa fa-tags" aria-hidden="true"></i></button>';
            } else {
                $data['action'] = '<button class="btn btn-sm btn-outline-info btn-info-assign" data-assg="' . \base64_encode($value->id) . '" data-toggle="modal" data-target="#modal-info-assign-sample-product" title="info assign this product"><i class="fa fa-info" aria-hidden="true"></i></button>
                <button class="btn btn-sm btn-primary btn-edit-assign" data-assg="' . \base64_encode($value->id) . '" data-toggle="modal" data-target="#modal-edit-assign-sample-product" title="edit assign to"><i class="fa fa-edit"></i></button>';
            }
            $arr[] = $data;
            $i++;
        }

        return \response()->json([
            'draw' => $draw,
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data' => $arr,
            'sampleUnSign' => $sampleUnsign
        ]);
    }
    /**
     * method handle assign sample product to user
     */
    public function assignSampleProductToUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 403);
        }

        try {
            DB::beginTransaction();
            //assign process
            $this->samplePicRepository->assignSampleProduct($request);
            DB::commit();
            return \response()->json(['success' => true, 'message' => 'success assign'], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return \response()->json(['success' => false, 'message' => 'something went wrong'], 500);
        }
    }
    /**
     * information this sample to
     */
    public function infoAssign(Request $request)
    {
        try {
            $data = $this->samplePicRepository->getInformationSampleAssign(\base64_decode($request->av));
            $responseData = [
                'user' => $data->sampleProductUser ? $data->sampleProductUser->name : 'empty',
                'email' => $data->sampleProductUser ? $data->sampleProductUser->email : 'empty',
            ];
            return \response()->json(['success' => true, 'message' => 'success', 'data' => $responseData], 200);
        } catch (\Throwable $th) {
            return \response()->json(['success' => true, 'message' => 'error', 'data' => null], 200);
        }
    }
    /**
     * information this sample to
     */
    public function editAssign(Request $request)
    {
        try {
            $data = $this->samplePicRepository->getInformationSampleAssign(\base64_decode($request->av));
            $responseData = [
                'id' => $data->sampleProductUser ? $data->sampleProductUser->id : null,
                'text' => $data->sampleProductUser ? $data->sampleProductUser->name : 'empty',
            ];
            return \response()->json(['success' => true, 'message' => 'success', 'data' => $responseData], 200);
        } catch (\Throwable $th) {
            return \response()->json(['success' => true, 'message' => 'error', 'data' => null], 200);
        }
    }
    /**
     *if value changed, this method can be handle
     * update assign sample product to user
     */
    public function updateAssign(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 403);
        }

        try {
            DB::beginTransaction();
            //assign process
            $this->samplePicRepository->assignSampleProduct($request);
            DB::commit();
            return \response()->json(['success' => true, 'message' => 'success update assign'], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return \response()->json(['success' => false, 'message' => 'something went wrong'], 500);
        }
    }
    /**
     * method if expedition
     * @param $request as object data request
     * @param $user as user data from auth
     * @return array
     */
    private function sendExpedition($request, $user)
    {
        //get user customer service
        $csUser = $this->samplePicRepository->getUserCustomerService();
        //prepare data sample request
        $arraySampleRequest = [
            'sample_ID' => $request->sample_ID,
            'cs' => $csUser[0]->id,
            'cs_status' => 1,
            'sample_pic_note' => $request->sample_pic_note,
            'sample_status' => $request->sample_status,
        ];

        try {
            //update sample request
            $this->samplePicRepository->updateSampleRequestWhenChangeStatus($arraySampleRequest);
            //get sample id
            $sample = $this->samplePicRepository->getSampleId($request->sample_ID);
            // get content email
            $conteEmail = $this->samplePicRepository->sampleForContentEmail($sample->id);
            //contain the email content data
            $content = [
                'sample_subject' => $conteEmail->subject,
                'sample_pic' => $user->name,
                'customer_service' => $csUser[0]->name,
                'sample_id' => $conteEmail->sample_ID,
                'requestor' => $conteEmail->sampleRequestor->name,
                'request_date' => $conteEmail->request_date,
                'delivery_date' => $conteEmail->delivery_date,
                'sample_pic_note' => $conteEmail->sample_pic_note,
                'sample_token' => $conteEmail->token,
            ];
            //send email notification
            Notification::send($csUser, new NotificationForCustomerService($content));
            return [
                'success' => true,
                'message' => 'success',
                'http' => 200,
                'url' => static::$url,
            ];
        } catch (\Throwable $th) {
            //throw $th;
            return [
                'success' => false,
                'message' => 'Error, please try again',
                'http' => 500,
                'url' => null,
            ];
        }
    }
    /**
     * method if pikcup/by sales
     * @param $request as object data request
     * @param $user as user data from auth
     * @return array
     */
    private function sendPickup($request, $user)
    {
        //prepare data sample request
        $arraySampleRequest = [
            'sample_ID' => $request->sample_ID,
            'cs' => null,
            'cs_status' => 0,
            'sample_pic_note' => $request->sample_pic_note,
            'sample_status' => $request->sample_status,
        ];

        try {
            //update sample request
            $this->samplePicRepository->updateSampleRequestWhenChangeStatus($arraySampleRequest);
            //get sample id
            $sample = $this->samplePicRepository->getSampleId($request->sample_ID);
            // get content email
            $conteEmail = $this->samplePicRepository->sampleForContentEmail($sample->id);
            //contain the email content data
            $content = [
                'sample_subject' => $conteEmail->subject,
                'sample_pic' => $user->name,
                'sample_id' => $conteEmail->sample_ID,
                'requestor' => $conteEmail->sampleRequestor->name,
                'request_date' => $conteEmail->request_date,
                'delivery_date' => $conteEmail->delivery_date,
                'sample_pic_note' => $conteEmail->sample_pic_note,
                'sample_token' => $conteEmail->token,
            ];
            // recipents address
            $recipent = [
                $conteEmail->sampleRequestor->email => $conteEmail->sampleRequestor->name
            ];
            //send notification
            Notification::route('mail', $recipent)->notify(new NotificationForSalesWhenPickup($content));
            return [
                'success' => true,
                'message' => 'success',
                'http' => 200,
                'url' => static::$url,
            ];
        } catch (\Throwable $th) {
            return [
                'success' => false,
                'message' => 'Error, please try again',
                'http' => 500,
                'url' => null,
            ];
        }
    }
}
