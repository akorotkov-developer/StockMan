<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Интернет-магазин \"Одежда\"");
?>

    <?$APPLICATION->IncludeComponent(
        "bitrix:news.list",
        "slider",
        Array(
            "ACTIVE_DATE_FORMAT" => "d.m.Y",
            "ADD_SECTIONS_CHAIN" => "N",
            "AJAX_MODE" => "N",
            "AJAX_OPTION_ADDITIONAL" => "",
            "AJAX_OPTION_HISTORY" => "N",
            "AJAX_OPTION_JUMP" => "N",
            "AJAX_OPTION_STYLE" => "Y",
            "CACHE_FILTER" => "Y",
            "CACHE_GROUPS" => "Y",
            "CACHE_TIME" => "3600",
            "CACHE_TYPE" => "A",
            "CHECK_DATES" => "Y",
            "DETAIL_URL" => "",
            "DISPLAY_BOTTOM_PAGER" => "N",
            "DISPLAY_DATE" => "Y",
            "DISPLAY_NAME" => "Y",
            "DISPLAY_PICTURE" => "Y",
            "DISPLAY_PREVIEW_TEXT" => "Y",
            "DISPLAY_TOP_PAGER" => "N",
            "FIELD_CODE" => array(
                0 => "DETAIL_PICTURE",
                1 => ""
            ),
            "FILTER_NAME" => "",
            "HIDE_LINK_WHEN_NO_DETAIL" => "N",
            "IBLOCK_TYPE" => StockMan\Config::SLIDER_TYPE,
            "IBLOCK_ID" => StockMan\Config::SLIDER_ID,
            "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
            "INCLUDE_SUBSECTIONS" => "Y",
            "MESSAGE_404" => "",
            "NEWS_COUNT" => 10,
            "PAGER_BASE_LINK_ENABLE" => "N",
            "PAGER_DESC_NUMBERING" => "N",
            "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
            "PAGER_SHOW_ALL" => "N",
            "PAGER_SHOW_ALWAYS" => "N",
            "PAGER_TEMPLATE" => ".default",
            "PAGER_TITLE" => "Новости",
            "PARENT_SECTION" => "",
            "PARENT_SECTION_CODE" => "",
            "PREVIEW_TRUNCATE_LEN" => "",
            "PROPERTY_CODE" => array("URL","MOBILE_PICTURE"),
            "SET_BROWSER_TITLE" => "N",
            "SET_LAST_MODIFIED" => "N",
            "SET_META_DESCRIPTION" => "N",
            "SET_META_KEYWORDS" => "N",
            "SET_STATUS_404" => "N",
            "SET_TITLE" => "N",
            "SHOW_404" => "N",
            "SORT_BY1" => "ACTIVE_FROM",
            "SORT_BY2" => "SORT",
            "SORT_ORDER1" => "DESC",
            "SORT_ORDER2" => "ASC",
            "STRICT_SECTION_CHECK" => "N"
        )
    );?>

    <div class="grid-container margin-bottom-17">
        <div class="grid-x grid-padding-x text-center">
            <?$APPLICATION->IncludeComponent("bitrix:advertising.banner","bannerdress",Array(
                    "TYPE" => "BANNER_MAIN_PAGE_DRESS",
                    "CACHE_TYPE" => "A",
                    "NOINDEX" => "Y",
                    "CACHE_TIME" => "3600"
                )
            );?>

            <?$APPLICATION->IncludeComponent("bitrix:advertising.banner","bannerbag",Array(
                    "TYPE" => "BANNER_MAIN_PAGE_BAGS",
                    "CACHE_TYPE" => "A",
                    "NOINDEX" => "Y",
                    "CACHE_TIME" => "3600"
                )
            );?>

            <?$APPLICATION->IncludeComponent("bitrix:advertising.banner","bannerprices",Array(
                    "TYPE" => "BANNER_MAIN_PAGE_OURPRICES",
                    "CACHE_TYPE" => "A",
                    "NOINDEX" => "Y",
                    "CACHE_TIME" => "3600"
                )
            );?>

            <?$APPLICATION->IncludeComponent("bitrix:advertising.banner","bannerprint",Array(
                    "TYPE" => "BANNER_MAIN_PAGE_PRINT",
                    "CACHE_TYPE" => "A",
                    "NOINDEX" => "Y",
                    "CACHE_TIME" => "3600"
                )
            );?>

            <?$APPLICATION->IncludeComponent("bitrix:advertising.banner","bannercollectionjacket",Array(
                    "TYPE" => "BANNER_MAIN_PAGE_COLLECTION_JACKET",
                    "CACHE_TYPE" => "A",
                    "NOINDEX" => "Y",
                    "CACHE_TIME" => "3600"
                )
            );?>

        </div>
    </div>
    <div class="grid-x grid-padding-x text-center">
        <div class="cell margin-bottom-20">
            <div class="cat text-center">
                <h2 class="cat__head">Новинки каталога   </h2>
            </div>
        </div>
    </div>
    <?/*Новинки*/?>
    <?
    $arFilter = array(
        "PROPERTY_".StockMan\Config::NEW_PRODUCT."_VALUE"  => "да", // это для свойства типа список
        "!SECTION_ID" => array(
            ImportStokMan::$IBLOCK_SECTION_ERROR_ID,
            ImportStokMan::$IBLOCK_SECTION_ID,
        )
    );
    ?>
    <?$APPLICATION->IncludeComponent(
        "bitrix:catalog.section",
        "newproducts",
        array(
            "ACTION_VARIABLE" => "action",
            "ADD_PICT_PROP" => "-",
            "ADD_PROPERTIES_TO_BASKET" => "Y",
            "ADD_SECTIONS_CHAIN" => "N",
            "ADD_TO_BASKET_ACTION" => "ADD",
            "AJAX_MODE" => "N",
            "AJAX_OPTION_ADDITIONAL" => "",
            "AJAX_OPTION_HISTORY" => "N",
            "AJAX_OPTION_JUMP" => "N",
            "AJAX_OPTION_STYLE" => "Y",
            "BACKGROUND_IMAGE" => "-",
            "BASKET_URL" => "/personal/basket.php",
            "BROWSER_TITLE" => "-",
            "CACHE_FILTER" => "N",
            "CACHE_GROUPS" => "Y",
            "CACHE_TIME" => "36000000",
            "CACHE_TYPE" => "A",
            "COMPATIBLE_MODE" => "Y",
            "CONVERT_CURRENCY" => "N",
            "CUSTOM_FILTER" => "",
            "DETAIL_URL" => "",
            "DISABLE_INIT_JS_IN_COMPONENT" => "N",
            "DISPLAY_BOTTOM_PAGER" => "Y",
            "DISPLAY_COMPARE" => "N",
            "DISPLAY_TOP_PAGER" => "N",
            "ELEMENT_SORT_FIELD" => "sort",
            "ELEMENT_SORT_FIELD2" => "id",
            "ELEMENT_SORT_ORDER" => "asc",
            "ELEMENT_SORT_ORDER2" => "desc",
            "ENLARGE_PRODUCT" => "STRICT",
            "FILTER_NAME" => "arFilter",
            "HIDE_NOT_AVAILABLE" => "N",
            "HIDE_NOT_AVAILABLE_OFFERS" => "N",
            "IBLOCK_ID" => StockMan\Config::CATALOG_ID,
            "IBLOCK_TYPE" => StockMan\Config::CATALOG_TYPE,
            "INCLUDE_SUBSECTIONS" => "Y",
            "LABEL_PROP" => array(
            ),
            "LAZY_LOAD" => "N",
            "LINE_ELEMENT_COUNT" => "3",
            "LOAD_ON_SCROLL" => "N",
            "MESSAGE_404" => "",
            "MESS_BTN_ADD_TO_BASKET" => "В корзину",
            "MESS_BTN_BUY" => "Купить",
            "MESS_BTN_DETAIL" => "Подробнее",
            "MESS_BTN_SUBSCRIBE" => "Подписаться",
            "MESS_NOT_AVAILABLE" => "Нет в наличии",
            "META_DESCRIPTION" => "-",
            "META_KEYWORDS" => "-",
            "OFFERS_CART_PROPERTIES" => array(
            ),
            "OFFERS_FIELD_CODE" => array(
                0 => "",
                1 => "",
            ),
            "OFFERS_LIMIT" => "5",
            "OFFERS_PROPERTY_CODE" => array(
                0 => "",
                1 => "",
            ),
            "OFFERS_SORT_FIELD" => "sort",
            "OFFERS_SORT_FIELD2" => "id",
            "OFFERS_SORT_ORDER" => "asc",
            "OFFERS_SORT_ORDER2" => "desc",
            "PAGER_BASE_LINK_ENABLE" => "N",
            "PAGER_DESC_NUMBERING" => "N",
            "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
            "PAGER_SHOW_ALL" => "N",
            "PAGER_SHOW_ALWAYS" => "N",
            "PAGER_TEMPLATE" => ".default",
            "PAGER_TITLE" => "Товары",
            "PAGE_ELEMENT_COUNT" => "18",
            "PARTIAL_PRODUCT_PROPERTIES" => "N",
            "PRICE_CODE" => array(
                0 => StockMan\Config::CATALOG_PRICE,
            ),
            "PRICE_VAT_INCLUDE" => "Y",
            "PRODUCT_BLOCKS_ORDER" => "price,props,sku,quantityLimit,quantity,buttons,compare",
            "PRODUCT_DISPLAY_MODE" => "N",
            "PRODUCT_ID_VARIABLE" => "id",
            "PRODUCT_PROPERTIES" => array(
            ),
            "PRODUCT_PROPS_VARIABLE" => "prop",
            "PRODUCT_QUANTITY_VARIABLE" => "quantity",
            "PRODUCT_ROW_VARIANTS" => "[{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false}]",
            "PRODUCT_SUBSCRIPTION" => "Y",
            "PROPERTY_CODE" => array(
                0 => StockMan\Config::BREND,
                1 => "",
            ),
            "PROPERTY_CODE_MOBILE" => array(
            ),
            "RCM_PROD_ID" => $_REQUEST["PRODUCT_ID"],
            "RCM_TYPE" => "personal",
            "SECTION_CODE" => "",
            "SECTION_ID" => $_REQUEST["SECTION_ID"],
            "SECTION_ID_VARIABLE" => "SECTION_ID",
            "SECTION_URL" => "",
            "SECTION_USER_FIELDS" => array(
                0 => "",
                1 => "",
            ),
            "SEF_MODE" => "N",
            "SET_BROWSER_TITLE" => "Y",
            "SET_LAST_MODIFIED" => "N",
            "SET_META_DESCRIPTION" => "Y",
            "SET_META_KEYWORDS" => "Y",
            "SET_STATUS_404" => "N",
            "SET_TITLE" => "Y",
            "SHOW_404" => "N",
            "SHOW_ALL_WO_SECTION" => "Y",
            "SHOW_CLOSE_POPUP" => "N",
            "SHOW_DISCOUNT_PERCENT" => "N",
            "SHOW_FROM_SECTION" => "N",
            "SHOW_MAX_QUANTITY" => "N",
            "SHOW_OLD_PRICE" => "N",
            "SHOW_PRICE_COUNT" => "1",
            "SHOW_SLIDER" => "Y",
            "TEMPLATE_THEME" => "blue",
            "USE_ENHANCED_ECOMMERCE" => "N",
            "USE_MAIN_ELEMENT_SECTION" => "N",
            "USE_PRICE_COUNT" => "N",
            "USE_PRODUCT_QUANTITY" => "N",
            "COMPONENT_TEMPLATE" => "newproducts",
            "SLIDER_INTERVAL" => "3000",
            "SLIDER_PROGRESS" => "N"
        ),
        false
    );?>
    <div class="podium text-center"># PODIUMMARKET</div>
    <div class="girl text-center">
        <div class="girl__slide"><a href="#"><img src="<?=StockMan\Config::STOCKMAN_TEMPLATE_PATH?>/i/g1.png" alt=""></a></div>
        <div class="girl__slide"><a href="#"><img src="<?=StockMan\Config::STOCKMAN_TEMPLATE_PATH?>/i/g2.png" alt=""></a></div>
        <div class="girl__slide"><a href="#"><img src="<?=StockMan\Config::STOCKMAN_TEMPLATE_PATH?>/i/g3.png" alt=""></a></div>
        <div class="girl__slide"><a href="#"><img src="<?=StockMan\Config::STOCKMAN_TEMPLATE_PATH?>/i/g4.png" alt=""></a></div>
        <div class="girl__slide"><a href="#"><img src="<?=StockMan\Config::STOCKMAN_TEMPLATE_PATH?>/i/g5.png" alt=""></a></div>
        <div class="girl__slide"><a href="#"><img src="<?=StockMan\Config::STOCKMAN_TEMPLATE_PATH?>/i/g6.png" alt=""></a></div>
        <div class="girl__slide"><a href="#"><img src="<?=StockMan\Config::STOCKMAN_TEMPLATE_PATH?>/i/g7.png" alt=""></a></div>
        <div class="girl__slide"><a href="#"><img src="<?=StockMan\Config::STOCKMAN_TEMPLATE_PATH?>/i/g1.png" alt=""></a></div>
    </div>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>