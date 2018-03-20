<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

if ($_SESSION['CATLOG_SECTION']) {
    $homeCatalog = $_SESSION['CATLOG_SECTION'];
} else {
    $homeCatalog = GetHomeCtalogSection();
}
?>
<?$this->__template->SetViewTarget('top_menu');?>
<?
$APPLICATION->IncludeComponent(
    "bitrix:catalog.section.list",
    "menutop",
    Array(
        "VIEW_MODE" => "LINE",
        "SHOW_PARENT_NAME" => "Y",
        "IBLOCK_TYPE" => StockMan\Config::CATALOG_TYPE,
        "IBLOCK_ID" => StockMan\Config::CATALOG_ID,
        "SECTION_ID" =>  $homeCatalog, // GetIdSectionCatalog();
        "SECTION_CODE" => "",
        "SECTION_URL" => "",
        "COUNT_ELEMENTS" => "Y",
        "TOP_DEPTH" => "4",
        "SECTION_FIELDS" => "",
        "SECTION_USER_FIELDS" => "",
        "ADD_SECTIONS_CHAIN" => "N",
        "CACHE_TYPE" => "N",
        "CACHE_TIME" => "3600",
        "CACHE_NOTES" => "",
        "CACHE_GROUPS" => "N",
        "CURREN_SECTION_ID" => $homeCatalog
    )
);?>
<?
$this->__template->EndViewTarget();?>
<?/*------------*/?>