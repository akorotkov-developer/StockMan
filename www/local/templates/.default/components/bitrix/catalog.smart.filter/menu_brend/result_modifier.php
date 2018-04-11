<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$arUF_XML_ID = array();
$arItems = array();
$arUF_XML_ID = array();
foreach($arResult["ITEMS"] as $key=>$arItem)
{
    $i = 0;
    if ($arItem['CODE'] == StockMan\Config::PROP_CODE_BRANDS) {
        foreach($arItem["VALUES"] as $keyVal=>$arItemVal)
        {
            if ($i <= 9) {
                $arUF_XML_ID[] = $arItemVal["URL_ID"];
            }
            $i++;
        }
        $arResult["ITEMS"][$key]["VALUES"] = $arItems;
    }
}
$arResult["ITEMS"] = $arUF_XML_ID;
