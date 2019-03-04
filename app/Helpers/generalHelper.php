<?php

function sweet_alert($title = NULL, $message = NULL)
{
    $flash = app('App\Http\Flash');

    if(func_num_args() == 0){
        return $flash;
    }

    return $flash->info($title, $message);
}



function ar_digits($en_digit)
{
    return str_replace(['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'], ["٠", "١", "٢", "٣", "٤", "٥", "٦", "٧", "٨", "٩"], $en_digit);
}

function en_digits($ar_digit)
{
    return str_replace(["٠", "١", "٢", "٣", "٤", "٥", "٦", "٧", "٨", "٩"], ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'], $ar_digit);
}


//function has_any_access(array $permissions,$current_user)
//{
//    return count(array_intersect(array_merge($permissions, ['super']), $current_user->perms)) > 0;
//}

function date_to_ar($en_date)
{
    $days_names_en = ['Saturday', 'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
    $days_names_ar = ['السبت', 'الأحد', 'الإثنين', 'الثلاثاء', 'الأربعاء', 'الخميس', 'الجمعة'];
    return ar_digits(str_replace($days_names_en, $days_names_ar, $en_date));
}

function date_to_en($ar_date)
{
    $days_names_en = ['Saturday', 'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', '0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
    $days_names_ar = ['السبت', 'الأحد', 'الإثنين', 'الثلاثاء', 'الأربعاء', 'الخميس', 'الجمعة', "٠", "١", "٢", "٣", "٤", "٥", "٦", "٧", "٨", "٩"];
    return str_replace($days_names_ar, $days_names_en, $ar_date);
}



function is_image($file_path)
{
    $allowedMimeTypes = ['image/jpeg', 'image/gif', 'image/png', 'image/bmp', 'image/svg+xml'];
    $contentType = mime_content_type($file_path);

    if (!in_array($contentType, $allowedMimeTypes)) {
        return FALSE;
    }
    return TRUE;
}

function is_image_remote_link($file_path)
{
    if ($file_path != '') {
        stream_context_set_default([
            'ssl' => [
                'verify_peer' => FALSE,
                'verify_peer_name' => FALSE,
            ],
        ]);

        $contentType = get_headers($file_path, 1)['Content-Type'];
        $allowedMimeTypes = ['image/jpeg', 'image/gif', 'image/png', 'image/bmp', 'image/svg+xml'];
        if (!in_array($contentType, $allowedMimeTypes)) {
            return FALSE;
        }
        return TRUE;
    } else {
        return FALSE;
    }

}
