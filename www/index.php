<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Интернет-магазин \"Одежда\"");
?>

    <?$APPLICATION->IncludeComponent(
        "bitrix:news.list",
        "slider",
        Array(
            "ACTIVE_DATE_FORMAT" => "d.m.Y",
            "ADD_SECTIONS_CHAIN" => "Y",
            "AJAX_MODE" => "N",
            "AJAX_OPTION_ADDITIONAL" => "",
            "AJAX_OPTION_HISTORY" => "N",
            "AJAX_OPTION_JUMP" => "N",
            "AJAX_OPTION_STYLE" => "Y",
            "CACHE_FILTER" => "N",
            "CACHE_GROUPS" => "Y",
            "CACHE_TIME" => "36000000",
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
            "INCLUDE_IBLOCK_INTO_CHAIN" => "Y",
            "INCLUDE_SUBSECTIONS" => "Y",
            "MESSAGE_404" => "",
            "NEWS_COUNT" => "",
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
            "SET_BROWSER_TITLE" => "Y",
            "SET_LAST_MODIFIED" => "N",
            "SET_META_DESCRIPTION" => "Y",
            "SET_META_KEYWORDS" => "Y",
            "SET_STATUS_404" => "N",
            "SET_TITLE" => "Y",
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
            <div class="cell large-3 medium-6 medium-order-2 large-order-1"><a class="coat" href="#" style="background-image:url(<?=StockMan\Config::STOCKMAN_TEMPLATE_PATH?>/i/coat1.png);">
                    <div class="coat__info">
                        <div class="coat__text">Роскошные пальто</div>
                        <div class="anchor">смотреть все</div>
                    </div></a></div>
            <div class="cell large-6 large-order-2 medium-order-1"><a class="coat" href="#" style="background-image:url(<?=StockMan\Config::STOCKMAN_TEMPLATE_PATH?>/i/coat2.png);">
                    <div class="coat__info">
                        <div class="coat__best">Самые желанные</div>
                        <div class="coat__bag">сумки</div>
                        <div class="anchor">смотреть все</div>
                    </div></a></div>
            <div class="cell large-3 medium-6 medium-order-3"><a class="coat" href="#" style="background-image:url(<?=StockMan\Config::STOCKMAN_TEMPLATE_PATH?>/i/coat3.png);">
                    <div class="coat__info">
                        <div class="anchor">смотреть товары<br>по лучшим ценам</div>
                    </div></a></div>
            <div class="cell large-6 medium-6 medium-order-4"><a class="coat coat_high" href="#" style="background-image:url(<?=StockMan\Config::STOCKMAN_TEMPLATE_PATH?>/i/coat4.png);">
                    <div class="coat__info">
                        <div class="coat__brand">бренд</div>
                        <div class="coat__title">Emilio Pucci: эффектный принт</div>
                        <div class="margin-bottom-6">Неожиданная интерпритация знакомых принтов</div>
                        <div class="anchor">Коллекция</div>
                    </div></a></div>
            <div class="cell large-6 medium-6 medium-order-5"><a class="coat coat_high" href="#" style="background-image:url(<?=StockMan\Config::STOCKMAN_TEMPLATE_PATH?>/i/coat5.png);">
                    <div class="coat__info text-white">
                        <div class="coat__brand coat__brand_white">бренд</div>
                        <div class="coat__title">Коллекция пуховиков</div>
                        <div class="margin-bottom-6">Главные модели сезона - Etro, lenki lenki и Marques Almedia</div>
                        <div class="anchor anchor_white">выбрать</div>
                    </div></a></div>
        </div>
    </div>
    <div class="grid-x grid-padding-x text-center">
        <div class="cell margin-bottom-20">
            <div class="cat text-center">
                <h2 class="cat__head">Новинки каталога   </h2>
            </div>
        </div>
    </div>
    <div class="map text-center margin-bottom-10">
        <div class="map__slide"><a class="dress dress_static" href="#">
                <div class="margin-bottom-3"><img src="<?=StockMan\Config::STOCKMAN_TEMPLATE_PATH?>/i/d1.png" alt=""></div>
                <div class="dress__title">ASHLEY WILLIAMS</div>
                <div class="text-secondary">Полосатое платье-рубашка</div>
                <div class="text-size-large">49 765. -      </div></a></div>
        <div class="map__slide"><a class="dress dress_static" href="#">
                <div class="margin-bottom-3"><img src="<?=StockMan\Config::STOCKMAN_TEMPLATE_PATH?>/i/d2.png" alt=""></div>
                <div class="dress__title">Proenza schouler</div>
                <div class="text-secondary">Платье в полоску</div>
                <div class="text-size-large">26 136. -   </div></a></div>
        <div class="map__slide"><a class="dress dress_static" href="#">
                <div class="margin-bottom-3"><img src="<?=StockMan\Config::STOCKMAN_TEMPLATE_PATH?>/i/d3.png" alt=""></div>
                <div class="dress__title">Proenza schouler</div>
                <div class="text-secondary">Платье в полоску</div>
                <div class="text-size-large">49 765. -      </div></a></div>
        <div class="map__slide"><a class="dress dress_static" href="#">
                <div class="margin-bottom-3"><img src="<?=StockMan\Config::STOCKMAN_TEMPLATE_PATH?>/i/d1.png" alt=""></div>
                <div class="dress__title">ASHLEY WILLIAMS</div>
                <div class="text-secondary">Полосатое платье-рубашка</div>
                <div class="text-size-large">26 136. - </div></a></div>
        <div class="map__slide"><a class="dress dress_static" href="#">
                <div class="margin-bottom-3"><img src="<?=StockMan\Config::STOCKMAN_TEMPLATE_PATH?>/i/d2.png" alt=""></div>
                <div class="dress__title">Proenza schouler</div>
                <div class="text-secondary">Платье в полоску</div>
                <div class="text-size-large">49 765. -      </div></a></div>
        <div class="map__slide"><a class="dress dress_static" href="#">
                <div class="margin-bottom-3"><img src="<?=StockMan\Config::STOCKMAN_TEMPLATE_PATH?>/i/d3.png" alt=""></div>
                <div class="dress__title">Proenza schouler</div>
                <div class="text-secondary">Платье в полоску</div>
                <div class="text-size-large">26 136. -</div></a></div>
    </div>
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