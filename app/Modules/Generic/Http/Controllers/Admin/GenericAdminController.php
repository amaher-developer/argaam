<?php

namespace App\Modules\Generic\Http\Controllers\Admin;

use App\Modules\Argaam\Models\Article;
use App\Modules\Crud\Models\Migration;
use App\Modules\Generic\Http\Controllers\GenericController;
use App\Modules\Generic\Repositories\SettingRepository;
use Caffeinated\Modules\Facades\Module;
use Illuminate\Container\Container as Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\View;

class GenericAdminController extends GenericController
{
    public $user;
    public $limit;
    public $request_array;
    public $SettingRepository;
    public $modules_need_migration;

    public function __construct()
    {


        if (!request()->is('operate') && !request()->is('operate/admin/log')) {
//            AdminLog::create([
//                'admin_id' => Auth::user()->id,
//                'link' => request()->fullUrl()
//            ]);
        }

        $this->SettingRepository = new SettingRepository(new Application);

        request()->session()->put('lang', 'en');
        app()->setLocale(request()->session()->get('lang'));
        $user = Auth::user();
        $this->user = $user;
        $this->limit = 10;
        $this->request_array = [];

        $this->modules_need_migration = false;
        $modules = Module::all();
        foreach ($modules as $module) {
            if (!$this->modules_need_migration) {
                foreach (File::allFiles(module_path($module['slug']) . '/Database/Migrations/') as $module_migrations) {
                    $migration_name = pathinfo($module_migrations->getPathname())['filename'];
                    if (sizeof(Migration::where('migration', $migration_name)->get()) == 0) {
                        $this->modules_need_migration = true;
                        break;
                    }
                }

            } else {
                break;
            }
        }


        View::share('migrate', $this->modules_need_migration);
        View::share('settings', $this->SettingRepository->first());
        View::share('current_user', $user);

    }

    public function showHome()
    {
        $article_count = Article::where('user_id', Auth::user()->id)->count();
        $article_feature_count = Article::where('user_id', Auth::user()->id)->where('featured', 1)->count();
        return view('generic::index', ['title' => 'Dashboard', 'article_feature_count' => $article_feature_count, 'article_count' => $article_count]);
    }

    public function uploadImageForCKEditorAjax()
    {
        $input_file = 'file';
        if (request()->hasFile($input_file)) {
            $file = request()->file($input_file);
            $filename = rand(0, 20000) . time() . '.' . $file->getClientOriginalExtension();
            $destinationPath = base_path('uploads/ckeditor/');
            $image_url = asset('uploads/ckeditor/' . $filename);
            $upload_success = $file->move($destinationPath, $filename);
            if ($upload_success) {
                echo $image_url;
            }
        } else {
            echo '{"status":"error"}';
        }

    }

    public function checkForNewNotifications(Request $request)
    {
//        $now = Carbon::createFromTimestamp(time());
//        $last_order_time = $request->last_order_time ? Carbon::createFromTimestamp($request->last_order_time) : $now;
//        $last_ticket_time = $request->last_ticket_time ? Carbon::createFromTimestamp($request->last_ticket_time) : $now;
//
//        $response['orders'] = Order::where('created_at', '>=', $last_order_time)->get()->toArray();
//        $response['tickets'] = Ticket::where('created_at', '>=', $last_ticket_time)->get()->toArray();
//        $response['last_time_to_get_notification'] = $last_ticket_time->toDateTimeString();
//        if (!$response['orders'] && !$response['tickets'])
//            return ['status' => false, 'data' => ['last_time_to_get_notification' => $last_ticket_time->toDateTimeString()]];
//
//        return ['status' => true, 'data' => $response];

    }


}
