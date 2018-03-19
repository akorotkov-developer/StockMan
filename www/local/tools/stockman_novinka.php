<?php
$_SERVER["DOCUMENT_ROOT"] = '/var/www/podium-market.com/www';

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include.php");

define('NO_KEEP_STATISTIC', true);
define('NOT_CHECK_PERMISSIONS', true);
define('NO_AGENT_STATISTIC', true);
define('STOP_STATISTICS', true);
define('BX_CRONTAB_SUPPORT', true);
define('LANGUAGE_ID', 'ru');

error_reporting(E_ERROR | E_WARNING | E_PARSE);
ini_set('display_errors', 1);
ini_set('memory_limit', '512M');

@set_time_limit(0);
@ignore_user_abort(true);

$IblockID = StockMan\Config::CATALOG_ID;
$strData = time();

// проставляем свойство "Новинка"
$arFilter = Array(
    "IBLOCK_ID"         =>  $IblockID,
    "CATALOG_AVAILABLE" =>  "Y",
    "PROPERTY_" . StockMan\Config::PROP_WAS_NOVINKA => false,
    "!PROPERTY_" . StockMan\Config::PROP_NOVINKA => false,
    array (
        "LOGIC" => "OR",
        array("!DETAIL_PICTURE" => false),
        array("!PROPERTY_MORE_PHOTO" => false),
    )
);
$arSelect = array(
    "IBLOCK_ID",
    "ID"
);
$res = CIBlockElement::GetList(Array("ID"=>"ASC"), $arFilter, false, false, $arSelect);
while($ar_fields = $res->GetNext()) {
    $idProduct = $ar_fields["ID"];
    CIBlockElement::SetPropertyValues($idProduct, $IblockID, $strData, StockMan\Config::PROP_NOVINKA_DATE);
    CIBlockElement::SetPropertyValues($idProduct, $IblockID, StockMan\Config::PROP_NOVINKA_VAL, StockMan\Config::PROP_NOVINKA);
    CIBlockElement::SetPropertyValues($idProduct, $IblockID, StockMan\Config::PROP_WAS_NOVINKA_VAL, StockMan\Config::PROP_WAS_NOVINKA);
}
// убираем свойство "Новинка"
$strData = strtotime(StockMan\Config::PROP_PERIOD_NOVINKA);
$arFilter = Array(
    "IBLOCK_ID"         =>  $IblockID,
    "!PROPERTY_" . StockMan\Config::PROP_NOVINKA => false,
    "!PROPERTY_" . StockMan\Config::PROP_NOVINKA_DATE => '',
    array (
        "LOGIC" => "OR",
        array("DETAIL_PICTURE" => false),
        array("!CATALOG_AVAILABLE" => false),
        array("<PROPERTY_" . StockMan\Config::PROP_NOVINKA_DATE => $strData),
    )
);
$arSelect = array(
    "IBLOCK_ID",
    "ID"
);
$res = CIBlockElement::GetList(Array("ID"=>"ASC"), $arFilter, false, false, $arSelect);
while($ar_fields = $res->GetNext()) {
    $idProduct = $ar_fields["ID"];
    CIBlockElement::SetPropertyValues($idProduct, $IblockID, '', StockMan\Config::PROP_NOVINKA_DATE);
    CIBlockElement::SetPropertyValues($idProduct, $IblockID, false, StockMan\Config::PROP_NOVINKA);
}