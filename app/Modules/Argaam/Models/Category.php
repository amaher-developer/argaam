<?php

namespace App\Modules\Argaam\Models;

use App\Modules\Generic\Models\GenericModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class Category extends GenericModel
{

    protected $dates = ['deleted_at'];

//    protected $table = '';
    protected $guarded = ['id'];
    protected $appends = ['slug'];
    public static $uploads_path='uploads/categories/';
    public static $thumbnails_uploads_path='uploads/categories/thumbnails/';

    public function getSlugAttribute()
    {
        return urldecode(str_replace(' ', '-',strtolower($this->getOriginal('name'))));
    }

    public function articles()
    {
        return $this->hasMany(Article::class, 'category_id');
    }


    public function toArray()
    {
        return parent::toArray();
        $to_array_attributes = [];
        foreach ($this->relations as $key => $relation) {
            $to_array_attributes[$key] = $relation;
        }
        foreach ($this->appends as $key => $append) {
            $to_array_attributes[$key] = $append;
        }
        return $to_array_attributes;
    }

}
