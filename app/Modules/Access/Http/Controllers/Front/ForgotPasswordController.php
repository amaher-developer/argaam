<?php

namespace App\Modules\Access\Http\Controllers\Front;

use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use App\Modules\Generic\Http\Controllers\Front\GenericFrontController;

class ForgotPasswordController extends GenericFrontController
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->middleware('guest');
    }
}
