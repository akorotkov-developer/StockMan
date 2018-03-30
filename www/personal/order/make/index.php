<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Заказы");
?>

        <div class="grid-container">
            <div class="grid-x grid-padding-x">
                <div class="cell text-center">
                    <h1><?$APPLICATION->ShowTitle()?></h1>
                </div>
            </div>
        </div>

        <?$APPLICATION->IncludeComponent("bitrix:sale.order.ajax", "", array(
            "PAY_FROM_ACCOUNT" => "Y",
            "COUNT_DELIVERY_TAX" => "N",
            "COUNT_DISCOUNT_4_ALL_QUANTITY" => "N",
            "ONLY_FULL_PAY_FROM_ACCOUNT" => "Y",
            "ALLOW_AUTO_REGISTER" => "Y",
            "SEND_NEW_USER_NOTIFY" => "Y",
            "DELIVERY_NO_AJAX" => "N",
            "TEMPLATE_LOCATION" => "popup",
            "PROP_1" => array(
            ),
            "PATH_TO_BASKET" => "/personal/cart/",
            "PATH_TO_PERSONAL" => "/personal/order/",
            "PATH_TO_PAYMENT" => "/personal/order/payment/",
            "PATH_TO_ORDER" => "/personal/order/make/",
            "SET_TITLE" => "Y" ,
            "SHOW_ACCOUNT_NUMBER" => "Y",
            "DELIVERY_NO_SESSION" => "Y",
            "COMPATIBLE_MODE" => "N",
            "BASKET_POSITION" => "before",
            "BASKET_IMAGES_SCALING" => "adaptive",
            "SERVICES_IMAGES_SCALING" => "adaptive",
            "USER_CONSENT" => "Y",
            "USER_CONSENT_ID" => "1",
            "USER_CONSENT_IS_CHECKED" => "Y",
            "USER_CONSENT_IS_LOADED" => "Y"
            ),
            false
        );?>



<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>