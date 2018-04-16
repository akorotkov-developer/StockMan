<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if (!function_exists('sortBrands'))
{
    function sortBrands($a, $b)
    {
        if (intval($a["UF_SORT"]) == intval($b["UF_SORT"])) {
            return 0;
        }
        return (intval($a["UF_SORT"]) < intval($b["UF_SORT"])) ? -1 : 1;
    }
}

$arResultTemp = array();
$arResultTempBrends = array();
foreach ($arResult['rows'] as $row){
    $arResultTempBrends[] = $row;
}
usort($arResultTempBrends, "sortBrands");
$arFilter = Array(
    "IBLOCK_ID" => StockMan\Config::CATALOG_ID,
    "ACTIVE"=>"Y",
    "CATALOG_AVAILABLE" => "Y",
    "!PROPERTY_".StockMan\Config::PROP_CODE_BRANDS => false,
    "INCLUDE_SUBSECTIONS" => "Y",
    "SECTION_ID" => $arParams["AR_FILTER"],
    "!SECTION_ID" => array(
        ImportStokMan::$IBLOCK_SECTION_ERROR_ID,
        ImportStokMan::$IBLOCK_SECTION_ID,
    ),
    array (
        "LOGIC" => "OR",
        array("!DETAIL_PICTURE" => false),
        array("!PROPERTY_MORE_PHOTO" => false),
    )
);
$arProp = array();
$res = CIBlockElement::GetList(Array("ID"=>"ASC"), $arFilter, array("PROPERTY_".StockMan\Config::PROP_CODE_BRANDS), false, array("ID","IBLOCK_ID"));
while($ar_fields = $res->GetNext()) {
    $arProp[] = $ar_fields['PROPERTY_MARKA_VALUE'];
}
$i = 0;
$arResultBrends = array();
foreach ($arResultTempBrends as $row){
    if (($i < 10)and(in_array($row['UF_XML_ID'], $arProp))) {
        $arResultBrends[] = $row;
        $i++;
    } elseif ($i >= 10){
        break;
    }
}
$arResult['rows'] = $arResultBrends;
?>