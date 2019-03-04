<?php

namespace App\Modules\Generic\Http\Controllers\Admin;

use App\Modules\Generic\Http\Controllers\Admin\GenericAdminController;
use App\Modules\Generic\Http\Requests\SettingRequest;
use App\Http\Controllers\Controller;
use App\Modules\Generic\Models\Setting;

class SettingAdminController extends GenericAdminController
{

    public function edit()
    {
        $title = 'Update Content';
        return view('generic::Admin.setting_admin_form', ['title'=>$title]);
    }

    public function update(SettingRequest $request, Setting $setting)
    {
        $setting_inputs = $this->prepare_inputs($request->except(['_token']));
       $setting->update($setting_inputs);
        sweet_alert()->success('Done', 'Setting updated successfully');
        return redirect(route('editSetting',1));
    }

    private function prepare_inputs($inputs)
    {
        $input_file = 'logo_ar';
        if (request()->hasFile($input_file)) {
            $file = request()->file($input_file);
            $filename = rand(0, 20000) . time() . '.' . $file->getClientOriginalExtension();
            $destinationPath = base_path(Setting::$uploads_path);
            $upload_success = $file->move($destinationPath, $filename);
            if ($upload_success) {
                $inputs[$input_file] = $filename;
            }
        }else{
        unset($inputs[$input_file]);
        }

        $input_file = 'logo_en';
        if (request()->hasFile($input_file)) {
            $file = request()->file($input_file);
            $filename = rand(0, 20000) . time() . '.' . $file->getClientOriginalExtension();
            $destinationPath = base_path(Setting::$uploads_path);
            $upload_success = $file->move($destinationPath, $filename);
            if ($upload_success) {
                $inputs[$input_file] = $filename;
            }
        }else{
        unset($inputs[$input_file]);
        }

        $inputs['meta_keywords_ar'] = implode('&', $inputs['meta_keywords_ar']);
        $inputs['meta_keywords_en'] = implode('&', $inputs['meta_keywords_en']);
        $inputs['about_ar'] = nl2br($inputs['about_ar'], false);
        $inputs['about_en'] = nl2br($inputs['about_en'], false);
        $inputs['terms_ar'] = nl2br($inputs['terms_ar'], false);
        $inputs['terms_en'] = nl2br($inputs['terms_en'], false);

        return $inputs;
    }


    function mergeArrays($variables_en, $variables_ar) {
        $result = array();
        $i = 0;
        foreach ( $variables_en as $key => $variable_en ) {
            if(in_array($key, array_keys($variables_ar))) {
                $result[] = array('en' => $variable_en, 'ar' => $variables_ar[$key], 'key' => $key);
            }
        }
        return $result;
    }

    public function staticVariableUpdate()
    {
        $variables_en = include base_path('resources/lang/en/global.php');
        $variables_ar = include base_path('resources/lang/ar/global.php');
        $variables = $this->mergeArrays($variables_en,$variables_ar);

        $title = 'Static Variables';
        return view('generic::Admin.static_variables_admin_form', ['title'=>$title, 'variables_en'=>$variables_en, 'variables_ar'=>$variables_ar , 'variables'=>$variables ]);
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function staticVariableStore()
    {
        $keys = \request('keys');
        $value_en = \request('value_en');
        $value_ar = \request('value_ar');

        $ens = array_combine($keys, $value_en);
        $ars = array_combine($keys, $value_ar);

        $content_en = '<?php 
        return [';
        foreach($ens as $key=>$value){
            $content_en.= '"'.$key.'" => "'.$value.'",
            ';
        }
        $content_en.='
];';


        $content_ar = '<?php 
        return [';
        foreach($ars as $key=>$value){
            $content_ar.= '"'.$key.'" => "'.$value.'",
            ';
        }
        $content_ar.='
];';

        File::put(base_path('resources/lang/en/global.php'), $content_en);
        File::put(base_path('resources/lang/ar/global.php'), $content_ar);

        sweet_alert()->success('Done', 'Setting updated successfully');
        return redirect()->back();
    }

}
