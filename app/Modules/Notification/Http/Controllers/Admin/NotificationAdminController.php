<?php

namespace App\Modules\Notification\Http\Controllers\Admin;

use App\Modules\Item\Models\Item;
use App\Modules\Item\Models\Category;
use App\Modules\Notification\Http\Requests\NotificationRequest;
use App\Modules\Generic\Http\Controllers\Admin\GenericAdminController;
use App\Modules\Notification\Models\Notification;

class NotificationAdminController extends GenericAdminController
{

    public function index()
    {
        return view('notification::Admin.notification_admin_list', [
            'title' => 'Notifications',
            'notifications' => Notification::orderBy('id', 'DESC')->get(),
        ]);
    }

    public function create()
    {
        $title = 'Create Notification';
        return view('notification::Admin.notification_admin_form', [
            'title' => $title,
            'items' => Item::select('id', 'name_en')->get(),
            'categories' => Category::select('id', 'name_en')->get(),
        ]);
    }

    public function push(NotificationRequest $request)
    {
        $this->validate($request, ['title' => 'required', 'type' => 'required']);
        $data['title'] = $request->title;
        $data['type'] = $request->type;
        $data['body'] = $request->body;

        switch ($request->type) {
            case 1:
                $data['id'] = $request->product;
                break;
            case 2:
                $data['id'] = $request->category;
                $category = Category::find($request->category);
                $data['category_name_ar'] = $category->name_ar;
                $data['category_name_en'] = $category->name_en;
                break;
            case 3:
                $data['url'] = $request->url;
        }

        if ($request->test) {
            $push = OneSignalController::notifySendToUsersByUserIds([1482], $data);
        } else {
            $push = OneSignalController::notifySendToAllUsers($data);
        }

        $response = json_decode($push);


        if (@$response->recipients) {
            Notification::create([
                'title' => $request->title,
                'notification_id' => $response->id
            ]);

            $request->session()->flash('notification_recipients', $response->recipients);
            sweet_alert()->success('Done', 'Notification Sent Successfully');
            return redirect()->back();
        } else {
            $request->session()->flash('notification_error', $push);
            sweet_alert()->info('Error', 'Something went wrong');
            return redirect()->back()->withInput();
        }
    }

    public function show(Notification $notification)
    {
        $stats = OneSignalController::getNotificationStats($notification->notification_id);
        return view('notification::Admin.notification_admin_show', [
            'title' => $notification->title,
            'stats' => json_decode($stats),
            'notification' => $notification
        ]);
    }

}
