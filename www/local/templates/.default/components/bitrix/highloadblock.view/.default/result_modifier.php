<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$arResultTemp = array();

$arFilter = Array(
    "IBLOCK_ID" => StockMan\Config::CATALOG_ID,
    "ACTIVE"=>"Y",
    "CATALOG_AVAILABLE" => "Y",
    "!PROPERTY_".StockMan\Config::PROP_CODE_BRANDS => false,
    "PROPERTY_".StockMan\Config::PROP_CODE_BRANDS => $arResult['fields']["UF_XML_ID"]["VALUE"],
    "INCLUDE_SUBSECTIONS" => "Y",
    //"SECTION_ID" => GetHomeCtalogSection(),
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
$arIdProducts = array();
$arProp = array();
$res = CIBlockElement::GetList(Array("ID"=>"ASC"), $arFilter, false, false, array("ID","IBLOCK_ID"));
while($ar_fields = $res->GetNext()) {
    $arIdProducts[] = $ar_fields["ID"];
    //$arProp[] = $ar_fields['PROPERTY_' . StockMan\Config::PROP_CODE_BRANDS . '_VALUE'];
}

$arResult["arIdProducts"] = $arIdProducts;
$this->__component->SetResultCacheKeys(array("arIdProducts"));