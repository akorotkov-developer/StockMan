<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
IncludeTemplateLangFile(__FILE__);
CJSCore::Init(array("fx"));
use Bitrix\Main\Page\Asset;
use Bitrix\Main\Page\AssetLocation;
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
        <?
        Asset::getInstance()->addString('<style type="text/css">' . Asset::fixCssIncludes(file_get_contents(
                $_SERVER['DOCUMENT_ROOT'] . StockMan\Config::STOCKMAN_TEMPLATE_PATH . '/css/style.css'), StockMan\Config::STOCKMAN_TEMPLATE_PATH . '/css/style.css'
            ) . '</style>', true, AssetLocation::BEFORE_CSS);
        Asset::getInstance()->addJs(StockMan\Config::STOCKMAN_TEMPLATE_PATH . "/js/lib.js");
        ?>
        <?
        $APPLICATION->SetAdditionalCss(StockMan\Config::STOCKMAN_TEMPLATE_PATH . "/template_styles.css");
        ?>
        <title><?$APPLICATION->ShowTitle()?></title>
    </head>
<body>
<?$APPLICATION->ShowPanel();?>
    <div data-sticky-container>
        <header class="header sticky" data-sticky data-margin-top="0" data-sticky-on="large">
            <div class="grid-x grid-padding-x">
                <div class="cell text-center background-insta header__hat"><a class="header__tel" href="tel:88003011129">8 (800) 301-11-29 (бесплатный, многоканальный)</a></div>
                <div class="cell large-4 medium-4 text-center medium-text-left header__gender">
                    <div class="sort">
                        <div class="sort__main">Женщинам</div>
                        <div class="sort__other">
                            <div class="sort__over">
                                <div> <a href="#">Женщинам</a></div>
                                <div> <a href="#">Мужчинам</a></div>
                                <div> <a href="#">Детям</a></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="cell large-4 medium-4 text-center medium-text-left hide-for-small-only header__people">
                    <ul class="people">
                        <li class="people__item"><a class="people__link" href="#">Женщинам</a></li>
                        <li class="people__item"><a class="people__link people__link_active" href="#">Мужчинам</a></li>
                        <li class="people__item"><a class="people__link" href="#">Детям</a></li>
                    </ul>
                </div>
                <div class="cell show-for-small-only small-2">
                    <button class="menu-icon header__menu dark" type="button" data-toggle="responsive-menu"></button>
                </div>
                <div class="cell show-for-small-only small-2 header__detective" data-responsive-toggle="search-menu" data-hide-for="medium"><img src="<?=StockMan\Config::STOCKMAN_TEMPLATE_PATH?>/images/search.svg" alt="" data-toggle="search-menu">
                    <div class="detective" id="search-menu">
                        <form class="search-top input-group" action="shop-search.html" method="get">
                            <input class="search-top__input input-group-field" type="text" value="" placeholder="Поиск">
                            <div class="input-group-button">
                                <button class="search-top__button fa fa-search" type="submit"></button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="cell text-center large-4 medium-4 small-4"><a class="header__logo" href="#"><img src="<?=StockMan\Config::STOCKMAN_TEMPLATE_PATH?>/images/logo.svg" alt=""></a></div>
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
                    <img src="<?=StockMan\Config::STOCKMAN_TEMPLATE_PATH?>/images/heart.svg" alt=""></a>

                    <?if($USER->IsAuthorized()){?>
                        <a class="header__enter hide-for-small-only" href="/personal/private/">Личный кабинет</a>
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

<?$APPLICATION->IncludeComponent(
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
);?>


<?
if (strpos($APPLICATION->GetCurPage(), "personal/order/make") > 0) {
?>
    <div class="content">
<?}?>