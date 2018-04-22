<?
include_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/urlrewrite.php');

CHTTP::SetStatus("404 Not Found");
@define("ERROR_404","Y");
CBXShortUri::CheckUri();

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

$APPLICATION->SetTitle("Страница не найдена");?>

    <div class="content">
        <div class="grid-container">
            <div class="grid-x grid-padding-x">
                <div class="cell text-center">
                    <h1 class="text-center"><?$APPLICATION->ShowTitle(true);?></h1>
                    <div class="fault">404</div>
                    <div class="text-secondary">К сожалению, запрашиваемый Вами документ не найден.</div>
                    <div class="margin-bottom-9">Вы перешли по несуществующей ссылке или страница была удалена.</div><a href="<?=SITE_DIR?>">На главную </a>
                </div>
            </div>
        </div>
    </div>
<?
    ob_start();
    $homeCatalog = GetHomeCtalogSection();
    $APPLICATION->IncludeComponent(
        "bitrix:catalog.section.list",
        "menutop",
        Array(
            "VIEW_MODE" => "LINE",
            "SHOW_PARENT_NAME" => "Y",
            "IBLOCK_TYPE" => StockMan\Config::CATALOG_TYPE,
            "IBLOCK_ID" => StockMan\Config::CATALOG_ID,
            "SECTION_ID" => $homeCatalog, // GetIdSectionCatalog();
            "SECTION_CODE" => "",
            "SECTION_URL" => "",
            "COUNT_ELEMENTS" => "Y",
            "TOP_DEPTH" => "4",
            "SECTION_FIELDS" => "",
            "SECTION_USER_FIELDS" => "",
            "ADD_SECTIONS_CHAIN" => "N",
            "CACHE_TYPE" => "N",
            "CACHE_TIME" => "3600",
            "CACHE_NOTES" => "",
            "CACHE_GROUPS" => "N",
            "CURREN_SECTION_ID" => $homeCatalog
        )
    );
    $top_menu = ob_get_contents();
    ob_end_clean();
    $APPLICATION->AddViewContent('top_menu', $top_menu);
?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>