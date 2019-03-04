<?php

namespace App\Modules\Access\Models;

use Zizaco\Entrust\EntrustPermission;

class Permission extends EntrustPermission
{
    public function group()
    {
        return $this->belongsTo(Group::class);
    }
}
