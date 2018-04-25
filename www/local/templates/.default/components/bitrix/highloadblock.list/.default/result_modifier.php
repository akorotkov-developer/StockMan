<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$arResultTemp = array();

$arFilter = Array(
    "IBLOCK_ID" => StockMan\Config::CATALOG_ID,
    "ACTIVE"=>"Y",
    "CATALOG_AVAILABLE" => "Y",
    "!PROPERTY_".StockMan\Config::PROP_CODE_BRANDS => false,
    "INCLUDE_SUBSECTIONS" => "Y",
    //"SECTION_ID" => $arParams["AR_FILTER"],
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
    $arProp[] = $ar_fields['PROPERTY_' . StockMan\Config::PROP_CODE_BRANDS . '_VALUE'];
}
foreach ($arResult['rows'] as $row){
    if (in_array($row['UF_XML_ID'], $arProp)) {
        $rowTemp["ID"] = $row["ID"];
        $rowTemp["UF_CODE"] = $row["UF_CODE"];
        $rowTemp["name"] = ToUpper(trim($row["UF_NAME"]));
        $rowTemp["sort"] = intval($row["UF_SORT"]);

        $letter = ToUpper(substr(preg_replace ("/[^a-zA-ZА-Яа-я0-9\s]/","",$rowTemp["name"]), 0, 1));

        $arResultTemp[$letter][] = $rowTemp;
    }
}

ksort($arResultTemp);
$arResult['rows'] = $arResultTemp;
?>