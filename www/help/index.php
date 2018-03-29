<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Помощь покупателю");
?>

<?
if (CModule::IncludeModule("sale"))
{
    $arFields = array(
        "PRODUCT_ID" => 239473,
        "PRODUCT_PRICE_ID" => 0,
        "PRICE" => 138.54,
        "CURRENCY" => "RUB",
        "WEIGHT" => 530,
        "QUANTITY" => 1,
        "LID" => LANG,
        "DELAY" => "N",
        "CAN_BUY" => "Y",
        "NAME" => "Чемодан кожаный",
        "CALLBACK_FUNC" => "MyBasketCallback",
        "MODULE" => "my_module",
        "NOTES" => "",
        "ORDER_CALLBACK_FUNC" => "MyBasketOrderCallback",
        "DETAIL_PAGE_URL" => "/".LANG."/detail.php?ID=51"
    );

    $arProps = array();

    $arProps[] = array(
        "NAME" => "Цвет",
        "CODE" => "color",
        "VALUE" => "черный"
    );

    $arProps[] = array(
        "NAME" => "Размер",
        "VALUE" => "1.5 x 2.5"
    );

    $arFields["PROPS"] = $arProps;

    CSaleBasket::Add($arFields);
    echo "Добавили товар.";
}
?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>