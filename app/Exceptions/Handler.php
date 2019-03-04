<?php

namespace App\Exceptions;

use App\Modules\Exceptionhandler\Models\ApiLog;
use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        \Illuminate\Auth\AuthenticationException::class,
        \Illuminate\Auth\Access\AuthorizationException::class,
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
        \Illuminate\Session\TokenMismatchException::class,
        \Illuminate\Validation\ValidationException::class,
        \League\OAuth2\Server\Exception\OAuthServerException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Exception $exception
     * @return \Illuminate\Http\Response
     */


//    public function render($request, Exception $exception)
//    {
//        return parent::render($request, $exception);
//    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param Exception $exception
     * @return \Illuminate\Http\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     *
     */
    public function render($request, Exception $exception)
    {


        if ($exception instanceof ApplicationClosed ) {
            if (request()->is('api/*') ) {
                try {


                    return response()->json(['status' => '-10',
                        'error_ar' => 'عفوا النظام حاليا قيد التحديث, حاول في وقت لاحق',
                        'error_en' => 'Sorry. System is under maintenance',

                    ], 500);

                } catch (Exception $e) {
                    return response()->json(['status' => '0',
                        'error_ar' => 'حدث خطأ',
                        'error_en' => 'something went wrong',

                    ], 500);
                }
            }
            return response()->view('generic::front.pages.under_maintenance');

        }







        /**
         * @var $exception Exception
         */
        if (($exception instanceof HttpException && $exception->getStatusCode() == 403)) {//|| $exception instanceof AuthorizationException) {

//            session()->flash('message', 'You Are Not Authorized!');
            sweet_alert()->error('Error', 'You Are Not Authorized!');
            return redirect()->to('login');
        }
        return parent::render($request, $exception);
    }

    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Illuminate\Auth\AuthenticationException $exception
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json(['error' => 'Unauthenticated.', 'action' => '', 'action_data' => []], 401);
        }

        return redirect()->guest('login');
    }
}
