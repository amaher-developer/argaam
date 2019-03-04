<?php

namespace App\Modules\Generic\Http\Middleware;

use App\Exceptions\ApplicationClosed;
use App\Modules\Generic\Models\Setting;
use Closure;

class UnderMaintenance
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!request()->is('operate') && !request()->is('operate/*')) {
            $under_maintenance = Setting::first()->value('under_maintenance');
            if($under_maintenance)
            {
                 throw new ApplicationClosed();
            }

        }
        return $next($request);
    }

}
