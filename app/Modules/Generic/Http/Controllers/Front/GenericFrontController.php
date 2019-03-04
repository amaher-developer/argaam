<?php

namespace App\Modules\Generic\Http\Controllers\Front;
use App\Modules\Argaam\Models\Category;
use Illuminate\Container\Container as Application;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Modules\Generic\Http\Controllers\GenericController;
use App\Modules\Generic\Models\Setting;

use App\Modules\Generic\Repositories\SettingRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class GenericFrontController extends GenericController
{
    public $lang;
    public $user;
    public $SettingRepository;

    public function __construct()
    {
        $this->SettingRepository=new SettingRepository(new Application);
        parent::__construct();
        if (request()->segment(1) != 'ar' && request()->segment(1) != 'en') {
            request()->session()->put('lang', 'ar');
            app()->setLocale(request()->session()->get('lang'));
            $this->lang = 'ar';
        } else {
            $this->lang = request()->segment(1);
        }
        $lang_changed = session()->get('lang_changed');
        View::share('settings', $this->SettingRepository->first());

        $user = Auth::user();
        $this->user = $user;
        View::share('current_user', $user);
        View::share('categories', Category::get());
        if ($lang_changed) {
//            do something
        }
    }
}
