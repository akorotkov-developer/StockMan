<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Интернет-магазин \"Одежда\"");
?>
    <div class="content padding-bottom-0">
        <div class="grid-container">
            <?$APPLICATION->IncludeComponent(
                "bitrix:catalog.section.list",
                "central",
                Array(
                    "VIEW_MODE" => "LINE",
                    "SHOW_PARENT_NAME" => "Y",
                    "IBLOCK_TYPE" => StockMan\Config::CATALOG_TYPE,
                    "IBLOCK_ID" => StockMan\Config::CATALOG_ID,
                    "SECTION_ID" => 0,
                    "SECTION_CODE" => "",
                    "SECTION_URL" => "",
                    "COUNT_ELEMENTS" => "N",
                    "TOP_DEPTH" => "1",
                    "SECTION_FIELDS" => "",
                    "SECTION_USER_FIELDS" => "",
                    "ADD_SECTIONS_CHAIN" => "Y",
                    "CACHE_TYPE" => "A",
                    "CACHE_TIME" => "36000000",
                    "CACHE_NOTES" => "",
                    "CACHE_GROUPS" => "Y"
                )
            );?>
            <?
            require_once($_SERVER['DOCUMENT_ROOT'] . StockMan\Config::STOCKMAN_TEMPLATE_PATH . '/include_areas/brends_list.php');
            ?>
        </div>
        <?
        require_once($_SERVER['DOCUMENT_ROOT'] . StockMan\Config::STOCKMAN_TEMPLATE_PATH . '/include_areas/information_block.php');
        ?>
    </div>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>