<?php

namespace App\Modules\Notification\Models;

use App\Modules\Generic\Models\GenericModel;

class Push_tokens extends GenericModel
{
    protected $table = 'push_tokens';
    protected $guarded = [];
}
