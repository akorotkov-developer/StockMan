<?php

/**
 * composer autoloader
 * конфигурация - ./include/composer.json
 * после внесения изменений в конфигурацию выполнить php composer.phar install
 * @link https://getcomposer.org/
 */
require(__DIR__ . "/../include/vendor/autoload.php");

/**
 * инициализация приложения
 */
StockMan\Application::init();


AddEventHandler("main", "OnAfterUserRegister", Array("UserRegister", "OnAfterUserRegisterHandler"));
class UserRegister
{
    function OnAfterUserRegisterHandler(&$arFields)
    {
        CModule::IncludeModule("subscribe");
        $arFieldsSubscribe = Array(
            "EMAIL" => $arFields["EMAIL"],
            "ACTIVE" => "Y",
            "RUB_ID" => 2
        );
        $subscr = new CSubscription;

        //can add without authorization
        $subscr->Add($arFieldsSubscribe);
    }
}
?>