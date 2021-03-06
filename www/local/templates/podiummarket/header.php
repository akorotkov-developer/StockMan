<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
IncludeTemplateLangFile(__FILE__);
CJSCore::Init(array("fx"));
use Bitrix\Main\Page\Asset;
use Bitrix\Main\Page\AssetLocation;
use Bitrix\Main\Loader;
Loader::includeModule("sale");
?>
    <!DOCTYPE html>
<html class="no-js" lang="<?=LANGUAGE_ID?>">
    <head>
        <?$APPLICATION->ShowHead();?>
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="copyright" content="Создание сайтов - Cetera Labs, www.cetera.ru, 2016">
        <meta name="author" content="Cetera Labs, http://www.cetera.ru/, создание сайтов, поддержка сайтов, продвижение сайтов">
        <meta name="cmsmagazine" content="f21b68cb09efe1a7161ca2caaacaf749">
        <meta property="og:image" content="<?$APPLICATION->ShowViewContent('socnetimage');?>"/>
        <?
        Asset::getInstance()->addString('<style type="text/css">' . Asset::fixCssIncludes(file_get_contents(
                $_SERVER['DOCUMENT_ROOT'] . StockMan\Config::STOCKMAN_TEMPLATE_PATH . '/css/style.css'), StockMan\Config::STOCKMAN_TEMPLATE_PATH . '/css/style.css'
            ) . '</style>', true, AssetLocation::BEFORE_CSS);
        Asset::getInstance()->addJs(StockMan\Config::STOCKMAN_TEMPLATE_PATH . "/js/lib.js");
        Asset::getInstance()->addJs(StockMan\Config::STOCKMAN_TEMPLATE_PATH . "/js/script.js");
        Asset::getInstance()->addJs(StockMan\Config::STOCKMAN_TEMPLATE_PATH . "/js/device.js");
        ?>
        <?
        $APPLICATION->SetAdditionalCss(StockMan\Config::STOCKMAN_TEMPLATE_PATH . "/template_styles.css");
        ?>
        <link rel="shortcut icon" href="/favicon.png"/>
        <title><?$APPLICATION->ShowTitle()?></title>
    </head>
<body>
<?
if (($APPLICATION->GetCurPage() == '/')and(!isset($_REQUEST["q"]))) {
    $CATALOG_SECTION = intval($APPLICATION->get_cookie('CATALOG_SECTION_PM'));
    /*if (intval($CATALOG_SECTION) == 0) {
        $CATALOG_SECTION = GetHomeCtalogSection();
        $APPLICATION->set_cookie('CATALOG_SECTION_PM', $CATALOG_SECTION, time() + 60 * 60 * 24 * 3, "/", $_SERVER['SERVER_NAME']);
    }*/

    if (intval($CATALOG_SECTION) > 0) {
        $SECTION_PAGE_URL = '';
        $arFilter = array(
            'IBLOCK_ID' => StockMan\Config::CATALOG_ID,
            "ID" => intval($CATALOG_SECTION)
        );
        $rsSections = CIBlockSection::GetList(array('ID' => 'ASC'), $arFilter, false, array("ID","SECTION_PAGE_URL"), array("nTopCount" => 1));
        while ($arSection = $rsSections->GetNext()) {
            $SECTION_PAGE_URL = $arSection["SECTION_PAGE_URL"];
        }

        if ($SECTION_PAGE_URL != '') {
            LocalRedirect($SECTION_PAGE_URL);
        }
    }
}
?>
<?$APPLICATION->ShowPanel();?>
    <div data-sticky-container>
        <header class="header sticky" data-sticky data-margin-top="0" data-sticky-on="large">
            <?$APPLICATION->ShowViewContent('catalog_section_header_filter');?>
            <div class="grid-x grid-padding-x">
                <div class="cell text-center background-insta header__hat"><a class="header__tel" href="tel:88005554905">8 (800) 555-49-05 (бесплатный, многоканальный)</a></div>
                <?$APPLICATION->IncludeComponent(
                    "bitrix:menu",
                    "header__gender",
                    Array(
                        "ALLOW_MULTI_SELECT" => "Y",
                        "DELAY" => "N",
                        "MAX_LEVEL" => "1",
                        "MENU_CACHE_GET_VARS" => "",
                        "MENU_CACHE_TIME" => "3600",
                        "MENU_CACHE_TYPE" => "A",
                        "MENU_CACHE_USE_GROUPS" => "Y",
                        "ROOT_MENU_TYPE" => "catalog-level1",
                        "USE_EXT" => "N"
                    )
                );?>
                <?$APPLICATION->IncludeComponent(
                    "bitrix:menu",
                    "header__people",
                    Array(
                        "ALLOW_MULTI_SELECT" => "Y",
                        "DELAY" => "N",
                        "MAX_LEVEL" => "1",
                        "MENU_CACHE_GET_VARS" => "",
                        "MENU_CACHE_TIME" => "3600",
                        "MENU_CACHE_TYPE" => "A",
                        "MENU_CACHE_USE_GROUPS" => "Y",
                        "ROOT_MENU_TYPE" => "catalog-level1",
                        "USE_EXT" => "N"
                    )
                );?>
                <div class="cell show-for-small-only small-2">
                    <button class="menu-icon header__menu dark" type="button" data-toggle="responsive-menu"></button>
                </div>
                <?$APPLICATION->IncludeComponent(
                    "bitrix:search.form",
                    "header__detective",
                    Array(
                        "USE_SUGGEST" => "N",
                        "PAGE" => "/"
                    )
                );?>
                <div class="cell text-center large-4 medium-4 small-4"><a class="header__logo" href="/"><img src="<?=StockMan\Config::STOCKMAN_TEMPLATE_PATH?>/images/logo.svg" alt=""></a></div>
                <div class="cell large-4 header__book medium-4 small-4">
                    <?$APPLICATION->IncludeComponent(
                        "bitrix:sale.basket.basket.line",
                        "baskline",
                        Array(
                            "HIDE_ON_BASKET_PAGES" => "Y",
                            "PATH_TO_AUTHORIZE" => "",
                            "PATH_TO_BASKET" => SITE_DIR."personal/cart/",
                            "PATH_TO_ORDER" => SITE_DIR."personal/order/",
                            "PATH_TO_PERSONAL" => SITE_DIR."personal/",
                            "PATH_TO_PROFILE" => SITE_DIR."personal/",
                            "PATH_TO_REGISTER" => SITE_DIR."login/",
                            "POSITION_FIXED" => "N",
                            "SHOW_AUTHOR" => "N",
                            "SHOW_EMPTY_VALUES" => "Y",
                            "SHOW_NUM_PRODUCTS" => "Y",
                            "SHOW_PERSONAL_LINK" => "N",
                            "SHOW_PRODUCTS" => "N",
                            "SHOW_TOTAL_PRICE" => "N"
                        )
                    );?>
                    <a class="header__enter" href="/personal/cart/?delayed=Y"><img src="<?=StockMan\Config::STOCKMAN_TEMPLATE_PATH?>/images/heart.svg" alt=""><span id="wishcount"><?=GetCountDeferred();?></span></a>

                    <?if($USER->IsAuthorized()){?>
                        <a class="header__enter hide-for-small-only" href="/personal/private/">Личный кабинет</a>
                    <?}?>

                    <?if($USER->IsAuthorized()){?>
                        <a class="header__enter hide-for-small-only" href="<?echo $APPLICATION->GetCurPageParam("logout=yes", array(
                            "login",
                            "logout",
                            "register",
                            "forgot_password",
                            "change_password"));?>">Выйти</a>
                    <?} else {?>
                        <a class="header__enter hide-for-small-only" data-open="enter-popup">Войти</a>
                    <?}?>
                </div>
            </div>
        </header>
    </div>

<?/*$APPLICATION->IncludeComponent(
    "bitrix:menu",
    "topmenu",
    Array(
        "ALLOW_MULTI_SELECT" => "Y",
        "DELAY" => "N",
        "MAX_LEVEL" => "1",
        "MENU_CACHE_GET_VARS" => "",
        "MENU_CACHE_TIME" => "3600",
        "MENU_CACHE_TYPE" => "N",
        "MENU_CACHE_USE_GROUPS" => "Y",
        "ROOT_MENU_TYPE" => "basemenu",
        "USE_EXT" => "Y"
    )
);*/?>



<?$menu = $APPLICATION->ShowViewContent('top_menu');?>



<?
if (strpos($APPLICATION->GetCurPage(), "personal/order/make") > 0) {
    ?>
    <div class="content">
<?}?>