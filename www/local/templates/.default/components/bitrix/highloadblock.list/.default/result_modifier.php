<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$arResultTemp = array();
foreach ($arResult['rows'] as $row){
    $rowTemp = array();

    $arFilter = Array(
        "IBLOCK_ID" => StockMan\Config::CATALOG_ID,
        "ACTIVE"=>"Y",
        "CATALOG_AVAILABLE" => "Y",
        "PROPERTY_".StockMan\Config::PROP_CODE_BRANDS."_VALUE" => $row["ID"],
        "INCLUDE_SUBSECTIONS" => "Y"
    );
    $res = CIBlockElement::GetList(Array("SORT"=>"ASC", "PROPERTY_PRIORITY"=>"ASC"), $arFilter, false, array("nTopCount" => 1), array("ID","NAME", "IBLOCK_ID"));
    while($ar_fields = $res->GetNext()) {
        $rowTemp["ID"] = $row["ID"];
        $rowTemp["name"] = ToUpper(trim($row["UF_NAME"]));
        $rowTemp["sort"] = intval($row["UF_SORT"]);

        $letter = ToUpper(substr(preg_replace ("/[^a-zA-ZА-Яа-я0-9\s]/","",$rowTemp["name"]), 0, 1));

        $arResultTemp[$letter][] = $rowTemp;
    }
}

ksort($arResultTemp);
$arResult['rows'] = $arResultTemp;
?>