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
            'required_date',
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
                    ->orWhere('required_date', 'like', '%' . $globalSearch . '%')
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
            $data['required'] = $value->required_date;
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
                        $data['action'] = '<button class="btn btn-sm btn-primary btn-assign" title="assign sample" data-toggle="modal" data-target="#modal-assign-sample" data-as="' . base64_encode($value->id) . '"><i class="fa fa-user-plus" aria-hidden="true"></i></button>
                        <a href="' . \route('pic_sample_request.detail', $value->sample_ID) . '"class="btn btn-sm btn-outline-success btn-detail" title="detail sample"><i class="fa fa-eye" aria-hidden="true"></i></a>';
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
        $validator = Validator::make($request->all(), [
            'assign' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 403);
        }
        //perubahan ini belum ditest
        $userLab = $request->assign;
        $idSample = \base64_decode($request->as);
        $picNote = $request->pic_note;
        try {
            //update data assign process
            DB::beginTransaction();
            $updateSample = $this->samplePicRepository->updateSampleWhenAssign(
                $data = [
                    'rnd' => $userLab,
                    'sample_pic_note' => $picNote
                ],
                $idSample
            );
            DB::commit();

            $sampleContent = $this->samplePicRepository->sampleForContentEmail($idSample);
            $userContent = $this->userRepository->getUserSampleAssign($userLab);
            $userContentData = $userContent->pluck('email', 'name')->toArray();
            $userNamePluck = $userContent->pluck('name')->toArray();
            $content = [
                'rnd_name' => implode(',', \json_decode(json_encode($userNamePluck))),
                // 'rnd_email' => $userContent->email,
                'sample_id' => $sampleContent->sample_ID,
                'sample_subject' => $sampleContent->subject,
                'requestor' => $sampleContent->sampleRequestor->name,
                'required_date' => $sampleContent->required_date,
                'delivery_date' => $sampleContent->delivery_date,
                'sample_pic' => Auth::user()->name,
                'sample_pic_note' => $sampleContent->sample_pic_note,
                'sample_token' => $sampleContent->token,
            ];

            $recipents = $userContentData;
            $sendNotif = Notification::route('mail', $recipents)->notify(new SamplePicAssign($content));

            return \response()->json(['success' => \true, 'message' => 'Assign success']);
        } catch (\Throwable $th) {
            DB::rollBack();
            return \response()->json(['success' => \false, 'message' => 'Something went wrong!, please try again']);
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
        //belum selesai
        //jika sample delivery mode expedition
        if ($sampleData->delivery_by == '1') {
            # code...
        } else {
        }


        return \response()->json(['success' => true, 'message' => 'Success!'], 200);
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
    public function listSampleProduct(Request $request) {}
}
