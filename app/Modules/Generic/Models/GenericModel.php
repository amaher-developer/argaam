<?php

namespace App\Modules\Generic\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GenericModel extends Model
{
    use SoftDeletes;
    public static $table_columns = [];
    public $lang;
    protected $dates = ['deleted_at'];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        if ((request()->is('api/*'))) {
            $lang = request()->get('lang');
            $this->lang = isset($lang) && !in_array($lang, explode(',', env('SYSTEM_LANG'))) ? $lang : env('DEFAULT_LANG');
        } elseif (request()->is('operate/*')) {
            $this->lang =env('DEFAULT_LANG');
        } else {
            $lang = session('lang');
            $this->lang = isset($lang) ? $lang : 'en';
        }

//        $this->castAllAttributesToString();
    }

//    private function castAllAttributesToString()
//    {
//
//        if (request()->is('api/*')) {
//            if (!key_exists($this->table, self::$table_columns)) {
//                $columns = DB::getSchemaBuilder()->getColumnListing($this->table);
//                self::$table_columns[$this->table] = $columns;
//            } else {
//                $columns = self::$table_columns[$this->table];
//            }
//
//
//            foreach ($columns as $column) {
//
//                $this->casts[$column] = 'string';
//            }
//        }
//    }

}
