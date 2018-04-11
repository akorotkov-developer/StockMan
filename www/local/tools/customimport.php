<?php
if (PHP_SAPI == 'cli') {
    $_SERVER["DOCUMENT_ROOT"] = __DIR__ . '/../../';
}

define('NO_KEEP_STATISTIC', true);
define('NOT_CHECK_PERMISSIONS', true);
define('NO_AGENT_STATISTIC', true);
define('STOP_STATISTICS', true);
define('BX_CRONTAB_SUPPORT', true);
define('LANGUAGE_ID', 'ru');
define("NO_AGENT_CHECK", true);
define('PUBLIC_AJAX_MODE', true);

error_reporting(E_ERROR | E_WARNING | E_PARSE);
ini_set('display_errors', 1);
ini_set('memory_limit', '1024M');
ini_set('post_max_size', '500M');
ini_set('upload_max_filesize', '400M');
ini_set('max_execution_time', '6000');
ini_set('max_input_time', '6000');

@set_time_limit(0);
@ignore_user_abort(true);

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

unlink($_SERVER["DOCUMENT_ROOT"].'/local/tools/cookie.txt');
$exit_code = 0;

try{
    function importCron($file) {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, 'http://new.podium-market.com/bitrix/admin/1c_exchange.php?type=catalog&mode=import&filename='.$file);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);

        $user = "1c_admin";
        $password = "1c_admincetera";
        curl_setopt($curl,CURLOPT_USERAGENT,"Mozilla/4.0");
        curl_setopt($curl,CURLOPT_HEADER,0);

        curl_setopt($curl, CURLOPT_COOKIEJAR, $_SERVER["DOCUMENT_ROOT"].'/local/tools/cookie.txt');
        curl_setopt($curl, CURLOPT_COOKIEFILE, $_SERVER["DOCUMENT_ROOT"].'/local/tools/cookie.txt');

        if(!empty($user) && !empty($password))
        {
            curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($curl,CURLOPT_USERPWD,$user . ":" . $password);
        }
        $data = curl_exec($curl);
        $data = iconv( "cp1251","UTF-8", $data);
        curl_close($curl);

        $pos = strpos($data, 'progress');
        if ($pos === false) {
            $posF = strpos($data, 'failure');
            if ($posF === false) {
                $posS = strpos($data, 'success');
                if ($posS === false) {
                    return false;
                } else {
                    return true;
                }
            } else {
                return false;
            }
        } else {
            importCron($file);
        }
    }

    ImportStokMan::processing();

    $file = 'data_import.xml';
    $fileOffers = 'data_import.xml';

    $urlFile = $_SERVER["DOCUMENT_ROOT"] . '/upload/1c_catalog/' . $file;
    $urlFileOffers = $_SERVER["DOCUMENT_ROOT"] . '/upload/1c_catalog/' . $fileOffers;

    if ((file_exists($urlFile))and(file_exists($urlFileOffers))) {
        $start_time = microtime(true);
        $result = importCron($file);
        $end_time = microtime(true);

        if ($result) {
            writeLogImport("Ок - " . round(($end_time-$start_time),5));

            $start_time = microtime(true);
            $result = importCron($fileOffers);
            $end_time = microtime(true);

            if ($result) {
                writeLogImport("Ок Offers - " . round(($end_time-$start_time),5));
            } else {
                $exit_code = 4;
                writeLogImport("failure");
            }
        } else {
            $exit_code = 3;
            writeLogImport("failure");
        }
    }
    else {
        $exit_code = 2;
        writeLogImport("Файлы не созданы");
    }
} catch (Exception $e){
    $exit_code = 1;
    writeLogImport("Ошибка -- ".$e->getMessage());
}
if ($exit_code > 0) {
    http_response_code(500);
}
exit ($exit_code);