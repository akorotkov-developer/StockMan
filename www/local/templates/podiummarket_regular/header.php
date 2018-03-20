<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
IncludeTemplateLangFile(__FILE__);

require($_SERVER['DOCUMENT_ROOT'] . StockMan\Config::STOCKMAN_TEMPLATE_PATH . '/header.php');
?>
<div class="content <?if (strpos($APPLICATION->GetCurPage(), '/faq/') !== false) {?> padding-top-5<?}?>">
    <?$APPLICATION->IncludeComponent("bitrix:breadcrumb","",
        Array(
            "START_FROM" => "0",
            "PATH" => "",
            "SITE_ID" => StockMan\Config::SITE_ID
        )
    );?>
    <?if (strpos( $APPLICATION->GetCurPage(), 'cart') != 1) {?>
        <div class="grid-container">
            <div class="grid-x grid-padding-x">
                <div class="cell">
                    <h1><?$APPLICATION->ShowTitle(false);?></h1>
                </div>
            </div>
        </div>
    <?}?>
    <div class="grid-container">
        <div class="grid-x grid-padding-x">
            <?
            $curDir = $APPLICATION->GetCurDir();
            $menu = new CMenu('leftregular');
            if($menu->Init($curDir)) {
                $divclasses = "cell small-12 medium-7 large-9";
            } else {
                $divclasses = "cell small-12 medium-12 large-12";
                $divhide = "style = 'display: none'";
            }
            ?>
            <div class="cell small-12 medium-5 large-3" <?=$divhide?>>
                <div class="margin-bottom-6 show-for-small-only" data-responsive-toggle="menu-left" data-hide-for="medium"><span class="button expanded" data-toggle><i class="fa fa-lg fa-bars"></i>&nbsp;Навигация</span></div>
                <div class="callout" id="menu-left">
                    <?$APPLICATION->IncludeComponent("bitrix:menu","leftmenu",Array(
                            "ROOT_MENU_TYPE" => "leftregular",
                            "MAX_LEVEL" => "1",
                            "CHILD_MENU_TYPE" => "leftregular",
                            "USE_EXT" => "Y",
                            "DELAY" => "N",
                            "ALLOW_MULTI_SELECT" => "Y",
                            "MENU_CACHE_TYPE" => "N",
                            "MENU_CACHE_TIME" => "3600",
                            "MENU_CACHE_USE_GROUPS" => "Y",
                            "MENU_CACHE_GET_VARS" => ""
                        )
                    );?>
                </div>
            </div>
            <div class="<?=$divclasses?>">
<?/*if ($APPLICATION->GetCurPage() != "/") {?>
<div class="content">
    <div class="grid-container">
        <div class="grid-x grid-padding-x">
            <div class="cell text-center">
                <h1><?$APPLICATION->ShowTitle(false)?></h1>
<?}*/?>