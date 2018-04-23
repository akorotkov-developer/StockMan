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

error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('memory_limit', '1024M');
ini_set('post_max_size', '512M');
ini_set('upload_max_filesize', '512M');
ini_set('max_file_uploads', '512');
ini_set('max_execution_time', '6000');
ini_set('max_input_time', '6000');
ini_set('allow_url_fopen', 'On');
ini_set('error_reporting', E_ALL);

@set_time_limit(0);
@ignore_user_abort(true);

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/local/tools/CImportStokMan.php");

$urlFile = $_SERVER["DOCUMENT_ROOT"] . ImportStokMan::$FILE_NAME;

$handle = fopen($urlFile, "rb");
if (FALSE === $handle) {
    exit("Не удалось открыть поток по url адресу");
}

$contents = '';

while (!feof($handle)) {
    $line = stream_get_line($handle, 1000000, "\n");
    $contents .= preg_replace("/[\t\r\n]+/",'',html_entity_decode($line, ENT_NOQUOTES, 'UTF-8'));
    // полезная работа
}
fclose($handle);

$urlFileDataRazmer = $_SERVER["DOCUMENT_ROOT"] . ImportStokMan::$FILE_IMPORT_RAZMER;
$f_hdl = fopen($urlFileDataRazmer, 'w');
fwrite($f_hdl, $contents);
fclose($f_hdl);
/*
$content = file_get_contents($urlFile, false);
$content = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $content); //trim(preg_replace("/[\r\n]+/m","\r\n", $content));
$content = html_entity_decode($content, ENT_NOQUOTES, 'UTF-8');
$urlFileDataRazmer = $_SERVER["DOCUMENT_ROOT"] . ImportStokMan::$FILE_IMPORT_RAZMER;
$strXMLRazmer = html_entity_decode($content, ENT_NOQUOTES, 'UTF-8');

$f_hdl = fopen($urlFileDataRazmer, 'w');
fwrite($f_hdl, $strXMLRazmer);
fclose($f_hdl);

echo "<pre>";
print_r($content);
echo "</pre>";
*/
/*$handle = fopen($urlFile, "r");
if ($handle) {
    while (($buffer = fgets($handle)) !== false) {
        echo $buffer;
    }
    if (!feof($handle)) {
        echo "Error: unexpected fgets() fail\n";
    }
    fclose($handle);
}/
/*
$fr=fopen($urlFile,'r');
$strAl = '';
while(!feof($fr)) {
    $str = '';
    while("\r"!==($chr=fgetc($fr)) && (!feof($fr))){
        echo "<pre>";
        print_r($chr);
        echo "</pre>";
        $str.=$chr;
    }
    fgetc($fr);
    $strAl .= $str;
}*/
//fclose($fr);
//$f_hdl = fopen($_SERVER["DOCUMENT_ROOT"] . '/local/logs/data_import_razmer3.xml', 'w');
//fwrite($f_hdl, $strAl);
//fclose($f_hdl);
//$new = file($urlFile);
//$file = fopen($_SERVER["DOCUMENT_ROOT"] . ImportStokMan::$FILE_IMPORT_RAZMER, 'w+');

//$content = file_get_contents($urlFile, false);
//$content = trim(preg_replace("/[\r\n]+/m","\r\n", $content));
echo "<pre>";
//print_r($str);
echo "</pre>";
/*foreach($new as $v)
    if($v != "\r\n")
        fwrite($file, $v);

fclose($file);
*/