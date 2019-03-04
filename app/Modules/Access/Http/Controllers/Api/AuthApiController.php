<?php

namespace App\Modules\Access\Http\Controllers\Api;

use App\Http\Requests;
use App\Modules\Access\Models\User;
use App\Modules\Generic\Http\Controllers\Api\GenericApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class AuthApiController extends GenericApiController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function login(Request $request)
    {
        $fb_id = request('fb_id');
        $google_id = request('google_id');
        $phone = request('phone');
        $pass = request('password');
        $device_type = request('device_type');
        $social = FALSE;
        if (($fb_id) || ($google_id) || ($phone)) {
            $required = ['device_id', 'device_type', 'grant_type', 'client_id', 'client_secret'];
            ($phone) ? $required[] = 'password' : $social = TRUE;
            if (!$this->validateApiRequest($required)) return $this->response;
        } else {
            if (!$this->validateApiRequest(['phone', 'fb_id', 'google_id', 'device_id', 'device_type', 'grant_type', 'client_id', 'client_secret'])) return $this->response;
        }

        if (!in_array($device_type, [0, 1])) {
            return $this->falseResponse(trans('error.invalid_login'));
        }

        if (!empty($phone)) {
            $credentials = 'phone';
        }
        if (!empty($fb_id)) {
            $credentials = 'fb_id';
        }
        if (!empty($google_id)) {
            $credentials = 'google_id';
        }

        if ($social) {
            $user = User::where([$credentials => $$credentials])->first();
        } else {
            $user = (Auth::attempt([$credentials => $$credentials, 'password' => $pass])) ? Auth::login(Auth::getLastAttempted()) : FALSE;
        }

        if (!$user) {

            if (!$social) {
                return $this->falseResponse(trans('error.invalid_login'));
            }

            return $this->falseResponse(trans('error.invalid_login'));
        }else{
            $this->return['user'] = $user;
            $this->user_id = $user->id;
            return $this->successResponse();
        }

    }

    public function register(Request $request)
    {
        if (!$this->validateApiRequest(['name', 'email', 'phone', 'password', 'device_id', 'device_type'])) return $this->response;
        $fb_id = @$request->input('fb_id');
        $google_id = @$request->input('google_id');

        if (($fb_id) || ($google_id)) {
            $social_id = $google_id;
            $social_type = 'google_id';
            if ($fb_id) {
                $social_id = $fb_id;
                $social_type = 'fb_id';
            }

            $social_user = User::where([
                ['email', $request->input('email')],
                ['phone', $request->input('phone')]
            ])->first();

            if ($social_user) {
                $user = (Auth::attempt(['phone' => $request->input('phone'), 'password' => $request->input('password')])) ? Auth::getLastAttempted() : FALSE;
                if (!$user) {
                    return $this->falseResponse(trans('error.invalid_login'));
                }
                $user->$social_type = $social_id;
                $user->save();
                $this->user_id = $user->id;
            }
        }

        $is_exists = sizeof(User::where('phone', request()->get('phone'))->get());
        $email_exists = User::whereEmail(request('email'))->first();

        if ($is_exists || $email_exists) {
            return $this->falseResponse(trans('error.invalid_login'));

        } else {
            $inputs = $request->only(['name', 'email', 'phone', 'password']);
            $user = User::create($inputs);

            $this->return['token'] = $user->createToken('MyApp')->accessToken;
            $this->user_id = $user->id;
        }

        return $this->successResponse();
    }

    public function update_profile(Request $request)
    {
        if (!$this->validateApiRequest(['user_id', 'device_id', 'device_type'])) return $this->response;

        $user = User::find($this->user_id);

        if (!empty($user)) {
            $inputs = $inputs_ = $request->only(['name', 'email', 'password', 'phone', 'customer_preferences']);
            foreach ($inputs_ as $key => $input) {
                if (empty($input))
                    unset($inputs[$key]);
            }
            /** @var Address $address */
            $user->update($inputs);
            return $this->successResponse();
        } else {
            return $this->falseResponse(trans('error.invalid_login'));
        }

    }

    public function reset_user_password()
    {
        $email = request()->get('email');
        $users = User::where('email', $email)->get();
        if (sizeof($users)) {
            $user = $users[0];

            $this->user_id = $user->id;
            $code = $this->getUserActivationToken();
            $user->reset_code = $code;
            $user->save();
            $this->get_user();
            $settings = $this->settings;
            Mail::send('emails.forgot_password_mail', array('confirm_link' => route('ApiResetUserPasswordCode', array('reset_code' => $code)), 'logo' => asset($settings->logo), 'title' => $settings->title), function ($message) use ($settings, $email) {
                $message->from($settings->support_mail, $settings->title . " - " . trans('global.resetting_password_page'));
                $message->to($email, $settings->title)->subject($settings->title . " - " . trans('global.resetting_password_page'));
            });
            return $this->successResponse();

        } else {
            return $this->falseResponse(trans('error.invalid_login'));
        }
    }

    public function reset_user_password_code($reset_code)
    {
        $user = User::where('reset_code', $reset_code)->first();
        if ($user) {
            $new_password = str_random(10) . $user->id;
            $user->password = bcrypt($new_password);
            $user->reset_code = '';
            $user->save();
            $email = $user->email;
//            $settings = $this->settings;
            Mail::send('emails.forgot_password_confirm_code', array('confirm_code' => $new_password, 'logo' => asset($settings->logo), 'title' => $settings->title), function ($message) use ($settings, $email) {
                $message->from($settings->support_mail, $settings->title . " - " . trans('global.resetting_password_page'));
                $message->to($email, $settings->title)->subject($settings->title . " - " . trans('global.resetting_password_page'));
            });
            echo trans('global.password_sent_to_mail');
        }

    }

}
