<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
IncludeTemplateLangFile(__FILE__);

require($_SERVER['DOCUMENT_ROOT'] . StockMan\Config::STOCKMAN_TEMPLATE_PATH . '/header.php');
?>

<?if ($APPLICATION->GetCurPage() == "/brands/") {?>
    <div class="content padding-top-5">
        <?$APPLICATION->IncludeComponent("bitrix:breadcrumb","",
            Array(
                "START_FROM" => "0",
                "PATH" => "",
                "SITE_ID" => StockMan\Config::SITE_ID
            )
        );?>
        <div class="grid-container">
            <div class="grid-x grid-padding-x">
                <div class="cell">
                    <h1 class="text-center"><?$APPLICATION->ShowTitle(false);?></h1>
                </div>
            </div>
        </div>
        <div class="grid-container">
            <div class="grid-x grid-padding-x">
                <div>
<?}?>
