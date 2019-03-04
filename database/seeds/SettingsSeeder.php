<?php

use App\Modules\Generic\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $settingExist = Setting::find(1);
        if (!$settingExist) {
            $settings = new Setting();
            $settings->id = 1;
            $settings->name_en = 'System Title en';
            $settings->name_ar = 'System Title ar';
            $settings->phone = '0123456789';
            $settings->meta_description_en = 'meta description ar';
            $settings->meta_keywords_en = 'meta keywords ar';
            $settings->meta_description_ar = 'meta description en';
            $settings->meta_keywords_ar = 'meta keywords ar';
            $settings->save();
        }
    }
}
