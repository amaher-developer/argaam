<?php

namespace App\Modules\Access\Models;

use Zizaco\Entrust\EntrustRole;

class Role extends EntrustRole
{
    protected $fillable = ['name', 'display_name', 'description'];
    public $timestamps = TRUE;

}
