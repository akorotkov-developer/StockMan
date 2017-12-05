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
            <div class="cell large-4 header__book medium-4 small-4"><a class="header__enter header__enter_right text-center" href="#">2</a><a class="header__enter" href="#"><img src="<?=StockMan\Config::STOCKMAN_TEMPLATE_PATH?>/images/heart.svg" alt=""></a><a class="header__enter hide-for-small-only" data-open="enter-popup">Войти</a></div>
        </div>
    </header>
</div>
<div class="grid-container position-relative">
    <div class="grid-x directory" id="responsive-menu" data-toggler="js-open">
        <div class="subheader" data-toggler="js-open" id="subheader1">
            <button class="subheader__back" data-toggle="subheader1"><i class="fa fa-chevron-left"></i>Назад</button>
            <ul class="trousers">
                <li class="trousers__item"><a class="trousers__link" href="#">Вся одежда</a></li>
                <li class="trousers__item"><a class="trousers__link" href="#">Водолазки</a></li>
                <li class="trousers__item"><a class="trousers__link" href="#">Водолазки</a></li>
                <li class="trousers__item"><a class="trousers__link" href="#">Водолазки</a></li>
                <li class="trousers__item"><a class="trousers__link" href="#">Водолазки</a></li>
                <li class="trousers__item"><a class="trousers__link" href="#">Водолазки</a></li>
                <li class="trousers__item"><a class="trousers__link" href="#">Водолазки</a></li>
                <li class="trousers__item"><a class="trousers__link" href="#">Джинсы</a></li>
            </ul>
        </div>
        <div class="subheader" data-toggler="js-open" id="subheader2">
            <button class="subheader__back" data-toggle="subheader2"><i class="fa fa-chevron-left"></i>Назад</button>
            <ul class="trousers">
                <li class="trousers__item"><a class="trousers__link" href="#">Вся одежда</a></li>
                <li class="trousers__item"><a class="trousers__link" href="#">Шорты</a></li>
                <li class="trousers__item"><a class="trousers__link" href="#">Шорты</a></li>
                <li class="trousers__item"><a class="trousers__link" href="#">Шорты</a></li>
                <li class="trousers__item"><a class="trousers__link" href="#">Шорты</a></li>
                <li class="trousers__item"><a class="trousers__link" href="#">Шорты</a></li>
                <li class="trousers__item"><a class="trousers__link" href="#">Шорты</a></li>
                <li class="trousers__item"><a class="trousers__link" href="#">Джинсы</a></li>
            </ul>
        </div>
        <button class="close-button show-for-small-only" aria-label="Close alert" type="button"><span aria-hidden="true" data-toggle="responsive-menu">×</span></button>
        <div class="cell text-center medium-text-left">
            <ul class="people show-for-small-only">
                <li class="people__item"><a class="people__link" href="#">Женщинам</a></li>
                <li class="people__item"><a class="people__link people__link_active" href="#">Мужчинам</a></li>
                <li class="people__item"><a class="people__link" href="#">Детям</a></li>
            </ul>
        </div>
        <div class="small-12 medium-9 large-9 cell" id="menu">
            <ul class="menu-base text-left medium-text-right">
                <li class="menu-base__item"><a class="menu-base__link" href="shop-catalog.html"><img class="show-for-small-only" src="<?=StockMan\Config::STOCKMAN_TEMPLATE_PATH?>/images/new.svg" alt="">Новинки</a></li>
                <li class="menu-base__item"><a class="menu-base__link" href="shop-catalog.html"> <img class="show-for-small-only" src="<?=StockMan\Config::STOCKMAN_TEMPLATE_PATH?>/images/brands.svg" alt="">Бренды</a></li>
                <li class="menu-base__item"><a class="menu-base__link" data-toggle-hover-dd="menu_item_2" data-toggle="subheader1"><img class="show-for-small-only" src="<?=StockMan\Config::STOCKMAN_TEMPLATE_PATH?>/images/clothes.svg" alt="">Одежда<i class="fa fa-chevron-right show-for-small-only"></i></a></li>
                <li class="menu-base__item"><a class="menu-base__link" data-toggle-hover-dd="menu_item_2" data-toggle="subheader2"><img class="show-for-small-only" src="<?=StockMan\Config::STOCKMAN_TEMPLATE_PATH?>/images/shoes.svg" alt="">Обувь<i class="fa fa-chevron-right show-for-small-only"></i></a></li>
                <li class="menu-base__item"><a class="menu-base__link" href="shop-catalog.html"><img class="show-for-small-only" src="<?=StockMan\Config::STOCKMAN_TEMPLATE_PATH?>/images/bags.svg" alt="">Сумки</a></li>
                <li class="menu-base__item"><a class="menu-base__link" href="shop-catalog.html"><img class="show-for-small-only" src="<?=StockMan\Config::STOCKMAN_TEMPLATE_PATH?>/images/accessories.svg" alt="">Аксессуары</a></li>
                <li class="menu-base__item"><a class="menu-base__link" href="shop-catalog.html"><img class="show-for-small-only" src="<?=StockMan\Config::STOCKMAN_TEMPLATE_PATH?>/images/underwear.svg" alt="">Белье</a></li>
                <li class="menu-base__item"><a class="menu-base__link" href="shop-catalog.html"><img class="show-for-small-only" src="<?=StockMan\Config::STOCKMAN_TEMPLATE_PATH?>/images/sale.svg" alt="">Sale</a></li>
                <li class="menu-base__item"><a class="menu-base__link" href="shop-catalog.html"><img class="show-for-small-only" src="<?=StockMan\Config::STOCKMAN_TEMPLATE_PATH?>/images/blog.svg" alt="">Блог</a></li>
            </ul>
        </div>
        <div class="hide-for-small-only large-3 cell medium-3 text-center medium-text-left">
            <form class="search-top input-group" action="shop-search.html" method="get">
                <input class="search-top__input input-group-field" type="text" value="" placeholder="Поиск">
                <div class="input-group-button">
                    <button class="search-top__button fa fa-search" type="submit"></button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="dd hide-for-small-only" id="menu_item_2" data-toggler-hover-dd="dd_show">
    <div class="dd__content">
        <div class="grid-container">
            <div class="grid-x grid-padding-x">
                <div class="small-6 medium-5 large-6 cell">
                    <h5>По категориям</h5>
                    <div class="grid-x grid-padding-x">
                        <div class="small-6 cell">
                            <ul>
                                <li><a href="#" title="">Платья</a></li>
                                <li><a href="#" title="">Брюки</a></li>
                                <li><a href="#" title="">Кофты</a></li>
                                <li><a href="#" title="">Юбки</a></li>
                                <li><a href="#" title="">Костюмы</a></li>
                                <li><a href="#" title="">Деним</a></li>
                            </ul>
                        </div>
                        <div class="small-6 cell">
                            <ul>
                                <li><a href="#" title="">Шорты</a></li>
                                <li><a href="#" title="">Нижнее белье</a></li>
                                <li><a href="#" title="">Пальто</a></li>
                                <li><a href="#" title="">Трикотаж</a></li>
                                <li><a href="#" title="">Комбинезоны</a></li>
                                <li><a href="#" title="">Пляжная одежда</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="small-6 medium-4 large-3 cell">
                    <h5>По дизайнерам</h5>
                    <ul>
                        <li><a href="#" title="">BURBERRY</a></li>
                        <li><a href="#" title="">CHLOE</a></li>
                        <li><a href="#" title="">DOLCE &amp; GABBANA</a></li>
                        <li><a href="#" title="">DSQUARED2</a></li>
                        <li><a href="#" title="">ETRO</a></li>
                        <li><a href="#" title="">GIVENCHY</a></li>
                        <li><a href="#" title="">ISABEL MARANT</a></li>
                        <li><a href="#" title="">LANVIN</a></li>
                        <li><a href="#" title="">MARC JACOBS</a></li>
                        <li><a href="#" title="">MAX MARA</a></li>
                    </ul><a class="font-bold text-decoration-none" href="#">Все дизайнеры</a>
                </div>
                <div class="small-6 medium-3 large-3 cell text-center">
                    <div class="margin-bottom-9"><a href="#"><img src="<?=StockMan\Config::STOCKMAN_TEMPLATE_PATH?>/i/dress.png" alt=""></a></div>
                    <h3 class="margin-bottom-0">Платья</h3><a class="anchor" href="#">смотреть все    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="content">
    <div class="grid-container">
        <div class="grid-x grid-padding-x">
            <div class="cell text-center">
                <h1>Страница не найдена</h1>