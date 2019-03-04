<?php

namespace App\Modules\Notification\Models;

use App\Modules\Generic\Models\GenericModel;

class Notification extends GenericModel
{
    protected $table = 'notifications';
    protected $guarded = ['id'];
    protected $appends = [];
    public static $uploads_path = 'uploads/notifications/';
}
