<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Бренды");
?>
<?if ($_REQUEST['ROW_ID']){
    ?>
    <?$APPLICATION->IncludeComponent("bitrix:breadcrumb","",
        Array(
            "START_FROM" => "0",
            "PATH" => "",
            "SITE_ID" => StockMan\Config::SITE_ID
        )
    );?>
    <?$APPLICATION->IncludeComponent(
        "bitrix:highloadblock.view",
        "",
        Array(
            "BLOCK_ID" => StockMan\Config::HB_ID_BRANDS,
            "ROW_ID" => $_REQUEST['ROW_ID'],
            "ROW_KEY" => "UF_CODE",
            "LIST_URL" => "/brands/",
            "DETAIL_URL" => "/brands/#UF_CODE#/",
        )
    );
    ?>
    <?/*
<div class="content">
    <div class="grid-x grid-padding-x margin-bottom-12">
        <div class="cell small-12 medium-8 large-6 size">
            <?
            $APPLICATION->IncludeComponent(
                "bitrix:catalog.smart.filter",
                "catalogfilter",
                array(
                    "IBLOCK_TYPE" => StockMan\Config::CATALOG_TYPE,
                    "IBLOCK_ID" => StockMan\Config::CATALOG_ID,
                    "SECTION_ID" => GetHomeCtalogSection(),
                    "FILTER_NAME" => "sFS",
                    "PRICE_CODE" => array(
                        StockMan\Config::CATALOG_PRICE,
                        StockMan\Config::CATALOG_PRICE_B,
                    ),
                    "CACHE_TYPE" => $arParams["CACHE_TYPE"],
                    "CACHE_TIME" => $arParams["CACHE_TIME"],
                    "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
                    "SAVE_IN_SESSION" => "N",
                    "FILTER_VIEW_MODE" => $arParams["FILTER_VIEW_MODE"],
                    "XML_EXPORT" => "Y",
                    "SECTION_TITLE" => "NAME",
                    "SECTION_DESCRIPTION" => "DESCRIPTION",
                    'HIDE_NOT_AVAILABLE' => $arParams["HIDE_NOT_AVAILABLE"],
                    "TEMPLATE_THEME" => $arParams["TEMPLATE_THEME"],
                    'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
                    'CURRENCY_ID' => $arParams['CURRENCY_ID'],
                    "SEF_MODE" => $arParams["SEF_MODE"],
                    "SEF_RULE" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["smart_filter"],
                    "SMART_FILTER_PATH" => $arResult["VARIABLES"]["SMART_FILTER_PATH"],
                    "PAGER_PARAMS_NAME" => $arParams["PAGER_PARAMS_NAME"],
                    "INSTANT_RELOAD" => $arParams["INSTANT_RELOAD"],
                ),
                $component,
                array('HIDE_ICONS' => 'Y')
            );
            ?>
        </div>
        <div class="cell small-12 medium-4 large-6 text-center medium-text-right">
            <a class="text-secondary margin-right-7" href="#">На модели</a>

        </div>
    </div>
*/?>
<?}?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>