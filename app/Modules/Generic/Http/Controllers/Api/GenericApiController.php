<?php

namespace App\Modules\Generic\Http\Controllers\Api;
use Illuminate\Container\Container as Application;
use App\Modules\Access\Models\User;
use App\Modules\Generic\Http\Controllers\GenericController;
use App\Modules\Generic\Repositories\SettingRepository;
use App\Modules\Notification\Http\Controllers\Admin\OneSignalController;
use App\Modules\Notification\Models\Push_tokens;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class GenericApiController extends GenericController
{

    public $return = [];
    public $user_id;
    public $warehouse_id;
    public $device_type;
    public $device_token;
    public $response;
    private $SettingRepository;
    private $CountryRepository;

    /**
     * @SWG\Info(
     *   title="Example",
     *   version=1,
     *   x={
     *     "some-name": "a-value",
     *     "another": 2,
     *     "complex-type": {
     *       "supported":{
     *         {"version": "1.0", "level": "baseapi"},
     *         {"version": "2.1", "level": "fullapi"},
     *       }
     *     }
     *   }
     * )
     */

    public function __construct()
    {

        parent::__construct();
        $this->device_type = request('device_type');
        $this->device_token = request('device_token');
        $this->user_id = request()->get('user_id');
        $this->SettingRepository=new SettingRepository(new Application);
//        $this->CountryRepository=new CountryRepository(new Application);


    }

    /**
     * @SWG\Post(
     *     method="POST",
     *   path="/savime/api/splash",
     *   summary="player id (when send device token) one_signal_token - countries - product categories - stores categories",
     *   operationId="Splash for savime",
     *
     *    @SWG\Parameter(
     *     name="device_type",
     *     in="formData",
     *     required=true,
     *     @SWG\Schema(type="string"),
     *     type="string"
     *   ),
     *    @SWG\Parameter(
     *     name="device_token",
     *     in="formData",
     *     required=false,
     *     @SWG\Schema(type="string"),
     *     type="string"
     *   ),
     *   @SWG\Response(response=200, description="access token"),
     *   @SWG\Response(response=406, description="not acceptable"),
     *   @SWG\Response(response=500, description="internal server error")
     * )
     */

    public function splash()
    {
        $this->successResponse();
        $this->get_settings();
        $record = Push_tokens::whereToken($this->device_token)->first();
        $this->return['one_signal_token'] = '';
        if (!$record) {
            $oneSignalResponse = OneSignalController::addUserToOneSignal($this->device_token, $this->device_type);
            if (@$oneSignalResponse->success) {
                Push_tokens::create([
                    'device_type' => $this->device_type,
                    'token' => $this->device_token,
//                    'user_id' => $this->user_id,
                    'one_signal_token' => $oneSignalResponse->id
                ]);

                $this->return['one_signal_token'] = $oneSignalResponse->id;
            }
        }


        return $this->return;
    }



    public function get_user()
    {
        $this->return['user'] = $user = User::whereId($this->user_id)->first();
        if (!$this->return['user'])
            $this->return['user'] = new User();
    }

    public function get_settings()
    {
        $this->return['settings'] = $this->SettingRepository->first();

        return $this->return;
    }

    public function updatePushToken()
    {
        $device_token = request('device_token');
        $device_type = request('device_type');


        $record = Push_tokens::whereToken($device_token);
        if ($this->user_id) {
            $record->whereUserId($this->user_id);
        }
        $record = $record->first();
        if (!$record) {
            $oneSignalResponse = OneSignalController::addUserToOneSignal($device_token, $device_type);

            if (@$oneSignalResponse->success) {
                Push_tokens::create([
                    'device_type' => $device_type,
                    'token' => $device_token,
                    'user_id' => $this->user_id,
                    'one_signal_token' => $oneSignalResponse->id
                ]);
            }
        } else {
            if ($record->user_id != $this->user_id) {
                $record->update(['user_id' => $this->user_id]);
            }
        }
    }



    public function logErrors(Request $request)
    {
        mail('mostafa.hashim90@gmail.com,callmenow@gmail.com', 'SAVI ME ' . $request->subject, $request->body);
        $this->successResponse();
        return $this->return;
    }


    protected function requestHasUser($key = 'user_id', $action = '', $action_data = [])
    {
        if (!request($key)) {
            $this->return['error'] = 'missing user_id';
            $this->return['action'] = $action;
            $this->return['action_data'] = $action_data;

            return FALSE;
        }
        return TRUE;
    }




    protected function validateApiRequest($required = [], $action = '', $action_data = [])
    {
        $missing = [];

        $required[] = 'lang';
        $required[] = 'device_type';

        foreach ($required as $item) {
            $input = request($item);

            if ((!isset($input)) || $input == '') $missing[] = $item;
        }
        if ($missing) {
            $error = 'missing ' . implode(', ', $missing);
            $this->response= $this->falseResponse($error, $action , $action_data );
            return FALSE;
        }
        return TRUE;
    }

    public function falseResponse($error = '', $action = '', $action_data = [])
    {

        $this->return['action'] = $action;
        $this->return['action_data'] = $action_data;

        return $this->response=response()->json($this->return)->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR, $error);

    }

    public function successResponse($action = '', $action_data = [])
    {
        $this->return['error'] = '';
        $this->return['action'] = $action;
        $this->return['action_data'] = $action_data;
        if (request()->has('need_user') && request('need_user') == 1)
            $this->get_user();

        if (request()->has('need_settings') && request('need_settings') == 1)
            $this->get_settings();

        return $this->response=response()->json($this->return)->setStatusCode(Response::HTTP_OK, Response::$statusTexts[Response::HTTP_OK]);

    }


    public function returnPaginationData(&$pagination_result)
    {
        $next = ($pagination_result->currentPage() >= $pagination_result->lastPage()) ? -1 : $pagination_result->currentPage() + 1;
        $pagination_result = $pagination_result->toArray()['data'];
        $this->return['page'] = $next;
    }

}