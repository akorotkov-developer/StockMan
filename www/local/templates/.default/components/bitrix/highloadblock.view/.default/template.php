<?

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if (!empty($arResult['ERROR']))
{
	ShowError($arResult['ERROR']);
	return false;
}
$name = htmlspecialcharsEx($arResult['fields']["UF_NAME"]["VALUE"]);
$APPLICATION->AddChainItem($name);
global $USER_FIELD_MANAGER;
$APPLICATION->SetTitle($name);
$count = intval(count($arResult["arIdProducts"]));

$url = str_replace(
    array('#ID#', '#BLOCK_ID#',"#UF_CODE#"),
    array($arResult["row"]["ID"], intval($arParams['BLOCK_ID']), $arResult["row"]["UF_CODE"]),
    $arParams['DETAIL_URL']
);
$url = htmlspecialcharsbx($url);
?>
    <div class="content content_medium-gray">
        <div class="grid-container">
            <div class="grid-x grid-padding-x">
                <div class="cell text-center">
                    <h1 class="margin-bottom-0"><?= $name ?></h1>

                    <div
                        class="text-secondary margin-bottom-1"><?= $count ?> <?= inclination($count, array('товар', 'товара', 'товаров')) ?></div>
                </div>
            </div>
            <div class="grid-x grid-padding-x">
                <div class="cell large-3 medium-3 text-center">
                    <?if ($arResult['fields']["UF_FILE"]["VALUE"]) {
                        ?><p><img src="<?= CFile::GetPath($arResult['fields']["UF_FILE"]["VALUE"]); ?>" alt=""></p><?
                    } ?>
                </div>
                <div class="cell large-9 medium-9">
                    <?if ($arResult['fields']["UF_FULL_DESCRIPTION"]["VALUE"]) {
                        echo $arResult['fields']["UF_FULL_DESCRIPTION"]["VALUE"];
                    } ?>
                </div>
            </div>
        </div>
    </div>
    <?
if (count($arResult["arIdProducts"])>0) {
    ?><div class="content"><?
    global $sFS;
    $sFS = array(
        "!SECTION_ID" => array(
            ImportStokMan::$IBLOCK_SECTION_ERROR_ID,
            ImportStokMan::$IBLOCK_SECTION_ID,
        ),
        array(
            "LOGIC" => "OR",
            array("!DETAIL_PICTURE" => false),
            array("!PROPERTY_MORE_PHOTO" => false),
        ),
        "ID" => $arResult["arIdProducts"]
    );
    $APPLICATION->IncludeComponent(
        "bitrix:catalog",
        'catalogpodiummarket-brands',
        array(
            "IBLOCK_TYPE" => StockMan\Config::CATALOG_TYPE,
            "IBLOCK_ID" => StockMan\Config::CATALOG_ID,
            "TEMPLATE_THEME" => "site",
            "DETAIL_SET_CANONICAL_URL" => "Y",
            "USE_MAIN_ELEMENT_SECTION" => "Y",
            "HIDE_NOT_AVAILABLE" => "Y",
            "BASKET_URL" => "/personal/cart/",
            "ACTION_VARIABLE" => "action",
            "PRODUCT_ID_VARIABLE" => "id",
            "SECTION_ID_VARIABLE" => "SECTION_ID",
            "PRODUCT_QUANTITY_VARIABLE" => "quantity",
            "PRODUCT_PROPS_VARIABLE" => "prop",
            "SEF_MODE" => "Y",
            "SEF_FOLDER" => $url,
            "AJAX_MODE" => "N",
            "AJAX_OPTION_JUMP" => "N",
            "AJAX_OPTION_STYLE" => "Y",
            "AJAX_OPTION_HISTORY" => "N",
            "SLIDER_PROGRESS" => "N",
            "CACHE_TYPE" => "A",
            "CACHE_TIME" => "3600",
            "CACHE_FILTER" => "N",
            "CACHE_GROUPS" => "Y",
            "SET_TITLE" => "Y",
            "ADD_SECTIONS_CHAIN" => "Y",
            "ADD_ELEMENT_CHAIN" => "Y",
            "SET_STATUS_404" => "Y",
            "DETAIL_DISPLAY_NAME" => "Y",
            "USE_ELEMENT_COUNTER" => "Y",
            "USE_FILTER" => "Y",
            "FILTER_NAME" => "sFS",
            "FILTER_VIEW_MODE" => "VERTICAL",
            "FILTER_FIELD_CODE" => array(
                0 => "",
                1 => "",
            ),
            "FILTER_PROPERTY_CODE" => array(
                ImportStokMan::$CODE_PROPERTYY_TSVET
            ),
            "FILTER_PRICE_CODE" => array(
                0 => StockMan\Config::CATALOG_PRICE,
            ),
            "FILTER_OFFERS_FIELD_CODE" => array(
                0 => "PREVIEW_PICTURE",
                1 => "DETAIL_PICTURE",
                2 => "",
            ),
            "FILTER_OFFERS_PROPERTY_CODE" => array(
                StockMan\Catalog\Config::RAZMER,
                StockMan\Catalog\Config::ROSSIYSKIY_RAZMER,
                StockMan\Catalog\Config::PROP_DISCOUNT,
            ),
            "USE_REVIEW" => "Y",
            "MESSAGES_PER_PAGE" => "10",
            "USE_CAPTCHA" => "Y",
            "REVIEW_AJAX_POST" => "Y",
            "PATH_TO_SMILE" => "/bitrix/images/forum/smile/",
            "FORUM_ID" => "11",
            "URL_TEMPLATES_READ" => "",
            "SHOW_LINK_TO_FORUM" => "Y",
            "USE_COMPARE" => "N",
            "PRICE_CODE" => array(
                StockMan\Config::CATALOG_PRICE,
                StockMan\Config::CATALOG_PRICE_B,
            ),
            "USE_PRICE_COUNT" => "N",
            "SHOW_PRICE_COUNT" => "1",
            "PRICE_VAT_INCLUDE" => "Y",
            "COMMON_ADD_TO_BASKET_ACTION" => "ADD",
            "DETAIL_ADD_TO_BASKET_ACTION" => array(
                0 => "ADD",
            ),
            "PRICE_VAT_SHOW_VALUE" => "N",
            "PRODUCT_PROPERTIES" => array(),
            "USE_PRODUCT_QUANTITY" => "N",
            "CONVERT_CURRENCY" => "N",
            "QUANTITY_FLOAT" => "N",
            "OFFERS_CART_PROPERTIES" => array(
                0 => "SIZES_SHOES",
                1 => "SIZES_CLOTHES",
                2 => "COLOR_REF",
            ),
            "SHOW_TOP_ELEMENTS" => "N",
            "SECTION_COUNT_ELEMENTS" => "N",
            "SECTION_TOP_DEPTH" => "1",
            "SECTIONS_VIEW_MODE" => "TILE",
            "SECTIONS_SHOW_PARENT_NAME" => "N",
            "PAGE_ELEMENT_COUNT" => "30",
            "LINE_ELEMENT_COUNT" => "1",
            "ELEMENT_SORT_FIELD" => 'SHOWS',
            "ELEMENT_SORT_ORDER" => 'desc',
            "ELEMENT_SORT_FIELD2" => "id",
            "ELEMENT_SORT_ORDER2" => "desc",
            "LIST_PROPERTY_CODE" => array(
                0 => "NEWPRODUCT",
                1 => "SALELEADER",
                2 => "SPECIALOFFER",
                3 => "",
            ),
            "INCLUDE_SUBSECTIONS" => "Y",
            "LIST_META_KEYWORDS" => "-",
            "LIST_META_DESCRIPTION" => "-",
            "LIST_BROWSER_TITLE" => "-",
            "LIST_OFFERS_FIELD_CODE" => array(
                0 => "NAME",
                1 => "PREVIEW_PICTURE",
                2 => "DETAIL_PICTURE",
                3 => "",
            ),
            "LIST_OFFERS_PROPERTY_CODE" => array(
                0 => StockMan\Catalog\Config::RAZMER,
                "TSVET_OFFER"
            ),
            "LIST_OFFERS_LIMIT" => "10",
            "SECTION_BACKGROUND_IMAGE" => "UF_BACKGROUND_IMAGE",
            "DETAIL_PROPERTY_CODE" => array(
                "SOSTAV",
                "OSNOVNAYA_STRANA_PROISKHOZHDENIYA",
                //"OSNOVNOY_KOD",
                "SEZON_SVOYSTVO",
                //StockMan\Catalog\Config::STIL,
                //StockMan\Config::PROP_STYLIST_COMMENTS,
            ),
            "DETAIL_META_KEYWORDS" => "-",
            "DETAIL_META_DESCRIPTION" => "-",
            "DETAIL_BROWSER_TITLE" => "-",
            "DETAIL_OFFERS_FIELD_CODE" => array(
                0 => "NAME",
                1 => "",
            ),
            "DETAIL_OFFERS_PROPERTY_CODE" => array(
                0 => "ARTNUMBER",
                1 => "SIZES_SHOES",
                2 => "SIZES_CLOTHES",
                3 => "COLOR_REF",
                4 => "MORE_PHOTO",
                5 => StockMan\Catalog\Config::STILIST_COMMENTS,
                6 => StockMan\Catalog\Config::DETAILS,
                7 => StockMan\Catalog\Config::DELEVIRY_PAYS_BACKS,
                8 => "TSVET",
                9 => StockMan\Catalog\Config::RAZMER,
                10 => "",
            ),
            "DETAIL_BACKGROUND_IMAGE" => "BACKGROUND_IMAGE",
            "LINK_IBLOCK_TYPE" => "",
            "LINK_IBLOCK_ID" => "",
            "LINK_PROPERTY_SID" => "",
            "USE_GIFTS_DETAIL" => "N",
            "USE_GIFTS_MAIN_PR_SECTION_LIST" => "N",
            "LINK_ELEMENTS_URL" => "link.php?PARENT_ELEMENT_ID=#ELEMENT_ID#",
            "USE_ALSO_BUY" => "Y",
            "ALSO_BUY_ELEMENT_COUNT" => "4",
            "ALSO_BUY_MIN_BUYES" => "1",
            "OFFERS_SORT_FIELD" => "sort",
            "OFFERS_SORT_ORDER" => "desc",
            "OFFERS_SORT_FIELD2" => "id",
            "OFFERS_SORT_ORDER2" => "desc",
            "PAGER_TEMPLATE" => "podium_market",
            "DISPLAY_TOP_PAGER" => "N",
            "DISPLAY_BOTTOM_PAGER" => "Y",
            "PAGER_TITLE" => "Товары",
            "PAGER_SHOW_ALWAYS" => "N",
            "PAGER_DESC_NUMBERING" => "N",
            "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000000",
            "PAGER_SHOW_ALL" => "N",
            "ADD_PICT_PROP" => "MORE_PHOTO",
            "LABEL_PROP" => array(
                0 => "NEWPRODUCT",
            ),
            "PRODUCT_DISPLAY_MODE" => "Y",
            "OFFER_ADD_PICT_PROP" => "MORE_PHOTO",
            "OFFER_TREE_PROPS" => array(
                StockMan\Catalog\Config::RAZMER,
                "TSVET_OFFER"
                //1 => "SIZES_CLOTHES",
                //2 => "COLOR_REF",
                //3 => "",
            ),
            "SHOW_DISCOUNT_PERCENT" => "Y",
            "SHOW_OLD_PRICE" => "Y",
            "MESS_BTN_BUY" => "Купить",
            "MESS_BTN_ADD_TO_BASKET" => "В корзину",
            "MESS_BTN_COMPARE" => "Сравнение",
            "MESS_BTN_DETAIL" => "Подробнее",
            "MESS_NOT_AVAILABLE" => "Нет в наличии",
            "DETAIL_USE_VOTE_RATING" => "N",
            "DETAIL_VOTE_DISPLAY_AS_RATING" => "rating",
            "DETAIL_USE_COMMENTS" => "N",
            "DETAIL_BLOG_USE" => "Y",
            "DETAIL_VK_USE" => "N",
            "DETAIL_FB_USE" => "Y",
            "AJAX_OPTION_ADDITIONAL" => "",
            "USE_STORE" => "N",
            "USE_BIG_DATA" => "Y",
            "BIG_DATA_RCM_TYPE" => "personal",
            "FIELDS" => array(
                0 => "STORE",
                1 => "SCHEDULE",
            ),
            "USE_MIN_AMOUNT" => "N",
            "STORE_PATH" => "/store/#store_id#",
            "MAIN_TITLE" => "Наличие на складах",
            "MIN_AMOUNT" => "10",
            "DETAIL_BRAND_USE" => "N",
            "DETAIL_BRAND_PROP_CODE" => "BRAND_REF",
            "SIDEBAR_SECTION_SHOW" => "Y",
            "SIDEBAR_DETAIL_SHOW" => "Y",
            "SIDEBAR_PATH" => "/catalog_sidebar.php",
            "CATALOG_ELEMENT_TEMPLATE" => "podiummarket_element",
            "COMPONENT_TEMPLATE" => "catalogpodiummarket",
            "HIDE_NOT_AVAILABLE_OFFERS" => "Y",
            "COMMON_SHOW_CLOSE_POPUP" => "N",
            "PRODUCT_SUBSCRIPTION" => "Y",
            "DISCOUNT_PERCENT_POSITION" => "bottom-right",
            "SHOW_MAX_QUANTITY" => "N",
            "MESS_BTN_SUBSCRIBE" => "Подписаться",
            "USER_CONSENT" => "N",
            "USER_CONSENT_ID" => "0",
            "USER_CONSENT_IS_CHECKED" => "Y",
            "USER_CONSENT_IS_LOADED" => "N",
            "DETAIL_STRICT_SECTION_CHECK" => "N",
            "SET_LAST_MODIFIED" => "N",
            "USE_SALE_BESTSELLERS" => "Y",
            "FILTER_HIDE_ON_MOBILE" => "N",
            "INSTANT_RELOAD" => "N",
            "ADD_PROPERTIES_TO_BASKET" => "Y",
            "PARTIAL_PRODUCT_PROPERTIES" => "N",
            "USE_COMMON_SETTINGS_BASKET_POPUP" => "N",
            "TOP_ADD_TO_BASKET_ACTION" => "ADD",
            "SECTION_ADD_TO_BASKET_ACTION" => "ADD",
            "DETAIL_ADD_TO_BASKET_ACTION_PRIMARY" => array(),
            "SEARCH_PAGE_RESULT_COUNT" => "250",
            "SEARCH_RESTART" => "N",
            "SEARCH_NO_WORD_LOGIC" => "Y",
            "SEARCH_USE_LANGUAGE_GUESS" => "Y",
            "SEARCH_CHECK_DATES" => "Y",
            "SECTIONS_HIDE_SECTION_NAME" => "N",
            "DETAIL_CHECK_SECTION_ID_VARIABLE" => "N",
            "SHOW_DEACTIVATED" => "N",
            "DETAIL_MAIN_BLOCK_PROPERTY_CODE" => array(),
            "DETAIL_MAIN_BLOCK_OFFERS_PROPERTY_CODE" => array(),
            "DETAIL_IMAGE_RESOLUTION" => "16by9",
            "DETAIL_PRODUCT_INFO_BLOCK_ORDER" => "sku,props",
            "DETAIL_PRODUCT_PAY_BLOCK_ORDER" => "rating,price,priceRanges,quantityLimit,quantity,buttons",
            "DETAIL_SHOW_SLIDER" => "N",
            "DETAIL_DETAIL_PICTURE_MODE" => array(
                0 => "POPUP",
                1 => "MAGNIFIER",
            ),
            "DETAIL_ADD_DETAIL_TO_SLIDER" => "N",
            "DETAIL_DISPLAY_PREVIEW_TEXT_MODE" => "E",
            "MESS_PRICE_RANGES_TITLE" => "Цены",
            "MESS_DESCRIPTION_TAB" => "Описание",
            "MESS_PROPERTIES_TAB" => "Характеристики",
            "MESS_COMMENTS_TAB" => "Комментарии",
            "DETAIL_SHOW_POPULAR" => "Y",
            "DETAIL_SHOW_VIEWED" => "Y",
            "USE_GIFTS_SECTION" => "N",
            "GIFTS_SECTION_LIST_PAGE_ELEMENT_COUNT" => "4",
            "GIFTS_SECTION_LIST_HIDE_BLOCK_TITLE" => "N",
            "GIFTS_SECTION_LIST_BLOCK_TITLE" => "Подарки к товарам этого раздела",
            "GIFTS_SECTION_LIST_TEXT_LABEL_GIFT" => "Подарок",
            "GIFTS_SHOW_DISCOUNT_PERCENT" => "Y",
            "GIFTS_SHOW_OLD_PRICE" => "Y",
            "GIFTS_SHOW_NAME" => "Y",
            "GIFTS_SHOW_IMAGE" => "Y",
            "GIFTS_MESS_BTN_BUY" => "Выбрать",
            "USE_ENHANCED_ECOMMERCE" => "N",
            "PAGER_BASE_LINK_ENABLE" => "N",
            "LAZY_LOAD" => "N",
            "LOAD_ON_SCROLL" => "N",
            "SHOW_404" => "N",
            "MESSAGE_404" => "",
            "COMPATIBLE_MODE" => "Y",
            "DISABLE_INIT_JS_IN_COMPONENT" => "N",
            "DETAIL_SET_VIEWED_IN_COMPONENT" => "N",
            "SEF_URL_TEMPLATES" => array(
                "sections" => "",
                "section" => "#SECTION_CODE_PATH#/",
                "element" => "#SECTION_CODE_PATH#/#ELEMENT_CODE#/",
                "compare" => "compare/",
                "smart_filter" => "#SECTION_CODE_PATH#/filter/#SMART_FILTER_PATH#/apply/",
            ),
        ),
        false,
        array("HIDE_ICONS" => "Y")
    );
    ?></div><?
}
?>