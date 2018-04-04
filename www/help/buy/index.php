<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Где купить");
?>
<?
$APPLICATION->IncludeComponent(
    "bitrix:catalog.store.list",
    "help",
    Array(
        "PHONE" => "Y",
        "SCHEDULE" => "Y",
        "PATH_TO_ELEMENT" => "store/#store_id#",
        "MAP_TYPE" => "0",
        "SET_TITLE" => "N",
        "CACHE_TYPE" => "A",
        "CACHE_TIME" => "36000"
    )
);?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
