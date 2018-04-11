<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);

$APPLICATION->IncludeComponent(
    "bitrix:highloadblock.list",
    "topmenu",
    Array(
        "AR_FILTER" => $arResult["ITEMS"],
        "COMPONENT_TEMPLATE" => ".default",
        "BLOCK_ID" => StockMan\Config::HB_ID_BRANDS,
        "DETAIL_URL" => "/brends/#ID#/",
        "ROWS_PER_PAGE" =>2000,
        "CACHE_TYPE" => "A",
        "CACHE_TIME" => "3600",
        "NAV_TEMPLATE" => "round",
        "sort_id" => "UF_SORT",
        "sort_type" => "ASC",
    ),
    false,
    array("HIDE_ICONS" => "Y")
);
?>