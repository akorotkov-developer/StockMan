<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
IncludeTemplateLangFile(__FILE__);

require($_SERVER['DOCUMENT_ROOT'] . StockMan\Config::STOCKMAN_TEMPLATE_PATH . '/header.php');
?>
<?
$isSearch = false;
if (isset($_REQUEST['q'])) {
    $isSearch = true;
}
$arPage = array();
$isMain = false;
if ($APPLICATION->GetCurPage() == "/") {
    $isMain = true;
} else {
    $arPageStr = explode('/',$APPLICATION->GetCurPage());
    $arPage = array();
    foreach ($arPageStr as $p) {
        if (isset($p{1})) {
            $arPage[] = $p;
        }
    }
}

?>
<?
    if (($isSearch)and($isMain)) {
       ?><div class="content content_medium"><?
    } else {
        ?>
        <div class="content <?$APPLICATION->ShowViewContent('catalog_element');?> padding-top-<?if (count($arPage) == 1) {?>0<?} else {?>5<?}?> <?if (($isMain)or(count($arPage) == 1)) {?>padding-bottom-0<?}?>"><?

    }
?>
<?
if (((!$isMain)or($isSearch))and(count($arPage)>1)) {
    if ($isSearch) {?><div class="grid-container"><?}
    $APPLICATION->IncludeComponent("bitrix:breadcrumb", "",
        Array(
            "START_FROM" => "0",
            "PATH" => "",
            "SITE_ID" => StockMan\Config::SITE_ID
        )
    );
    if ($isSearch) {?></div><?}
}?>