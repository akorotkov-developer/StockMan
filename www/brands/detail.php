<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Бренды");
?>
<?if ($_REQUEST['ROW_ID']>0){?>
    <?$APPLICATION->IncludeComponent(
        "bitrix:highloadblock.view",
        "",
        Array(
            "BLOCK_ID" => StockMan\Config::HB_ID_BRANDS,
            "ROW_ID" => $_REQUEST['ROW_ID'],
            "LIST_URL" => "/brands/"
        )
    );?>
<?}?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>