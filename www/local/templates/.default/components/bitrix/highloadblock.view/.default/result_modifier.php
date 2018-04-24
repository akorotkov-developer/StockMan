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
    "SECTION_ID" => GetHomeCtalogSection(),
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
$arIdSection = array();
$arIdSectionCount = array();
$arProp = array();
$res = CIBlockElement::GetList(Array("ID"=>"ASC"), $arFilter, false, false, array("ID","IBLOCK_ID","IBLOCK_SECTION_ID"));
while($ar_fields = $res->GetNext()) {
    $arIdProducts[] = $ar_fields["ID"];
    $arIdSection[] = $ar_fields["IBLOCK_SECTION_ID"];
    $arIdSectionCount[$ar_fields["IBLOCK_SECTION_ID"]] = intval($arIdSectionCount[$ar_fields["IBLOCK_SECTION_ID"]]) + 1;
}
$arIdSectionNew = array();
foreach ($arIdSection as $key) {
    $res = CIBlockSection::GetByID($key);
    if ($ar_res = $res->GetNext()) {
        $arIdSectionNew[] = $ar_res["ID"];
        while (intval($ar_res["IBLOCK_SECTION_ID"]) > 0)
        {
            $res = CIBlockSection::GetByID($ar_res["IBLOCK_SECTION_ID"]);
            if ($ar_res = $res->GetNext()) {
                $arIdSectionNew[] = $ar_res["ID"];
            }
        }
    }
}
$arIdSectionNew = array_unique($arIdSectionNew);
$arIdSectionNew = array_diff($arIdSectionNew,$arIdSection);

foreach ($arIdSectionNew as $sectionId) {
    $arFilter = Array(
        "IBLOCK_ID" => StockMan\Config::CATALOG_ID,
        "ACTIVE"=>"Y",
        "CATALOG_AVAILABLE" => "Y",
        "ID" => $arIdProducts,
        "SECTION_ID" => $sectionId,
        "INCLUDE_SUBSECTIONS" => "Y",
    );

    $res = CIBlockElement::GetList(Array("ID" => "ASC"), $arFilter, array("IBLOCK_SECTION_ID"), false, array("ID", "IBLOCK_ID"));
    $arIdSectionCount[$sectionId] = intval($res->SelectedRowsCount());
}
global $arSectionIdBrands;
$arSectionIdBrands = array_unique(array_merge($arIdSectionNew,$arIdSection));

global $arSectionIdBrandsCount;
$arSectionIdBrandsCount = $arIdSectionCount;

$arResult["arIdProducts"] = $arIdProducts;
$this->__component->SetResultCacheKeys(array("arIdProducts"));