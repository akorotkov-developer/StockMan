<?php
//AddEventHandler("iblock", "OnAfterIBlockElementUpdate", Array("StockManHandler", "OnAfterIBlockElementUpdateHandler"));
//AddEventHandler("iblock", "OnAfterIBlockElementAdd", Array("StockManHandler", "OnAfterIBlockElementUpdateHandler"));

//AddEventHandler("iblock", "OnAfterIBlockSectionUpdate", Array("StockManHandler", "OnAfterIBlockSectionUpdateHandler"));
//AddEventHandler("iblock", "OnAfterIBlockSectionAdd", Array("StockManHandler", "OnAfterIBlockSectionUpdateHandler"));


AddEventHandler("catalog", "OnGetOptimalPrice", Array("StockManHandler", "OnGetOptimalPriceHandler"));
AddEventHandler("main", "OnEpilog", Array("StockManHandler", "ShowError404"));

class StockManHandler
{
    function ShowError404() {
        if (CHTTP::GetLastStatus()=='404 Not Found') {
            global $APPLICATION;
            $APPLICATION->RestartBuffer();
            require $_SERVER['DOCUMENT_ROOT'].SITE_TEMPLATE_PATH.'/header.php';
            require $_SERVER['DOCUMENT_ROOT'] . '/404.php';
            require $_SERVER['DOCUMENT_ROOT'].SITE_TEMPLATE_PATH.'/footer.php';
        }
    }

    public static $handlerDisallow = false;

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
/*
    function OnAfterIBlockElementUpdateHandler(&$arFields)
    {
        if (($arFields["IBLOCK_ID"] == StockMan\Config::CATALOG_IBLOCK_ID)or($arFields["IBLOCK_ID"] == StockMan\Config::CATALOG_OFFERS_IBLOCK_ID)) {
            if (self::$handlerDisallow)
                return;

            self::$handlerDisallow = true;  //���������

            if ($arFields["RESULT"]) {
                $arFilter = Array(
                    "ID" => $arFields["ID"],
                    "!DETAIL_PICTURE" => false
                );
                $arSelect = array(
                    "ID",
                    "IBLOCK_ID",
                    "DETAIL_PICTURE"
                );
                $res = CIBlockElement::GetList(Array("SORT" => "ASC", "ID" => "ASC"), $arFilter, false, false, $arSelect);
                while ($ar_fields = $res->GetNext()) {
                    $arPic = CFile::GetFileArray($ar_fields["DETAIL_PICTURE"]);
                    $str = editPictAndWaterMark($arPic, 1600);
                    if ($str) {
                        $el = new CIBlockElement;
                        $arLoadProductArray = Array(
                            "DETAIL_PICTURE" => CFile::MakeFileArray($_SERVER["DOCUMENT_ROOT"] . $str)
                        );
                        $el->Update($arFields["ID"], $arLoadProductArray);
                    }
                }

                $arMorePhoto = array();
                $res = CIBlockElement::GetProperty(
                    $arFields["IBLOCK_ID"],
                    $arFields["ID"],
                    "sort",
                    "asc",
                    array("CODE" => "MORE_PHOTO")
                );
                while ($ob = $res->GetNext()) {
                    if (intval($ob["VALUE"]) > 0) {
                        $arMorePhoto[] = $ob["VALUE"];
                    }
                }
                $arMorePhotoNew = array();

                if (count($arMorePhoto) > 0) {
                    foreach ($arMorePhoto as $photo) {
                        $arPic = CFile::GetFileArray($photo);
                        $str = editPictAndWaterMark($arPic, 1600);
                        $arFile = $str;
                        $arFile["DESCRIPTION"] = $arPic["description"];
                        if ($str) {
                            $arMorePhotoNew[] = CFile::MakeFileArray($_SERVER["DOCUMENT_ROOT"] . $str);
                        }
                    }
                    CIBlockElement::SetPropertyValuesEx($arFields["ID"], $arFields["IBLOCK_ID"], array("MORE_PHOTO" => $arMorePhotoNew));
                }
            }
            self::$handlerDisallow = false;
        }
    }

    function OnAfterIBlockSectionUpdateHandler(&$arFields)
    {
        if ($arFields["IBLOCK_ID"] == StockMan\Config::CATALOG_IBLOCK_ID) {
            if (self::$handlerDisallow)
                return;

            self::$handlerDisallow = true;  //���������

            if ($arFields["RESULT"]) {
                $arFilter = Array(
                    "ID" => $arFields["ID"],
                    array(
                        "LOGIC" => "OR",
                        "!PICTURE" => false,
                        "!DETAIL_PICTURE" => false
                    )
                );
                $arSelect = array(
                    "ID",
                    "IBLOCK_ID",
                    "DETAIL_PICTURE",
                    "PICTURE"
                );
                $res = CIBlockSection::GetList(Array("SORT" => "ASC", "ID" => "ASC"), $arFilter, false, $arSelect);
                while ($ar_fields = $res->GetNext()) {
                    if (intval($ar_fields["DETAIL_PICTURE"]) > 0) {
                        $arPic = CFile::GetFileArray($ar_fields["DETAIL_PICTURE"]);
                        $str = editPictAndWaterMark($arPic, 1000);
                        if ($str) {
                            $sec = new CIBlockSection;
                            $arLoadProductArray = Array(
                                "DETAIL_PICTURE" => CFile::MakeFileArray($_SERVER["DOCUMENT_ROOT"] . $str)
                            );
                            $sec->Update($arFields["ID"], $arLoadProductArray);
                        }
                    }
                    if (intval($ar_fields["PICTURE"]) > 0) {
                        $arPic = CFile::GetFileArray($ar_fields["PICTURE"]);
                        $str = editPictAndWaterMark($arPic, 1000);
                        if ($str) {
                            $sec = new CIBlockSection;
                            $arLoadProductArray = Array(
                                "PICTURE" => CFile::MakeFileArray($_SERVER["DOCUMENT_ROOT"] . $str)
                            );
                            $sec->Update($arFields["ID"], $arLoadProductArray);
                        }
                    }
                }
            }

            self::$handlerDisallow = false;
        }
    }
*/
}