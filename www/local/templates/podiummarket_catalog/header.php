<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
IncludeTemplateLangFile(__FILE__);

require($_SERVER['DOCUMENT_ROOT'] . StockMan\Config::STOCKMAN_TEMPLATE_PATH . '/header.php');
?>

<div class="content <?$APPLICATION->ShowViewContent('catalog_element');?> padding-top-5">
<?$APPLICATION->IncludeComponent("bitrix:breadcrumb","",
    Array(
        "START_FROM" => "0",
        "PATH" => "",
        "SITE_ID" => StockMan\Config::SITE_ID
    )
);?>