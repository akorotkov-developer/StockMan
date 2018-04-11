<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Бренды");
?>
<?$APPLICATION->IncludeComponent(
    "bitrix:highloadblock.list",
    "",
    Array(
        "COMPONENT_TEMPLATE" => ".default",
        "BLOCK_ID" => StockMan\Config::HB_ID_BRANDS,
        "DETAIL_URL" => "#ID#/",
        "ROWS_PER_PAGE" =>1000,
        "CACHE_TYPE" => "A",
        "CACHE_TIME" => "3600",
        "NAV_TEMPLATE" => "round",
        "sort_id" => "UF_NAME",
        "sort_type" => "ASC",
    ),
    false,
    array("HIDE_ICONS" => "Y")
);?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>