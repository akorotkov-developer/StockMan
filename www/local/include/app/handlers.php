<?
require_once($_SERVER['DOCUMENT_ROOT'] . "/local/tools/CImportStokMan.php");

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

AddEventHandler("main", "OnBuildGlobalMenu", Array("StockManHandlers", "xmlLoad"));
AddEventHandler("iblock", "OnAfterIBlockElementAdd", Array("StockManHandlers", "AfterElementAddHandler"));


// зарегистрируем функцию как обработчик двух событий
AddEventHandler('form', 'onBeforeResultAdd',array('StockManHandlers', 'onBeforeResultAddHandler'));

AddEventHandler("iblock", "OnAfterIBlockElementUpdate", Array("StockManHandlers", "OnAfterIBlockElementUpdateHandler"));
AddEventHandler("main", "OnEpilog", Array("StockManHandlers", "ShowError404"));

AddEventHandler("search", "BeforeIndex", Array("StockManHandlers", "BeforeIndexHandler"));

AddEventHandler("iblock", "OnAfterIBlockElementUpdate",  Array("StockManHandlers", "DoIBlockAfterSave"));
AddEventHandler("iblock", "OnAfterIBlockElementAdd", Array("StockManHandlers",  "DoIBlockAfterSave"));
AddEventHandler("catalog", "OnPriceAdd",  Array("StockManHandlers", "DoIBlockAfterSave"));
AddEventHandler("catalog", "OnPriceUpdate",  Array("StockManHandlers", "DoIBlockAfterSave"));

AddEventHandler("sale", "OnBeforeBasketAdd",  Array("StockManHandlers", "OnBeforeBasketUpdateHandler"));

class StockManHandlers
{
    function OnBeforeBasketUpdateHandler(&$arFields)
    {
        $id = $arFields["PRODUCT_ID"];
        $tsvet = getTsvetProduct($id);
        if (isset($tsvet{1})) {
            $arTsvet = array(
                "CODE" => "TSVET_OFFER",
                "VALUE" => $tsvet,
                "SORT" => 0,
                "NAME" => "Цвет"
            );
            $arFields["PROPS"][]  = $arTsvet;
        }
    }
    function DoIBlockAfterSave($arg1, $arg2 = false)
    {
        global $USER;
        $ELEMENT_ID = false;
        $IBLOCK_ID = false;
        $OFFERS_IBLOCK_ID = false;
        $OFFERS_PROPERTY_ID = false;

        CModule::IncludeModule("catalog");
        CModule::IncludeModule("sale");
        if (CModule::IncludeModule('currency'))
            $strDefaultCurrency = CCurrency::GetBaseCurrency();

        //Check for catalog event
        if(is_array($arg2) && $arg2["PRODUCT_ID"] > 0) {
            //Get iblock element
            $rsPriceElement = CIBlockElement::GetList(
                array(),
                array(
                    "ID" => $arg2["PRODUCT_ID"],
                ),
                false,
                false,
                array("ID", "IBLOCK_ID")
            );
            if ($arPriceElement = $rsPriceElement->Fetch()) {
                if (($arPriceElement["IBLOCK_ID"] == ImportStokMan::$IBLOCK_ID) or ($arPriceElement["IBLOCK_ID"] == ImportStokMan::$IBLOCK_OFFERS_ID)) {
                    $arCatalog = CCatalog::GetByID($arPriceElement["IBLOCK_ID"]);
                    if (is_array($arCatalog)) {
                        //Check if it is offers iblock
                        if ($arCatalog["OFFERS"] == "Y") {
                            //Find product element
                            $rsElement = CIBlockElement::GetProperty(
                                $arPriceElement["IBLOCK_ID"],
                                $arPriceElement["ID"],
                                "sort",
                                "asc",
                                array("ID" => $arCatalog["SKU_PROPERTY_ID"])
                            );
                            $arElement = $rsElement->Fetch();
                            if ($arElement && $arElement["VALUE"] > 0) {
                                $ELEMENT_ID = $arElement["VALUE"];
                                $IBLOCK_ID = $arCatalog["PRODUCT_IBLOCK_ID"];
                                $OFFERS_IBLOCK_ID = $arCatalog["IBLOCK_ID"];
                                $OFFERS_PROPERTY_ID = $arCatalog["SKU_PROPERTY_ID"];
                            }
                        } //or iblock which has offers
                        elseif ($arCatalog["OFFERS_IBLOCK_ID"] > 0) {
                            $ELEMENT_ID = $arPriceElement["ID"];
                            $IBLOCK_ID = $arPriceElement["IBLOCK_ID"];
                            $OFFERS_IBLOCK_ID = $arCatalog["OFFERS_IBLOCK_ID"];
                            $OFFERS_PROPERTY_ID = $arCatalog["OFFERS_PROPERTY_ID"];
                        } //or it's regular catalog
                        else {
                            $ELEMENT_ID = $arPriceElement["ID"];
                            $IBLOCK_ID = $arPriceElement["IBLOCK_ID"];
                            $OFFERS_IBLOCK_ID = false;
                            $OFFERS_PROPERTY_ID = false;
                        }
                    }
                }
            }
        }
        //Check for iblock event
        elseif(is_array($arg1) && $arg1["ID"] > 0 && $arg1["IBLOCK_ID"] > 0)
        {
            if (($arg1["IBLOCK_ID"] == ImportStokMan::$IBLOCK_ID) or ($arg1["IBLOCK_ID"] == ImportStokMan::$IBLOCK_OFFERS_ID)) {
            //Check if iblock has offers
                $arOffers = CIBlockPriceTools::GetOffersIBlock($arg1["IBLOCK_ID"]);
                if (is_array($arOffers)) {
                    $ELEMENT_ID = $arg1["ID"];
                    $IBLOCK_ID = $arg1["IBLOCK_ID"];
                    $OFFERS_IBLOCK_ID = $arOffers["OFFERS_IBLOCK_ID"];
                    $OFFERS_PROPERTY_ID = $arOffers["OFFERS_PROPERTY_ID"];
                }
            }
        }

        if($ELEMENT_ID)
        {
            static $arPropCache = array();
            if(!array_key_exists($IBLOCK_ID, $arPropCache))
            {
                //Check for MINIMAL_PRICE property
                $rsProperty = CIBlockProperty::GetByID("MINIMUM_PRICE", $IBLOCK_ID);
                $arProperty = $rsProperty->Fetch();
                if($arProperty)
                    $arPropCache[$IBLOCK_ID] = $arProperty["ID"];
                else
                    $arPropCache[$IBLOCK_ID] = false;
            }

            if($arPropCache[$IBLOCK_ID])
            {
                //Compose elements filter
                if($OFFERS_IBLOCK_ID)
                {
                    $rsOffers = CIBlockElement::GetList(
                        array(),
                        array(
                            "CATALOG_AVAILABLE"=>"Y",
                            "ACTIVE"=>'Y',
                            "IBLOCK_ID" => $OFFERS_IBLOCK_ID,
                            "PROPERTY_".$OFFERS_PROPERTY_ID => $ELEMENT_ID,
                        ),
                        false,
                        false,
                        array("ID")
                    );
                    while($arOffer = $rsOffers->Fetch())
                        $arProductID[] = $arOffer["ID"];

                    if (!is_array($arProductID))
                        $arProductID = array($ELEMENT_ID);
                }
                else
                    $arProductID = array($ELEMENT_ID);
                $minPrice = false;

                foreach ($arProductID as $id) {
                    $arDiscounts = CCatalogDiscount::GetDiscountByProduct(
                        $id,
                        $USER->GetUserGroupArray(),
                        "N",
                        array(),
                        's1'
                    );
                    $arPrice = CCatalogProduct::GetOptimalPrice($id, 1, $USER->GetUserGroupArray(), "N", array(), 's1', $arDiscounts);

                    if (CModule::IncludeModule('currency') && $strDefaultCurrency != $arPrice["PRICE"]['CURRENCY'])
                        $arPrice["DISCOUNT_PRICE"] = CCurrencyRates::ConvertCurrency($arPrice["DISCOUNT_PRICE"], $arPrice["PRICE"]["CURRENCY"], $strDefaultCurrency);

                    $PRICE = $arPrice["DISCOUNT_PRICE"];

                    if($minPrice === false || $minPrice > $PRICE)
                        $minPrice = $PRICE;
                }
                //Get prices
                /*$rsPrices = CPrice::GetList(
                    array(),
                    array(
                        "PRODUCT_ID" => $arProductID,
                        "CATALOG_GROUP_NAME" => StockMan\Config::CATALOG_PRICE
                    )
                );
                while($arPrice = $rsPrices->Fetch())
                {
                    if (CModule::IncludeModule('currency') && $strDefaultCurrency != $arPrice['CURRENCY'])
                        $arPrice["PRICE"] = CCurrencyRates::ConvertCurrency($arPrice["PRICE"], $arPrice["CURRENCY"], $strDefaultCurrency);

                    $PRICE = $arPrice["PRICE"];

                    if($minPrice === false || $minPrice > $PRICE)
                        $minPrice = $PRICE;
                }*/

                //Save found minimal price into property
                if($minPrice !== false)
                {
                    CIBlockElement::SetPropertyValuesEx(
                        $ELEMENT_ID,
                        $IBLOCK_ID,
                        array(
                            "MINIMUM_PRICE" => $minPrice
                        )
                    );
                }
            }
        }
    }

    function BeforeIndexHandler($arFields)
    {
        if ($arFields["PARAM2"] == ImportStokMan::$IBLOCK_ID && CModule::IncludeModule("catalog") && CCatalog::GetByID($arFields["PARAM2"]))
        {
            $arFilterSection = array(ImportStokMan::$IBLOCK_SECTION_ERROR_ID, ImportStokMan::$IBLOCK_SECTION_ID);
            $res = CIBlockElement::GetByID($arFields["ITEM_ID"]);
            if($ar_res = $res->GetNext()) {
                if (in_array($ar_res["IBLOCK_SECTION_ID"],$arFilterSection)) {
                    $arFields["BODY"] = $arFields["TITLE"] = '';
                }
            }
        }
       return $arFields;
    }
    function ShowError404() {
        if (CHTTP::GetLastStatus()=='404 Not Found') {
            global $APPLICATION;
            global $USER;
            $APPLICATION->RestartBuffer();
            require $_SERVER['DOCUMENT_ROOT'].StockMan\Config::STOCKMAN_TEMPLATE_PATH.'/header.php';
            require $_SERVER['DOCUMENT_ROOT'] . '/404.php';
            require $_SERVER['DOCUMENT_ROOT'].StockMan\Config::STOCKMAN_TEMPLATE_PATH.'/footer.php';
        }
    }

    // создаем обработчик события "OnAfterIBlockElementUpdate"
    function OnAfterIBlockElementUpdateHandler(&$arFields)
    {
        if ($_SERVER['PHP_SELF'] == '/bitrix/admin/1c_exchange.php') {
            if ($arFields['IBLOCK_ID'] == ImportStokMan::$IBLOCK_ID) {
                $idProduct = $arFields['ID'];
                // не был новинкой
                if (!is_array($arFields["PROPERTY_VALUES"][216])) {
                    // есть картинка
                    if ((intval($arFields['DETAIL_PICTURE']['old_file'])>0) or ((is_array($arFields["PROPERTY_VALUES"][74]))and(count($arFields["PROPERTY_VALUES"][74])>0))) {
                        $arPropuct = CCatalogProduct::GetByID($idProduct);
                        if ($arPropuct["AVAILABLE"] == "Y") {
                            $strData = time();
                            CIBlockElement::SetPropertyValues($idProduct, $arFields['IBLOCK_ID'], $strData, StockMan\Config::PROP_NOVINKA_DATE);
                            CIBlockElement::SetPropertyValues($idProduct, $arFields['IBLOCK_ID'], StockMan\Config::PROP_NOVINKA_VAL, StockMan\Config::PROP_NOVINKA);
                            CIBlockElement::SetPropertyValues($idProduct, $arFields['IBLOCK_ID'], StockMan\Config::PROP_WAS_NOVINKA_VAL, StockMan\Config::PROP_WAS_NOVINKA);
                        } else {
                            CIBlockElement::SetPropertyValues($idProduct, $arFields['IBLOCK_ID'], false, StockMan\Config::PROP_NOVINKA);
                        }
                    } else {
                        CIBlockElement::SetPropertyValues($idProduct, $arFields['IBLOCK_ID'], false, StockMan\Config::PROP_NOVINKA);
                    }
                } else {
                    CIBlockElement::SetPropertyValues($idProduct, $arFields['IBLOCK_ID'], false, StockMan\Config::PROP_NOVINKA);
                }
            }
        }
    }

    function onBeforeResultAddHandler($WEB_FORM_ID, &$arFields, &$arrVALUES)
    {
        if ($WEB_FORM_ID == StockMan\Config::FORM_FAQ_ID)
        {
            CModule::IncludeModule("iblock");
            $name = htmlspecialcharsbx($arrVALUES['form_text_1']);
            $email = htmlspecialcharsbx($arrVALUES['form_email_2']);
            $text = htmlspecialcharsbx($arrVALUES['form_textarea_3']);

            $el = new CIBlockElement;

            $PROP = array();
            $PROP[212] = $email;
            $PROP[213] = $name;

            $arLoadProductArray = Array(
                "IBLOCK_SECTION_ID" => false,
                "IBLOCK_ID"      => 12,
                "PROPERTY_VALUES"=> $PROP,
                "NAME"           => $name . ' - ' . $email,
                "ACTIVE"         => "N",
                "PREVIEW_TEXT"   => $text
            );
            $PRODUCT_ID = $el->Add($arLoadProductArray);

            $arEventFields = array(
                "TEXT_USER"     => $text,
                "NAME_USER"     => $name,
                "EMAIL_USER"    => $email,
                "LINK"          => '/bitrix/admin/iblock_element_edit.php?IBLOCK_ID=12&type=faq&ID=' . $PRODUCT_ID . '&lang=ru&find_section_section=-1&WF=Y',

            );
            CEvent::Send("FORM_FAQ", 's1', $arEventFields);
        }
    }

    function xmlLoad(&$adminMenu, &$moduleMenu)
    {
        global $USER;
        if (!$USER->IsAdmin())
            return;

        $moduleMenu[] = array(
            "parent_menu" => "global_menu_content",   // поместим в раздел "Сервис"
            "section" => "xmlLoad",
            "sort" => 100,                     // сортировка пункта меню
            "url" => "",
            "text" => 'Выгрузка каталога',    // текст пункта меню
            "title" => 'Выгрузка каталога',    // текст всплывающей подсказки
            "icon" => "highloadblock_menu_icon",        // малая иконка
            "page_icon" => "form_page_icon",        // большая иконка
            "items_id" => "menu_online",           // идентификатор ветви
            "items" => array(
                array(
                    "parent_menu" => "global_menu_content",   // поместим в раздел "Сервис"
                    "section" => "xmlLoad",
                    "sort" => 10,                     // сортировка пункта меню
                    "url" => "xmlload.php?lang=" . LANG, // ссылка на пункте меню
                    "text" => 'Выгрузка каталога XML',    // текст пункта меню
                    "title" => 'Выгрузка каталога XML',    // текст всплывающей подсказки
                    "icon" => "fileman_menu_icon",        // малая иконка
                    "page_icon" => "form_page_icon",        // большая иконка
                    "items_id" => "menu_online",           // идентификатор ветви
                    "items" => array()
                ),
                array(
                    "parent_menu" => "global_menu_content",   // поместим в раздел "Сервис"
                    "section" => "xmlLoadPic",
                    "sort" => 20,                     // сортировка пункта меню
                    "url" => "xmlloadpic.php?lang=" . LANG, // ссылка на пункте меню
                    "text" => 'Выгрузка Картинок',    // текст пункта меню
                    "title" => 'Выгрузка Картинок',    // текст всплывающей подсказки
                    "icon" => "fileman_menu_icon",        // малая иконка
                    "page_icon" => "form_page_icon",        // большая иконка
                    "items_id" => "menu_online",           // идентификатор ветви
                    "items" => array()
                )
            )
        );
    }

    function AfterElementAddHandler(&$arFields)
    {
        if ($_SERVER['PHP_SELF'] == '/bitrix/admin/1c_exchange.php') {
            $name = $arFields["NAME"];
            $nameCode = $name;
            $flag = false;
            if ($arFields['IBLOCK_ID'] == ImportStokMan::$IBLOCK_ID) {
                $IBLOCK_SECTION_ID = ImportStokMan::$IBLOCK_SECTION_ERROR_ID;
                $CODE_STIL = '';
                $properties = CIBlockProperty::GetList(Array("sort"=>"asc", "name"=>"asc"), Array("XML_ID" => ImportStokMan::$XML_ID_STIL, "IBLOCK_ID"=>$arFields['IBLOCK_ID']));
                while ($prop_fields = $properties->GetNext())
                {
                    $CODE_STIL = $prop_fields["CODE"];
                }
                $CODE_TSVET = '';
                $properties = CIBlockProperty::GetList(Array("sort"=>"asc", "name"=>"asc"), Array("XML_ID" => ImportStokMan::$XML_ID_TSVET, "IBLOCK_ID"=>$arFields['IBLOCK_ID']));
                while ($prop_fields = $properties->GetNext())
                {
                    $CODE_TSVET = $prop_fields["CODE"];
                }

                if ((isset($CODE_STIL{1}))and(isset($CODE_TSVET{1}))) {
                    $arPropertyStil = array();
                    $resStil = CIBlockElement::GetProperty($arFields['IBLOCK_ID'], $arFields["ID"], "sort", "asc", array("CODE" => $CODE_STIL));
                    if ($obStil = $resStil->GetNext()) {
                        $arPropertyStil = $obStil;
                    }
                    $DVStil = CIBlockFormatProperties::GetDisplayValue($arFields, $arPropertyStil);

                    $arPropertyTsvet = array();
                    $resTsvet = CIBlockElement::GetProperty($arFields['IBLOCK_ID'], $arFields["ID"], "sort", "asc", array("CODE" => $CODE_TSVET));
                    if ($obTsvet = $resTsvet->GetNext()) {
                        $arPropertyTsvet = $obTsvet;
                    }

                    $DVTsvet = CIBlockFormatProperties::GetDisplayValue($arFields, $arPropertyTsvet);

                    if ((isset($DVStil['DISPLAY_VALUE']{1}))and(isset($DVTsvet['DISPLAY_VALUE']{1}))) {
                        $IBLOCK_SECTION_ID = ImportStokMan::$IBLOCK_SECTION_ID;
                        $name = $DVStil['DISPLAY_VALUE'] . ' ';
                        $nameCode = $DVStil['DISPLAY_VALUE'] . ' ' . $DVTsvet['DISPLAY_VALUE'];
                        $flag = true;
                    }
                }
                $arLoadProductArray = Array(
                    "IBLOCK_SECTION_ID" => $IBLOCK_SECTION_ID
                );

                if ($flag) {
                    $name = htmlspecialcharsBack($name);
                    $nameCode = htmlspecialcharsBack($nameCode);
                    $code = CUtil::translit($nameCode, "ru", ImportStokMan::$translateParams);

                    $arLoadProductArray = Array(
                        "NAME" => $name,
                        "CODE" => $code,
                        "IBLOCK_SECTION_ID" => $IBLOCK_SECTION_ID
                    );
                }

                $el = new CIBlockElement;
                $el->Update($arFields["ID"], $arLoadProductArray);
            }
        }
    }
}
?>