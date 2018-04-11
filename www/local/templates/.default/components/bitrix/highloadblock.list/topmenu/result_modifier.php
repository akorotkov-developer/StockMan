<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$arResultTemp = array();
foreach ($arResult['rows'] as $row){
    if (in_array($row['UF_XML_ID'], $arParams["AR_FILTER"])) {
        $arResultTemp[] = $row;
    }
}
$arResult['rows'] = $arResultTemp;
?>