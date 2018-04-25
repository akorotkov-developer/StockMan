<?
require_once($_SERVER['DOCUMENT_ROOT'] . "/local/tools/CImportStokMan.php");

$eventManager = \Bitrix\Main\EventManager::getInstance();
$eventManager->addEventHandler('', 'MARKAOnBeforeUpdate', 'MARKAOnBeforeUpdate');

/**
 *
 * @param \Bitrix\Main\Entity\Event $event
 * @return \Bitrix\Main\Entity\EventResult
 */
function MARKAOnBeforeUpdate(\Bitrix\Main\Entity\Event $event) {
    $id = $event->getParameter("id");
    //id обновляемого элемента
    $id = $id["ID"];

    $entity = $event->getEntity();
    // получаем массив полей хайлоад блока
    $arFields = $event->getParameter("fields");

    $result = new \Bitrix\Main\Entity\EventResult();

    //модификация данных
    $arFields['UF_CODE'] = CUtil::translit($arFields['UF_NAME'], "ru", ImportStokMan::$translateParams);
    $result->modifyFields($arFields);

    return $result;
}

$eventManager = \Bitrix\Main\EventManager::getInstance();
$eventManager->addEventHandler('', 'MARKAOnBeforeAdd', 'MARKAOnBeforeAdd');

/**
 *
 * @param \Bitrix\Main\Entity\Event $event
 * @return \Bitrix\Main\Entity\EventResult
 */
function MARKAOnBeforeAdd(\Bitrix\Main\Entity\Event $event) {
    $entity = $event->getEntity();
    // получаем массив полей хайлоад блока
    $arFields = $event->getParameter("fields");

    $result = new \Bitrix\Main\Entity\EventResult();

    //модификация данных
    $arFields['UF_CODE'] = CUtil::translit($arFields['UF_NAME'], "ru", ImportStokMan::$translateParams);
    $result->modifyFields($arFields);

    return $result;
}

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

//AddEventHandler("iblock", "OnAfterIBlockElementUpdate",  Array("StockManHandlers", "DoIBlockAfterSave"));
//AddEventHandler("iblock", "OnAfterIBlockElementAdd", Array("StockManHandlers",  "DoIBlockAfterSave"));
AddEventHandler("catalog", "OnPriceAdd",  Array("StockManHandlers", "DoIBlockAfterSave"));
AddEventHandler("catalog", "OnPriceUpdate",  Array("StockManHandlers", "DoIBlockAfterSave"));

AddEventHandler("catalog", "OnBeforeCatalogStoreUpdate",  Array("StockManHandlers", "OnBeforeCatalogStoreUpdateHandler"));

AddEventHandler("catalog", "OnSuccessCatalogImport1C",  Array("StockManHandlers", "OnSuccessCatalogImport1CHandler"));


AddEventHandler("sale", "OnBeforeBasketAdd",  Array("StockManHandlers", "OnBeforeBasketUpdateHandler"));



AddEventHandler("iblock", "OnBeforeIBlockElementUpdate", Array("StockManHandlers", "OnBeforeIBlockElementUpdateHandler"));

AddEventHandler("catalog", "OnGetOptimalPrice", Array("StockManHandlers", "OnGetOptimalPriceHandler"));

class StockManHandlers
{
    protected static $handlerDisallow = false;

    function OnGetOptimalPriceHandler($productID, $quantity = 1, $arUserGroups = array(), $renewal = "N", $arPrices = array(), $siteID = false, $arDiscountCoupons = false)
    {
        global $LocalPrice;
        if($LocalPrice <= 0)
        {
            $dbBasketItems = CSaleBasket::GetList(false,
                array(
                    "FUSER_ID" => CSaleBasket::GetBasketUserID(),
                    "LID" => SITE_ID,
                    "ORDER_ID" => "NULL"
                ),
                false,
                false,
                array("ID", "MODULE", "PRODUCT_ID", "CALLBACK_FUNC", "QUANTITY", "DELAY", "CAN_BUY", "PRICE")
            );
            while ($arItem = $dbBasketItems->Fetch())
            {
                if($arItem['DELAY'] == 'N' && $arItem['CAN_BUY'] == 'Y')
                {
                    $LocalPrice += $arItem['PRICE']*$arItem['QUANTITY'];
                }
            }
        }

        $arOptPrices = CCatalogProduct::GetByIDEx($productID);
        $catalog_group_id = StockMan\Config::CATALOG_PRICE_ID;
        $price = $arOptPrices['PRICES'][$catalog_group_id]['PRICE'];

        $arDiscounts = CCatalogDiscount::GetDiscountByProduct(
            $productID,
            $arUserGroups,
            "N",
            $catalog_group_id,
            SITE_ID
        );
        if (is_array($arDiscounts)) {
            $discount = $arDiscounts["VALUE"];
            return array(
                'PRICE' => array(
                    "ID" => $productID,
                    'CATALOG_GROUP_ID' => $catalog_group_id,
                    'PRICE' => $price,
                    'CURRENCY' => "RUB",
                    'ELEMENT_IBLOCK_ID' => $productID,
                    'VAT_INCLUDED' => "Y",
                ),
                'DISCOUNT_LIST' => $arDiscounts
            );
        }
        else {
            $discount = 0;
            return array(
                'PRICE' => array(
                    "ID" => $productID,
                    'CATALOG_GROUP_ID' => $catalog_group_id,
                    'PRICE' => $price,
                    'CURRENCY' => "RUB",
                    'ELEMENT_IBLOCK_ID' => $productID,
                    'VAT_INCLUDED' => "Y",
                ),
                'DISCOUNT' => array(
                    'VALUE' => $discount,
                    'CURRENCY' => "RUB",
                )
            );
        }
    }

    // создаем обработчик события "OnAfterIBlockElementUpdate"
    function OnAfterIBlockElementUpdateHandler($arFields)
    {
        $idProduct = $arFields['ID'];
        if (self::$handlerDisallow)
            return;
        if ($arFields['IBLOCK_ID'] == ImportStokMan::$IBLOCK_ID) {
            $arIdSection = $arFields["IBLOCK_SECTION"];

            if (!isset($arFields["IBLOCK_SECTION"])) {
                $arIdSection = array();
                $db_old_groups = CIBlockElement::GetElementGroups($idProduct, true);
                while ($ar_group = $db_old_groups->Fetch()) {
                    $arIdSection[] = $ar_group["ID"];
                }
            }
            /*if ((in_array(ImportStokMan::$IBLOCK_SECTION_ERROR_ID, $arIdSection)) or (in_array(ImportStokMan::$IBLOCK_SECTION_ID, $arIdSection))) {
                CIBlockElement::SetPropertyValues($idProduct, $arFields['IBLOCK_ID'], '', StockMan\Config::PROP_NOVINKA_DATE);
                CIBlockElement::SetPropertyValues($idProduct, $arFields['IBLOCK_ID'], false, StockMan\Config::PROP_NOVINKA);
                CIBlockElement::SetPropertyValues($idProduct, $arFields['IBLOCK_ID'], false, StockMan\Config::PROP_WAS_NOVINKA);
                $arLoadProduct = array(
                    "ACTIVE" => "N"
                );
                self::$handlerDisallow = true; //отключаем
                $el = new CIBlockElement;
                $el->Update($idProduct, $arLoadProduct);
            } else {*/
            $arLoadProduct = array();
            $flagS = false;
            if ((in_array(ImportStokMan::$IBLOCK_SECTION_ERROR_ID, $arIdSection)) or (in_array(ImportStokMan::$IBLOCK_SECTION_ID, $arIdSection))) {
                CIBlockElement::SetPropertyValues($idProduct, $arFields['IBLOCK_ID'], '', StockMan\Config::PROP_NOVINKA_DATE);
                CIBlockElement::SetPropertyValues($idProduct, $arFields['IBLOCK_ID'], false, StockMan\Config::PROP_NOVINKA);
                CIBlockElement::SetPropertyValues($idProduct, $arFields['IBLOCK_ID'], false, StockMan\Config::PROP_WAS_NOVINKA);
                $arLoadProduct = array(
                    "ACTIVE" => "N"
                );
                $flagS = true;
            }
            $arPropertyStil = array();
            $resStil = CIBlockElement::GetProperty($arFields['IBLOCK_ID'], $arFields["ID"], "sort", "asc", array("CODE" => StockMan\Catalog\Config::STIL));
            if ($obStil = $resStil->GetNext()) {
                $arPropertyStil = $obStil;
            }

            $DVStil = CIBlockFormatProperties::GetDisplayValue($arFields, $arPropertyStil);

            $arPropertyTsvet = array();
            $resTsvet = CIBlockElement::GetProperty($arFields['IBLOCK_ID'], $arFields["ID"], "sort", "asc", array("CODE" => ImportStokMan::$CODE_PROPERTYY_TSVET));
            if ($obTsvet = $resTsvet->GetNext()) {
                $arPropertyTsvet = $obTsvet;
            }

            $DVTsvet = CIBlockFormatProperties::GetDisplayValue($arFields, $arPropertyTsvet);

            if ((isset($DVStil['DISPLAY_VALUE']{1})) and (isset($DVTsvet['DISPLAY_VALUE']{1}))) {
                $name = $DVStil['DISPLAY_VALUE'];
                $nameCode = $DVStil['DISPLAY_VALUE'] . ' ' . $DVTsvet['DISPLAY_VALUE'];
                $arLoadProductArrayCode = Array(
                    "NAME" => $name,
                    "CODE" => CUtil::translit($nameCode, "ru", ImportStokMan::$translateParams)
                );

                self::$handlerDisallow = true; //отключаем
                $el = new CIBlockElement;
                $el->Update($idProduct, array_merge($arLoadProductArrayCode, $arLoadProduct), false, true);

                updateElementIndexStockMan($idProduct);
            } elseif ($flagS) {
                self::$handlerDisallow = true; //отключаем
                $el = new CIBlockElement;
                $el->Update($idProduct, $arLoadProduct, false, true);

                updateElementIndexStockMan($idProduct);
            }
            //}
            self::$handlerDisallow = false;
        }
    }

    function OnBeforeIBlockElementUpdateHandler(&$arFields)
    {
        if ($arFields['IBLOCK_ID'] == ImportStokMan::$IBLOCK_ID) {
            $idProduct = $arFields['ID'];
            $arIdSection = $arFields["IBLOCK_SECTION"];

            if (!isset($arFields["IBLOCK_SECTION"])) {
                $arIdSection = array();
                $db_old_groups = \CIBlockElement::GetElementGroups($idProduct, true);
                while ($ar_group = $db_old_groups->Fetch()) {
                    $arIdSection[] = $ar_group["ID"];
                }
            }

            if ((in_array(ImportStokMan::$IBLOCK_SECTION_ERROR_ID, $arIdSection)) or (in_array(ImportStokMan::$IBLOCK_SECTION_ID, $arIdSection))) {

                \CIBlockElement::SetPropertyValues($idProduct, $arFields['IBLOCK_ID'], '', StockMan\Config::PROP_NOVINKA_DATE);
                \CIBlockElement::SetPropertyValues($idProduct, $arFields['IBLOCK_ID'], false, StockMan\Config::PROP_NOVINKA);
                \CIBlockElement::SetPropertyValues($idProduct, $arFields['IBLOCK_ID'], false, StockMan\Config::PROP_WAS_NOVINKA);

                $arFields["ACTIVE"] = "N";

                updateElementIndexStockMan($idProduct);
            }
        }
    }
    function AfterElementAddHandler(&$arFields)
    {
        if ($_SERVER['PHP_SELF'] == '/bitrix/admin/1c_exchange.php') {
            //$name = $arFields["NAME"];
            $nameCode = $arFields["NAME"];
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
                        //$name = $DVStil['DISPLAY_VALUE'] . ' ';
                        $nameCode = $DVStil['DISPLAY_VALUE'] . ' ' . $DVTsvet['DISPLAY_VALUE'];
                        $flag = true;
                    }
                }
                $arLoadProductArray = Array(
                    "ACTIVE" => "N",
                    "IBLOCK_SECTION_ID" => $IBLOCK_SECTION_ID
                );

                if ($flag) {
                    //$name = htmlspecialcharsBack($name);
                    $nameCode = htmlspecialcharsBack($nameCode);
                    $code = CUtil::translit($nameCode, "ru", ImportStokMan::$translateParams);

                    $arLoadProductArray = Array(
                        "ACTIVE" => "N",
                        "NAME" => $nameCode,
                        "CODE" => $code,
                        "IBLOCK_SECTION_ID" => $IBLOCK_SECTION_ID
                    );
                }

                $el = new CIBlockElement;
                $el->Update($arFields["ID"], $arLoadProductArray, false, true);

                updateElementIndexStockMan($arFields["ID"]);
            }
        }
    }

    function OnSuccessCatalogImport1CHandler( $arParams, $arFields ) {
        $pos = strpos($arFields, 'data_import.xml');
        if ($pos !== false) {
            $arIdDeActive = array();
            $arFilter = Array(
                "ACTIVE" => "Y",
                "IBLOCK_ID" => ImportStokMan::$IBLOCK_ID,
                "SECTION_ID" => array(
                    ImportStokMan::$IBLOCK_SECTION_ERROR_ID,
                    ImportStokMan::$IBLOCK_SECTION_ID,
                )
            );
            $res = CIBlockElement::GetList(Array("ID"=>"ASC"), $arFilter, false, false, array("ID"));
            while($ar_fields = $res->GetNext()) {
                $arIdDeActive[] = $ar_fields["ID"];
            }
            unset($res,$ar_fields);
            if (count($arIdDeActive) > 0) {
                $arLoadProduct = array(
                    "ACTIVE" => "N"
                );
                foreach ($arIdDeActive as $idProduct) {
                    CIBlockElement::SetPropertyValues($idProduct, ImportStokMan::$IBLOCK_ID, '', StockMan\Config::PROP_NOVINKA_DATE);
                    CIBlockElement::SetPropertyValues($idProduct, ImportStokMan::$IBLOCK_ID, false, StockMan\Config::PROP_NOVINKA);
                    CIBlockElement::SetPropertyValues($idProduct, ImportStokMan::$IBLOCK_ID, false, StockMan\Config::PROP_WAS_NOVINKA);

                    $el = new CIBlockElement;
                    $el->Update($idProduct, $arLoadProduct, false, true);
                    unset($el);

                    updateElementIndexStockMan($idProduct);
                }
                unset($arIdDeActive,$arLoadProduct);
            }
        }
        $pos = strpos($arFields, 'data_offers.xml');
        if ($pos !== false) {
            $arIdNoPrice = array();
            $arIdNoPriceProd = array();
            $arFilter = Array(
                "IBLOCK_ID" => StockMan\Config::CATALOG_OFFERS,
                "ACTIVE"=>"Y",
                //"CATALOG_AVAILABLE" => "Y",
                "PROPERTY_CML2_LINK.ACTIVE" => "Y",
                "CATALOG_PRICE_".StockMan\Config::CATALOG_PRICE_ID => false,
            );
            $res = CIBlockElement::GetList(Array("SORT"=>"ASC", "PROPERTY_PRIORITY"=>"ASC"), $arFilter, false, false, array("ID","IBLOCK_ID","PROPERTY_CML2_LINK"));
            while($ar_fields = $res->GetNext()) {
                $idProd = $ar_fields["PROPERTY_CML2_LINK_VALUE"];
                $i = 0;
                $arFilterPr = Array(
                    "IBLOCK_ID" => StockMan\Config::CATALOG_OFFERS,
                    "ACTIVE"=>"Y",
                    "CATALOG_AVAILABLE" => "Y",
                    "PROPERTY_CML2_LINK.ID" => $idProd,
                    "!ID" => $ar_fields["ID"]
                );
                $resPr = CIBlockElement::GetList(Array("SORT"=>"ASC"), $arFilterPr, false, false, array("ID","IBLOCK_ID"));
                while($ar_fieldsPr = $resPr->GetNext()) {
                    $i++;
                }
                if ($i == 0) {
                    $arIdNoPriceProd[] = $idProd;
                }
                $arIdNoPrice[] = $ar_fields["ID"];
            }
            unset($res,$ar_fields);

            if (count($arIdNoPrice) > 0) {
                $arLoadProductArrayActive = array(
                    "ACTIVE" => "N"
                );
                foreach ($arIdNoPrice as $idProduct) {
                    $el = new CIBlockElement;
                    $el->Update($idProduct, $arLoadProductArrayActive);
                    unset($el);
                    updateElementIndexStockMan($idProduct);
                }
                unset($arLoadProductArrayActive);
            }
            unset($arIdNoPrice);
            if (count($arIdNoPriceProd) > 0) {
                $arLoadProductArrayActive = array(
                    "ACTIVE" => "N"
                );
                foreach ($arIdNoPriceProd as $idProduct) {
                    $el = new CIBlockElement;
                    $el->Update($idProduct, $arLoadProductArrayActive, false, true);
                    unset($el);
                    updateElementIndexStockMan($idProduct);
                }
                unset($arLoadProductArrayActive);
            }
            unset($arIdNoPriceProd);

            // деактивируем - недоступные или без картинок
            $arIdDeActive = array();
            $arFilter = Array(
                "ACTIVE" => "Y",
                "IBLOCK_ID" => ImportStokMan::$IBLOCK_ID,
                "!SECTION_ID" => array(
                    ImportStokMan::$IBLOCK_SECTION_ERROR_ID,
                    ImportStokMan::$IBLOCK_SECTION_ID,
                ),
                array(
                    "LOGIC" => "OR",
                    array(
                        "DETAIL_PICTURE" => false,
                        "PROPERTY_".StockMan\Catalog\Config::MORE_PHOTO => false,
                    ),
                    array(
                        "CATALOG_AVAILABLE"=>"N"
                    )
                ),
            );
            $res = CIBlockElement::GetList(Array("ID"=>"ASC"), $arFilter, false, false, array("ID"));
            while($ar_fields = $res->GetNext()) {
                $arIdDeActive[] = $ar_fields["ID"];
            }
            unset($res,$ar_fields);

            if (count($arIdDeActive) > 0) {
                $arLoadProductArrayActive = array(
                    "ACTIVE" => "N"
                );
                foreach ($arIdDeActive as $idProduct) {
                    $el = new CIBlockElement;
                    $el->Update($idProduct, $arLoadProductArrayActive, false, true);
                    unset($el);
                    updateElementIndexStockMan($idProduct);
                }
                unset($arLoadProductArrayActive);
            }
            unset($arIdDeActive);

            // Активируем - доступные и с картинками
            $arIdActive = array();
            $arFilter = Array(
                "ACTIVE" => "N",
                "IBLOCK_ID" => ImportStokMan::$IBLOCK_ID,
                "CATALOG_AVAILABLE"=>"Y",
                array(
                    "LOGIC" => "OR",
                    array(
                        "!DETAIL_PICTURE" => false,
                    ),
                    array(
                        "!PROPERTY_".StockMan\Catalog\Config::MORE_PHOTO => false,
                    )
                ),
                "!SECTION_ID" => array(
                    ImportStokMan::$IBLOCK_SECTION_ERROR_ID,
                    ImportStokMan::$IBLOCK_SECTION_ID,
                )
            );
            $res = CIBlockElement::GetList(Array("ID"=>"ASC"), $arFilter, false, false, array("ID"));
            while($ar_fields = $res->GetNext()) {
                $arIdActive[] = $ar_fields["ID"];
            }
            unset($res,$ar_fields);
            if (count($arIdActive) > 0) {
                $arLoadProductArrayActive = array(
                    "ACTIVE" => "Y"
                );
                foreach ($arIdActive as $idProduct) {
                    $el = new CIBlockElement;
                    $el->Update($idProduct, $arLoadProductArrayActive, false, true);
                    unset($el);
                    updateElementIndexStockMan($idProduct);
                }
                unset($arLoadProductArrayActive);
            }
            unset($arIdActive);

            // деативируем - активные, но не доступные торговые предложени
            $arIdDeActive = array();
            $arFilter = Array(
                "IBLOCK_ID" => StockMan\Config::CATALOG_OFFERS,
                "ACTIVE"=>"Y",
                "CATALOG_AVAILABLE" => "N",
                "PROPERTY_CML2_LINK.ACTIVE" => "Y",
            );
            $res = CIBlockElement::GetList(Array("SORT"=>"ASC", "ID"=>"ASC"), $arFilter, false, false, array("ID"));
            while($ar_fields = $res->GetNext()) {
                $arIdDeActive[] = $ar_fields["ID"];
            }
            unset($res,$ar_fields);

            if (count($arIdDeActive) > 0) {
                $arLoadProductArrayActive = array(
                    "ACTIVE" => "N"
                );
                foreach ($arIdDeActive as $idProduct) {
                    $el = new CIBlockElement;
                    $el->Update($idProduct, $arLoadProductArrayActive);
                    unset($el);
                    updateElementIndexStockMan($idProduct);
                }
                unset($arLoadProductArrayActive);
            }
            unset($arIdDeActive);

            $IblockID = StockMan\Config::CATALOG_ID;
            $strData = time();
            $arIdNovinka = array();
            // проставляем свойство "Новинка"
            // активные, доступные, есть картинка, не был Новинкой
            $arFilter = Array(
                "IBLOCK_ID"         =>  $IblockID,
                "CATALOG_AVAILABLE" =>  "Y",
                "ACTIVE" =>  "Y",
                "PROPERTY_" . StockMan\Config::PROP_WAS_NOVINKA => false,
                "PROPERTY_" . StockMan\Config::PROP_NOVINKA => false,
                array (
                    "LOGIC" => "OR",
                    array("!DETAIL_PICTURE" => false),
                    array("!PROPERTY_MORE_PHOTO" => false),
                ),
                "!SECTION_ID" => array(
                    ImportStokMan::$IBLOCK_SECTION_ERROR_ID,
                    ImportStokMan::$IBLOCK_SECTION_ID,
                )
            );
            $res = CIBlockElement::GetList(Array("ID"=>"ASC"), $arFilter, false, false, array("ID"));
            while($ar_fields = $res->GetNext()) {
                $arIdNovinka[] = $ar_fields["ID"];
            }
            unset($res,$ar_fields);
            if (count($arIdNovinka) > 0) {
                foreach ($arIdNovinka as $idProduct) {
                    CIBlockElement::SetPropertyValues($idProduct, $IblockID, $strData, StockMan\Config::PROP_NOVINKA_DATE);
                    CIBlockElement::SetPropertyValues($idProduct, $IblockID, StockMan\Config::PROP_NOVINKA_VAL, StockMan\Config::PROP_NOVINKA);
                    CIBlockElement::SetPropertyValues($idProduct, $IblockID, StockMan\Config::PROP_WAS_NOVINKA_VAL, StockMan\Config::PROP_WAS_NOVINKA);
                    updateElementIndexStockMan($idProduct);
                }
            }
            unset($arIdNovinka);


            // убираем свойство "Новинка"
            // Новинка, дата новинки есть, нет картинок
            $strData = strtotime(StockMan\Config::PROP_PERIOD_NOVINKA);
            $arIdNoNovinka = array();
            $arFilter = Array(
                "IBLOCK_ID"         =>  $IblockID,
                "!PROPERTY_" . StockMan\Config::PROP_NOVINKA => false,
                "!PROPERTY_" . StockMan\Config::PROP_NOVINKA_DATE => '',
                "CATALOG_AVAILABLE" =>  "Y",
                "ACTIVE" =>  "Y",
                array (
                    "LOGIC" => "OR",
                    array(
                        "DETAIL_PICTURE" => false,
                        "PROPERTY_MORE_PHOTO" => false
                    ),
                    array("<PROPERTY_" . StockMan\Config::PROP_NOVINKA_DATE => $strData),
                ),
                "!SECTION_ID" => array(
                    ImportStokMan::$IBLOCK_SECTION_ERROR_ID,
                    ImportStokMan::$IBLOCK_SECTION_ID,
                )
            );
            $res = CIBlockElement::GetList(Array("ID"=>"ASC"), $arFilter, false, false, array("ID"));
            while($ar_fields = $res->GetNext()) {
                $arIdNoNovinka[] = $ar_fields["ID"];
            }
            unset($res,$ar_fields);
            if (count($arIdNoNovinka) > 0) {
                foreach ($arIdNoNovinka as $idProduct) {
                    CIBlockElement::SetPropertyValues($idProduct, $IblockID, '', StockMan\Config::PROP_NOVINKA_DATE);
                    CIBlockElement::SetPropertyValues($idProduct, $IblockID, false, StockMan\Config::PROP_NOVINKA);
                    updateElementIndexStockMan($idProduct);
                }
            }
            unset($arIdNoNovinka);

            $arIdNoDiscount = array();
            $arFilter = Array(
                "IBLOCK_ID" => StockMan\Config::CATALOG_OFFERS,
                "ACTIVE"=>"Y",
                //"CATALOG_AVAILABLE" => "Y",
                "PROPERTY_CML2_LINK.ACTIVE" => "Y",
                "CATALOG_PRICE_".StockMan\Config::CATALOG_PRICE_B_ID => false,
                "!PROPERTY_".StockMan\Catalog\Config::PROP_DISCOUNT => false,
            );
            $res = CIBlockElement::GetList(Array("ID"=>"ASC"), $arFilter, false, false, array("ID"));
            while($ar_fields = $res->GetNext()) {
                $arIdNoDiscount[] = $ar_fields["ID"];
            }
            unset($res,$ar_fields);
            if (count($arIdNoDiscount) > 0) {
                foreach ($arIdNoDiscount as $idProduct) {
                    //$valDiscount = '10000000';
                    //CIBlockElement::SetPropertyValues($idProduct, StockMan\Config::CATALOG_OFFERS, $valDiscount, StockMan\Catalog\Config::VALUE_DISCOUNT);
                    CIBlockElement::SetPropertyValues($idProduct, StockMan\Config::CATALOG_OFFERS, false, StockMan\Catalog\Config::PROP_DISCOUNT);
                    updateElementIndexStockMan($idProduct);
                }
            }

            //$arIdDiscount = array();
            $arFilter = Array(
                "IBLOCK_ID" => StockMan\Config::CATALOG_OFFERS,
                "ACTIVE"=>"Y",
                "CATALOG_AVAILABLE" => "Y",
                "PROPERTY_CML2_LINK.ACTIVE" => "Y",
                "!CATALOG_PRICE_".StockMan\Config::CATALOG_PRICE_ID => false,
                "!CATALOG_PRICE_".StockMan\Config::CATALOG_PRICE_B_ID => false
            );
            //$i = 0;
            $res = CIBlockElement::GetList(Array("ID"=>"ASC"), $arFilter, false, false, array("ID"," CATALOG_GROUP_".StockMan\Config::CATALOG_PRICE_ID," CATALOG_GROUP_".StockMan\Config::CATALOG_PRICE_B_ID));
            while($ar_fields = $res->GetNext()) {
                $Price = intval($ar_fields["CATALOG_PRICE_".StockMan\Config::CATALOG_PRICE_ID]);
                $PriceOld = intval($ar_fields["CATALOG_PRICE_".StockMan\Config::CATALOG_PRICE_B_ID]);
                $idProduct = $ar_fields["ID"];
                if (($Price>0)and($PriceOld>0)and($PriceOld>$Price)) {
                    //$valDiscount = $PriceOld - $Price;
                    CIBlockElement::SetPropertyValues($idProduct, StockMan\Config::CATALOG_OFFERS, 30, StockMan\Catalog\Config::PROP_DISCOUNT);
                    //CIBlockElement::SetPropertyValues($id, StockMan\Config::CATALOG_OFFERS, $valDiscount, StockMan\Catalog\Config::VALUE_DISCOUNT);
                    updateElementIndexStockMan($idProduct);
                } elseif ($Price>0) {
                    // $valDiscount = '10000000';
                    //CIBlockElement::SetPropertyValues($id, StockMan\Config::CATALOG_OFFERS, $valDiscount, StockMan\Catalog\Config::VALUE_DISCOUNT);
                    CIBlockElement::SetPropertyValues($idProduct, StockMan\Config::CATALOG_OFFERS, false, StockMan\Catalog\Config::PROP_DISCOUNT);
                    updateElementIndexStockMan($idProduct);
                }
            }
            unset($res,$ar_fields);

            $connection = \Bitrix\Main\Application::getConnection();
            $connection->dropTable('b_xml_tree');

            mail('v.mokin@ceteralabs.com','Выгрузка закончена','');
        }
    }

    function OnBeforeCatalogStoreUpdateHandler( $id, &$arFields ) {
        $nameStore = array();
        $nameStore[$id] = $arFields["TITLE"];
        $nameStore[2] = 'Универмаг в ТЦ "Европейский"';
        $nameStore[4] = 'Универмаг в ТГ "Модный Сезон"';
        $arFields["TITLE"] = $nameStore[$id];
    }

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

                /*foreach ($arProductID as $id) {
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

                    $arPriceOld = 0;
                    $db_res = CPrice::GetList(
                        array(),
                        array(
                            "PRODUCT_ID" => $id,
                            "CATALOG_GROUP_ID" => 7,
                        )
                    );
                    if ($ar_res = $db_res->Fetch())
                    {
                        $arPriceOld = intval($ar_res['PRICE']);
                    }
                    $valDiscount = '10000000';
                    CIBlockElement::SetPropertyValues($id, $OFFERS_IBLOCK_ID, $valDiscount, StockMan\Catalog\Config::VALUE_DISCOUNT);
                    CIBlockElement::SetPropertyValues($id, $OFFERS_IBLOCK_ID, false, StockMan\Catalog\Config::PROP_DISCOUNT);
                    if (($PRICE>0)and($arPriceOld>0)and($arPriceOld>$PRICE)) {
                        $valDiscount = $arPriceOld - $PRICE;
                        CIBlockElement::SetPropertyValues($id, $OFFERS_IBLOCK_ID, 30, StockMan\Catalog\Config::PROP_DISCOUNT);
                        CIBlockElement::SetPropertyValues($id, $OFFERS_IBLOCK_ID, $valDiscount, StockMan\Catalog\Config::VALUE_DISCOUNT);
                    }
                }*/
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
}
?>