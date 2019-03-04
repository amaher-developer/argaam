<?php

namespace App\Modules\Argaam\Models;

use App\Modules\Generic\Models\GenericModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class Article extends GenericModel
{

    protected $dates = ['deleted_at'];

//    protected $table = '';
    protected $guarded = ['id'];
    protected $appends = ['slug'];
    public static $uploads_path='uploads/articles/';
    public static $thumbnails_uploads_path='uploads/articles/thumbnails/';

    public function getSlugAttribute()
    {
        return urldecode(str_replace(' ', '-',strtolower($this->getOriginal('title'))));
    }

    public function category(){
        return $this->belongsTo(Category::class, 'category_id');
    }
    public function images(){
        return $this->hasMany(ArticleImage::class, 'article_id');
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
