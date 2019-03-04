<?php

namespace App\Modules\Generic\Http\Controllers\Front;

use App\Modules\Access\Models\UserAddress;
use App\Modules\Ad\Models\Banner;
use App\Modules\Argaam\Models\Category;
use App\Modules\Generic\Models\Setting;
use App\Modules\Item\Models\Item;
use App\Modules\Location\Models\Area;
use App\Modules\Location\Models\City;
use Illuminate\Support\Facades\View;

class MainFrontController extends GenericFrontController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $title = trans('global.home');
        $home_vars = [];
        return view('generic::front.layouts.master', compact('$home_vars', 'title'));
    }

    public function search()
    {
//        $keyword = request()->input('keyword');
//        $items = [];
//        $msg = "";
//        if ($keyword) {
//            $items = Item::where('id', (int)request('keyword'))
//                ->orWhere('name_ar', 'like', '%' . request('keyword') . '%')
//                ->orWhere('name_en', 'like', '%' . request('keyword') . '%')
//                ->whereHas('item_units')
//                ->whereHas('item_warehouse', function ($q) {
//                    $q->where('warehouse_id', $this->warehouse);
//                })->with('item_warehouse', 'item_units')->get();
//        } else {
//            $msg = trans('global.search_results_not_found');
//        }
//        $title = trans('global.search_results');
//
//        if (!request()->session()->has('currentArea')) {
//            $cities = City::all();
//            $areas = Area::all();
//        } else {
//            $cities = '';
//            $areas = '';
//        }
//
//        return view('generic::front.layouts.search', compact('items', 'title', 'cities', 'areas', 'msg'));
    }

    public function about()
    {
        return view('generic::front.pages.about', [
            'title' => trans('global.about_us'),
            'about' => Setting::first()->about
        ]);
    }

}
