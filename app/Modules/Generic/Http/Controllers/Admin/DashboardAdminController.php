<?php

namespace App\Modules\Generic\Http\Controllers\Admin;

class DashboardAdminController extends GenericAdminController
{

    public function backupDB()
    {
        /* backup the db OR just a table */
        $host = 'localhost';
        $user = '4252084e59e3';
        $pass = 'a7eee42d90aa92b2';
        $DbName = 'fakahany';
        $tables = '*';

        $link = mysqli_connect($host, $user, $pass, $DbName);
        $link->set_charset("utf8");
        //get all of the tables
        if ($tables == '*') {
            $tables = array();
            $result = mysqli_query($link, 'SHOW TABLES');
            while ($row = mysqli_fetch_row($result)) {
                $tables[] = $row[0];
            }
        } else {
            $tables = is_array($tables) ? $tables : explode(',', $tables);
        }

        //cycle through
        $return = '';
        foreach ($tables as $table) {
            $result = mysqli_query($link, 'SELECT * FROM ' . $table);
            $num_fields = mysqli_num_fields($result);

            $return .= 'DROP TABLE ' . $table . ';';
            $row2 = mysqli_fetch_row(mysqli_query($link, 'SHOW CREATE TABLE ' . $table));
            $return .= "\n\n" . $row2[1] . ";\n\n";

            for ($i = 0; $i < $num_fields; $i++) {
                while ($row = mysqli_fetch_row($result)) {
                    $return .= 'INSERT INTO ' . $table . ' VALUES(';
                    for ($j = 0; $j < $num_fields; $j++) {
                        $row[$j] = addslashes($row[$j]);
                        $row[$j] = str_replace("\n", "\\n", $row[$j]);
                        if (isset($row[$j])) {
                            $return .= '"' . $row[$j] . '"';
                        } else {
                            $return .= '""';
                        }
                        if ($j < ($num_fields - 1)) {
                            $return .= ',';
                        }
                    }
                    $return .= ");\n";
                }
            }
            $return .= "\n\n\n";
        }
        $fileName = 'db-backup-' . date('Y-m-d') . '-' . (md5(implode(',', $tables))) . '.sql';
        $filePath = base_path() . '/uploads/backupDB/' . $fileName;
        //save file
        $handle = fopen($filePath, 'w+');
        fwrite($handle, $return);
        fclose($handle);

        //download file
        $headers = array(
            'Content-Type: application/octet-stream',
        );
        return response()->download($filePath, $fileName, $headers);
    }



    public function noJs()
    {
        $home = url('/operate');
        return 'Sorry, You have to enable Javascript to be able to continue.<br><a href="' . $home . '">Try Again.</a> ';
    }
}
