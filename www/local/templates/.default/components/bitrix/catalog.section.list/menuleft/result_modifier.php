<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arFilter         = array(
    'ACTIVE'        => 'Y',
    'IBLOCK_ID'     => StockMan\Config::CATALOG_ID,
    'GLOBAL_ACTIVE' => 'Y'
);
$arSelect         = array('IBLOCK_ID', 'ID', 'NAME', 'DEPTH_LEVEL', 'IBLOCK_SECTION_ID', 'SECTION_PAGE_URL');
$arOrder          = array('DEPTH_LEVEL' => 'ASC', 'SORT' => 'ASC');
$rsSections       = CIBlockSection::GetList($arOrder, $arFilter, false, $arSelect);
$sectionLinc      = array();
$arResult['ROOT'] = array();
$sectionLinc[0]   = &$arResult['ROOT'];
while ($arSection = $rsSections->GetNext()) {
    $sectionLinc[(int)$arSection['IBLOCK_SECTION_ID']]['CHILD'][$arSection['ID']] = $arSection;
    $sectionLinc[$arSection['ID']]                                                = &$sectionLinc[(int)$arSection['IBLOCK_SECTION_ID']]['CHILD'][$arSection['ID']];
}
unset( $sectionLinc );
$arResult['ROOT'] = $arResult['ROOT']['CHILD'];

foreach ($arResult['ROOT'] as $key) {
    if ($key["ID"] != $_SESSION['CurrentSectionCatalog']) {
        unset($arResult['ROOT'][$key["ID"]]);
    }
}

$p = $arParams["CURREN_SECTION_ID"];
$treeofSections = array();
$treeofSections[] = $p;
while (!is_null($p)) {
    $res = CIBlockSection::GetByID($p);
    if ($ar_res = $res->GetNext()) {
        $p = $ar_res['IBLOCK_SECTION_ID'];
        $treeofSections[] = $ar_res['IBLOCK_SECTION_ID'];
    }
}

$arResult["TREE_OF_SECTIONS"] = $treeofSections;
