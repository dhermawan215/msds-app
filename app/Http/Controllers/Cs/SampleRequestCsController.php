<?php

namespace App\Http\Controllers\Cs;

use Illuminate\Http\Request;
use App\Models\SampleRequest;
use App\Traits\UserLogRecord;
use App\Traits\ModulePermissions;
use App\Http\Controllers\Controller;
use App\Repository\SampleCsRepository;
use App\Traits\CustomEncrypt;
use Illuminate\Support\Facades\Crypt;

class SampleRequestCsController extends Controller
{
    use ModulePermissions;
    use UserLogRecord;
    use CustomEncrypt;
    protected $sysModuleName = 'cs_sample_request';
    const valuePermission = [
        'delivery',
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
    protected $sampleCsRepo;

    public function __construct(SampleCsRepository $sampleCsRepository)
    {
        $this->sampleCsRepo = $sampleCsRepository;
        static::$url = route($this->sysModuleName);
    }

    public function index()
    {
        $modulePermission = $this->permission($this->sysModuleName);
        if (!isset($modulePermission->is_akses) || $modulePermission->is_akses == 0) {
            return \view('forbiden-403');
        }
        $moduleFn = \json_decode($modulePermission->fungsi, true);
        return \view('cs.index', ['moduleFn' => $moduleFn]);
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
        )->with('sampleRequestToDelivery:id,sample_id');
        $query->where('delivery_by', 1);

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
            if ($value->sample_status == 3 && $value->delivery_by == 1 && in_array(static::valuePermission[0], $moduleFn)) {
                if (is_null($value['sampleRequestToDelivery'])) {
                    $data['action'] = '<a href="#" class="btn btn-outline-success btn-detail" title="detail"><i class="fa fa-eye"></i></a>
                    <button class="btn btn-warning text-white btn-add-receipt" title="add receipt delivery" data-toggle="modal" data-target="#modal-add-receipt"><i class="fa fa-truck" aria-hidden="true"></i></button>
                    <button class="btn btn-primary btn-info-delivery" title="info delivery" data-di="' . $this->encryptData($value->id) . '" data-toggle="modal" data-target="#modal-info-delivery"><i class="fa fa-info-circle" aria-hidden="true"></i></button>';
                } else {
                    $data['action'] = '<a href="#" class="btn btn-outline-success btn-detail" title="detail"><i class="fa fa-eye"></i></a>
                    <button class="btn btn-primary btn-info-delivery" title="info delivery" data-di="' . $this->encryptData($value->id) . '" data-toggle="modal" data-target="#modal-info-delivery"><i class="fa fa-info-circle" aria-hidden="true"></i></button>';
                }
            } else {
                $data['action'] = '<a href="#" class="btn btn-outline-success btn-detail" title="detail"><i class="fa fa-eye"></i></a>
                <button class="btn btn-primary btn-info-delivery" title="info delivery" data-di="' . $this->encryptData($value->id) . '" data-toggle="modal" data-target="#modal-info-delivery"><i class="fa fa-info-circle" aria-hidden="true"></i></button>';
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
     * method show information delivery data
     */
    public function information(Request $request)
    {
        $id = $this->decryptData($request->dl);
        try {
            //get information of delivery sample request
            $delivery = $this->sampleCsRepo->deliveryInformation($id);
            return response()->json(['success' => true, 'data' => $delivery, 'message' => 'success'], 200);
        } catch (\Throwable $th) {
            return response()->json(['success' => true, 'data' => null, 'message' => 'something went wrong'], 500);
        }
    }
}
