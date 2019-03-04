<?php

namespace App\Modules\Generic\Models;


use App\Modules\Generic\Events\SettingUpdated;
use Illuminate\Support\Facades\Cache;

class Setting extends GenericModel
{
//    protected $table = '';
    protected $guarded = ['id'];
    protected $appends = ['name', 'logo', 'about'];
    public static $uploads_path = 'uploads/settings/';

    protected $dispatchesEvents = ['updated' => SettingUpdated::class];

    public function getNameAttribute()
    {
        $lang = 'name_' . $this->lang;
        return (string)$this->$lang;
    }

    public function getLogoArAttribute($logo)
    {
        if ($logo) {
            return Asset(self::$uploads_path . $logo);
        } else
            return $logo;
    }

    public function getLogoEnAttribute($logo)
    {

        if ($logo) {
            return Asset(self::$uploads_path . $logo);
        } else
            return $logo;
    }

    public function getLogoAttribute()
    {
        $lang = 'logo_' . $this->lang;
        return $this->$lang;
    }


    public function getAboutAttribute()
    {
        $lang = 'about_' . $this->lang;
        return (string)$this->$lang;
    }

    public function getMetaKeywordsArAttribute($meta_keywords_ar)
    {

        if ($meta_keywords_ar) {
            return explode('&', $meta_keywords_ar);
        } else
            return $meta_keywords_ar;
    }

    public function getMetaKeywordsEnAttribute($meta_keywords_en)
    {

        if ($meta_keywords_en) {
            return explode('&', $meta_keywords_en);
        } else
            return $meta_keywords_en;
    }

    public function updateSettingWithCache()
    {
        return Cache::put('settings',$this,60 * 24 * 30);
    }

}
