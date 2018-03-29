<?php
function cl() {
    if ($GLOBALS['USER']->IsAdmin())
    {
        $args = func_get_args();
        echo "<pre>";
        foreach ($args as $ar)
            print_r($ar);
        echo "</pre>";
    }
}
/**
 * Получить раздел для фильтра в главном меню "Новинки" == раздел "Одежда"
 */
if (!function_exists('getMainMenuSectionNovinka')) {
    function getMainMenuSectionNovinka($idMainSection)
    {
        $idMenuSectionNovinka = 0;
        switch ($idMainSection) {
            case 23:
                $idMenuSectionNovinka = 26;
                break;
            case 24:
                $idMenuSectionNovinka = 111;
                break;
            case 25:
                $idMenuSectionNovinka = 181;
                break;
        }
        return $idMenuSectionNovinka;
    }
}
/**
 * Получаем DETAIL_PAGE_URL и TSVET - товара по торговому предложению
 * $arProductsId - массив id торговых предложений
 * $arProductIdOffers - массив [#ID_Товар#] = #ID_торговоеПредложение#
 */
if (!function_exists('getDetailInfoProduct')) {
    function getDetailInfoProduct($arProductsId, $arProductIdOffers)
    {
        $arProducts = array();
        if (count($arProductsId) > 0 ){
            $arFilter = Array(
                //"IBLOCK_ID" => StockMan\Config::CATALOG_ID,
                "ACTIVE"=>"Y",
                "ID" => $arProductsId
            );
            $arSelect = array(
                "IBLOCK_ID",
                "ID",
                "DETAIL_PAGE_URL"
            );
            $res = CIBlockElement::GetList(Array("ID"=>"ASC"), $arFilter, false, false, $arSelect);
            while($ar_fields = $res->GetNext()) {
                $arProductsTemp = array();
                $resP = CIBlockElement::GetProperty(StockMan\Config::CATALOG_ID, $ar_fields["ID"], "sort", "asc", array("CODE" => ImportStokMan::$CODE_PROPERTYY_TSVET));
                if ($ob = $resP->GetNext())
                {
                    $arProp = CIBlockFormatProperties::GetDisplayValue($ar_fields, $ob);
                    $arProductsTemp['prop']['name'] = $arProp['NAME'];
                    $arProductsTemp['prop']['val'] = $arProp['DISPLAY_VALUE'];
                }

                $arProductsTemp['url'] = $ar_fields['DETAIL_PAGE_URL'];
                $arProducts[$arProductIdOffers[$ar_fields['ID']]] = $arProductsTemp;
                unset($arProductsTemp);
            }
        }
        return $arProducts;
    }
}

//Получить ID_секции элемента по коду
function GetSectionIDbyElementCODE($ELEMENT_CODE, $SECTION_CODE){
    $id = CIBlockFindTools::GetElementID("", $ELEMENT_CODE, "", $SECTION_CODE, "");

    $arSelect = Array("ID", "NAME", "IBLOCK_SECTION_ID");
    $arFilter = Array("IBLOCK_ID"=>StockMan\Config::CATALOG_ID, "ID"=>$id, "ACTIVE"=>"Y");
    $res = CIBlockElement::GetList(Array("PROPERTY_rating"=>"DESC"), $arFilter, false, Array("nPageSize"=>50), $arSelect);

    $ob = $res->GetNextElement();
    $arFields = $ob->GetFields();
    return $arFields["IBLOCK_SECTION_ID"];
}

//Получить корневой каталог для Меню
function GetParrentCatalogForMenu($SECTION_ID) {
    $p = $SECTION_ID;
    $treeofSections = array();
    $treeofSections[] = $p;
    while (!is_null($p)) {
        $res = CIBlockSection::GetByID($p);
        if ($ar_res = $res->GetNext()) {
            $p = $ar_res['IBLOCK_SECTION_ID'];
            $treeofSections[] = $ar_res['IBLOCK_SECTION_ID'];
        }
    }
    array_pop($treeofSections);
    return end($treeofSections);
}
//Получить Section_code  по ID секции
function GetSectionCodeBySectionID($ID_SECTION) {
    $arFilter = Array('IBLOCK_ID'=>StockMan\Config::CATALOG_ID, "ID" => $ID_SECTION);
    $db_list = CIBlockSection::GetList(array(), $arFilter, true, array("CODE"));

    while($ar_result = $db_list->GetNext())
    {
        $sectionCode = $ar_result["CODE"];
    }
    return $sectionCode;
}

//Сохраняем ID Корневой секции в сессию
function SaveIdCatalogSection($ID_SECTION) {
    global $APPLICATION;
    //$APPLICATION->set_cookie("CATALOG_SECTION", $ID_SECTION, time()+60*60*24*30*12*2);
    $_SESSION['CATLOG_SECTION'] = $ID_SECTION;
}
function GetHomeCtalogSection() {
    global $APPLICATION;
    //$CATALOG_SECTION = $APPLICATION->get_cookie("CATALOG_SECTION");
    $CATALOG_SECTION = $_SESSION['CATLOG_SECTION'];
    if (!$CATALOG_SECTION) {
        return StockMan\Config::CATALOG_HOME_SECTION_ID;
    } else {
        return $CATALOG_SECTION;
    }
}
function GetIdSectionCatalog($ID_CURRENT_SECTION) {
    $p = $ID_CURRENT_SECTION;
    $treeofSections = array();
    $treeofSections[] = $p;
    while (!is_null($p)) {
        $res = CIBlockSection::GetByID($p);
        if ($ar_res = $res->GetNext()) {
            $p = $ar_res['IBLOCK_SECTION_ID'];
            $treeofSections[] = $ar_res['IBLOCK_SECTION_ID'];
        }
    }
    array_pop($treeofSections);
    $_SESSION['CurrentSectionCatalog'] = end($treeofSections);

    SaveIdCatalogSection(end($treeofSections));
    return end($treeofSections);
}

/**
 * Получаем значение свойства TSVET - товара по торговому предложению
 */
if (!function_exists('getTsvetProduct')) {
    function getTsvetProduct($id)
    {
        $return = '';
        $mxResult = CCatalogSku::GetProductInfo($id);
        if (intval($mxResult["ID"]) > 0) {
            $id = $mxResult["ID"];
        }
        $resP = CIBlockElement::GetProperty(StockMan\Config::CATALOG_ID, $id, "sort", "asc", array("CODE" => ImportStokMan::$CODE_PROPERTYY_TSVET));
        if ($ob = $resP->GetNext())
        {
            $ar_fields = array(
                "ID" => $id,
                "IBLOCK_ID" => StockMan\Config::CATALOG_ID
            );
            $arProp = CIBlockFormatProperties::GetDisplayValue($ar_fields, $ob);
            if (isset($arProp["DISPLAY_VALUE"]{1})) {
                $return = htmlspecialcharsbx($arProp["DISPLAY_VALUE"]);
            }
        }
        return $return;
    }
}

/**
 * Переводит cтроку из кодировки $sFromEncoding в UTF-8
 *
 * @param string $sStr - строка, которую необходимо перевести в другую кодировку
 * @param string $sFromEncoding - Начальная кодировка, в которой находится строка, по умолчанию CP1251
 *
 * @return возвращает строку в UTF-8
 */
if (!function_exists('ToUtf')) {
    function ToUtf($sStr, $sFromEncoding = "CP1251")
    {
        return iconv($sFromEncoding, 'UTF-8' , $sStr);
    }
}

/**
 * Проверка - выводить кнокпи для покупки
 */
if (!function_exists('showBasketButton')) {
    function showBasketButton()
    {
        if (StockMan\Config::SHOW_BASKET_BUTTON_UNAUTHORIZED) {
            return true;
        }
        else {
            global $USER;
            if ($USER->IsAuthorized()){
                return true;
            }else{
                return false;
            }
        }
    }
}

/**
 * Текст, если покупка не разрешена
 */
if (!function_exists('showTextNoBasketButton')) {
    function showTextNoBasketButton()
    {
        global $APPLICATION;
        echo '<p>Для покупки вам необходимо <a href="'.StockMan\Config::AUTH_URL.'&backurl='.$APPLICATION->GetCurPageParam().'"><b>Войти</b></a> или <a href="'.StockMan\Config::REGISTER_URL.'&backurl='.$APPLICATION->GetCurPageParam().'"><b>Зарегистрироваться</b></a></p>';
    }
}

/**
 * Проверка - элемент каталога или нет, для вывода заголовка h1
 */
if (!function_exists('isElementCatalog')) {
    function isElementCatalog()
    {
        global $APPLICATION;
        $page = $APPLICATION->GetCurPage();
        $strPosCatalog = strpos($page, StockMan\Config::CATALOG_URL);
        $flag = false;
        if (($strPosCatalog !== false)and($page != StockMan\Config::CATALOG_URL)) {
            CModule::IncludeModule("iblock");
            $arPage = explode("/",$page);
            $strCode = $arPage[count($arPage)-2];
            $arFilter = Array(
                "IBLOCK_ID" => StockMan\Config::CATALOG_IBLOCK_ID,
                "ACTIVE"=>"Y",
                "ACTIVE_DATE"=>"Y",
                "CODE" => $strCode
            );
            $arSelect = array(
                "ID",
                "IBLOCK_ID",
                "DETAIL_PAGE_URL"
            );
            $res = CIBlockElement::GetList(Array("SORT"=>"ASC", "PROPERTY_PRIORITY"=>"ASC"), $arFilter, false, array("nTopCount"=>1),$arSelect);
            while($ar_fields = $res->GetNext()) {
                if ($ar_fields["DETAIL_PAGE_URL"] == $page) {
                    $flag = true;
                }
            }
        }
        return $flag;
    }
}

/**
 * Наложение водяного знака + переименование для SEO
 *
 * @param $imagePath - относительный путь до изображения
 * @param $watermarkPath - относительный путь до изображения водяного знака
 * @param $newFileName - новый путь
 * @return bool
 */
if (!function_exists('addWaterMark')) {
    function addWaterMark($imagePath, $watermarkPath, $newFileName) {
        // создаём водяной знак
        $getimagesizewatermark = getimagesize($_SERVER['DOCUMENT_ROOT'] . $watermarkPath);

        if ($getimagesizewatermark['mime'] == 'image/png')
            $watermark = imagecreatefrompng($_SERVER['DOCUMENT_ROOT'] . $watermarkPath);
        else
            $watermark = imagecreatefromjpeg($_SERVER['DOCUMENT_ROOT'] . $watermarkPath);

        $fullImagePath = $_SERVER['DOCUMENT_ROOT'].$imagePath;

        try {
            $getimagesize = getimagesize($fullImagePath);
            if ($getimagesize['mime'] == 'image/png')
                $image = imagecreatefrompng($fullImagePath);
            else
                $image = imagecreatefromjpeg($fullImagePath);
        }
        catch(Exception $ex) {
            return false;
        }

        if(!$image)
            return false;

        $sx = imagesx($watermark);
        $sy = imagesy($watermark);
        imageAlphaBlending($image, true);
        imageSaveAlpha($image, true);
        // создаём новое изображение
        imagecopy($image, $watermark, (imagesx($image) - $sx)/2, (imagesy($image) - $sy)/2, 0, 0, imagesx($watermark), imagesy($watermark));
        imagepng($image, $newFileName);
        // освобождаем память
        imagedestroy($image);
        imagedestroy($watermark);
        return true;
    }
}

if (!function_exists('editPictAndWaterMark')) {
    function editPictAndWaterMark($arPic = array(), $setWidthHeight = 270, $resizeType = BX_RESIZE_IMAGE_PROPORTIONAL_ALT, $jpgQuality = false)
    {
        $return = false;
        if ($resizeType !== BX_RESIZE_IMAGE_EXACT && $resizeType !== BX_RESIZE_IMAGE_PROPORTIONAL_ALT)
            $resizeType = BX_RESIZE_IMAGE_PROPORTIONAL_ALT;

        if($jpgQuality <= 0 || $jpgQuality > 100)
            $jpgQuality = 75;
        $flag500 = false;
        if ($arPic["WIDTH"] != $arPic["HEIGHT"])
        {
            $flag500 = true;
        }
        if (
            ($arPic["WIDTH"] == $arPic["HEIGHT"])
            and
            ($arPic["WIDTH"] < 500)
        ) {
            $flag500 = true;
        }
        if (
            (isset($arPic))
            and
            (is_array($arPic))
            and
            (intval($arPic["ID"]) > 0)
            and
            (intval($arPic["WIDTH"]) > 0)
            and
            (intval($arPic["HEIGHT"]) > 0)
            and
            (strlen($arPic["SRC"]) > 0)
            and
            ($flag500)
        ) {
            if (($arPic["WIDTH"] < $setWidthHeight) and ($arPic["HEIGHT"] < $setWidthHeight)) {
                $setWidthHeightTemp = $arPic["WIDTH"] - 1;
                if ($setWidthHeightTemp < $arPic["HEIGHT"]) {
                    $setWidthHeightTemp = $arPic["HEIGHT"] - 1;
                }

                if ($setWidthHeightTemp < 500) {
                    $setWidthHeight = 500;
                } elseif($setWidthHeightTemp < 800) {
                    $setWidthHeight = 800;
                } elseif ($setWidthHeightTemp < 1000) {
                    $setWidthHeight = 1000;
                } elseif ($setWidthHeightTemp < 1200) {
                    $setWidthHeight = 1200;
                } elseif ($setWidthHeightTemp < 1400) {
                    $setWidthHeight = 1400;
                } elseif ($setWidthHeightTemp < 1600) {
                    $setWidthHeight = 1600;
                }
                $arFileTmp = CFile::ResizeImageGet(
                    $arPic,
                    array("width" => $setWidthHeightTemp, "height" => $setWidthHeightTemp),
                    $resizeType,
                    false,
                    false,
                    false,
                    $jpgQuality
                );
                $watermarkPath = $arFileTmp["src"];
                $arTranslitParams = array(
                    "max_len" => "150",
                    "change_case" => "L",
                    "replace_space" => "-",
                    "replace_other" => "-",
                    "delete_repeat_replace" => "true",
                    "use_google" => "false",
                );

                $imgType = '.jpg';
                $pos = strpos($arPic["FILE_NAME"], '.');
                if ($pos === false) {} else {
                    $imgType = substr($arPic["FILE_NAME"], $pos);
                }

                $fileName = CUtil::translit(str_replace("/upload/iblock/","",$arPic["SRC"]), "ru", $arTranslitParams);
                $imagePath = StockMan\Config::STOCKMAN_TEMPLATE_PATH . '/images/watermark/fon_white_' . $setWidthHeight . '.jpg';
                $newName = '/upload/resize_cache/cetera_catalog/' . $fileName . '-' . $setWidthHeight . $imgType;

                $newFileName = $_SERVER['DOCUMENT_ROOT'] . $newName;

                if (CFile::ResizeImageFile(
                    $_SERVER['DOCUMENT_ROOT'] . $imagePath,
                    $newFileName,
                    array('width'=>$setWidthHeight, 'height'=>$setWidthHeight),
                    $resizeType,
                    array(
                        "type" => "image",
                        "size" => "real",
                        "name" => "watermark",
                        "position" => "center",
                        "file" =>  $_SERVER['DOCUMENT_ROOT'] . $watermarkPath
                    ),
                    $jpgQuality
                )) {
                    file_put_contents($_SERVER['DOCUMENT_ROOT'] . $watermarkPath, file_get_contents($newFileName));
                    //unlink($newFileName);
                    $return = $watermarkPath;
                }
            } else {
                $arFileTmp = CFile::ResizeImageGet(
                    $arPic,
                    array("width" => $setWidthHeight, "height" => $setWidthHeight),
                    $resizeType,
                    false,
                    false,
                    false,
                    $jpgQuality
                );
                $watermarkPath = $arFileTmp["src"];

                $arTranslitParams = array(
                    "max_len" => "150",
                    "change_case" => "L",
                    "replace_space" => "-",
                    "replace_other" => "-",
                    "delete_repeat_replace" => "true",
                    "use_google" => "false",
                );

                $imgType = '.jpg';
                $pos = strpos($arPic["FILE_NAME"], '.');
                if ($pos === false) {} else {
                    $imgType = substr($arPic["FILE_NAME"], $pos);
                }

                $fileName = CUtil::translit(str_replace("/upload/iblock/","",$arPic["SRC"]), "ru", $arTranslitParams);
                $imagePath = StockMan\Config::STOCKMAN_TEMPLATE_PATH . '/images/watermark/fon_white_' . $setWidthHeight . '.jpg';
                $newName = '/upload/resize_cache/cetera_catalog/' . $fileName . '-' . $setWidthHeight . $imgType;

                $newFileName = $_SERVER['DOCUMENT_ROOT'] . $newName;

                if (CFile::ResizeImageFile(
                    $_SERVER['DOCUMENT_ROOT'] . $imagePath,
                    $newFileName,
                    array('width'=>$setWidthHeight, 'height'=>$setWidthHeight),
                    $resizeType,
                    array(
                        "type" => "image",
                        "size" => "real",
                        "name" => "watermark",
                        "position" => "center",
                        "file" =>  $_SERVER['DOCUMENT_ROOT'] . $watermarkPath
                    ),
                    $jpgQuality
                )) {
                    file_put_contents($_SERVER['DOCUMENT_ROOT'] . $watermarkPath, file_get_contents($newFileName));
                    //unlink($newFileName);
                    $return = $watermarkPath;
                }
            }
        }
        return $return;
    }
}

/*Получить Артикул Торгового предложения*/
function GetArticulOfferByID($ITEM_ID) {
    $IBLOCK_ID = StockMan\Config::CATALOG_OFFERS;
    $ID = $ITEM_ID;

        $articul = "";
        $rsOffers = CIBlockElement::GetList(array('PROPERTY_CML2_ARTICLE'), array('IBLOCK_ID' => $IBLOCK_ID, 'ID'=>$ID), array('PROPERTY_CML2_ARTICLE'));
        while ($arOffer = $rsOffers->GetNext()) {
            $articul = $arOffer;
        }

    return $articul;
}
/*--------------------------------------*/

/*Получить предыдущий и следующий элементы каталога*/
function GetPrevNextElements($ID_ElEMENT, $SECTION_ID) {

    // сортировку берем из параметров компонента
    $arSort = array(
        "ASC",
        "ASC"
    );
    // выбрать нужно id элемента, его имя и ссылку
    $arSelect = array(
        "ID",
        "NAME",
        "DETAIL_PAGE_URL"
    );
    // выбираем активные элементы из нужного инфоблока
    $arFilter = array (
        "IBLOCK_ID" => StockMan\Config::CATALOG_ID,
        "SECTION_ID" => $SECTION_ID,
        "ACTIVE" => "Y",
        "CHECK_PERMISSIONS" => "Y",
    );
    // выбирать будем по 1 соседу с каждой стороны от текущего
    $arNavParams = array(
        "nPageSize" => 1,
        "nElementID" => $ID_ElEMENT,
    );

    $arItems = Array();
    $rsElement = CIBlockElement::GetList($arSort, $arFilter, false, $arNavParams, $arSelect);
    $rsElement->SetUrlTemplates($arParams["DETAIL_URL"]);
    while($obElement = $rsElement->GetNextElement())
        $arItems[] = $obElement->GetFields();

    return $arItems;
}
/*-------------------------------------------------*/

/*Получить список рубрик для подписок*/
function GetRubrics() {
    CModule::IncludeModule("subscribe");
    // Вывод рубрик можно производить таким способом
    $arOrder = Array("SORT"=>"ASC", "NAME"=>"ASC");
    $arFilter = Array("ACTIVE"=>"Y", "LID"=>LANG);
    $rsRubric = CRubric::GetList($arOrder, $arFilter);
    $arRubrics = array();
    while($arRubric = $rsRubric->GetNext())
    {
        $arRunrics[] = $arRubric;
    }
    return $arRunrics;
}
/*-----------------------------------*/

/*Получить кол-во отложенных товаров в корзине*/
function GetCountDeferred() {
    $delaydBasketItems = CSaleBasket::GetList(
        array(),
        array(
            "FUSER_ID" => CSaleBasket::GetBasketUserID(),
            "LID" => SITE_ID,
            "ORDER_ID" => "NULL",
            "DELAY" => "Y"
        ),
        array()
    );
    return $delaydBasketItems;
}
/*--------------------------------------------*/


/*Получить ссылку на детальную страницу в корзине*/
function getDetailPageUrlinBasket($PRODUCT_ID) {
    $intElementID = $PRODUCT_ID; // ID предложения
    $mxResult = CCatalogSku::GetProductInfo($intElementID);


    $res = CIBlockElement::GetByID($mxResult["ID"]);
    if($ar_res = $res->GetNext()) {
        $detailpage = $ar_res['DETAIL_PAGE_URL'];
    }
    return $detailpage;
}
/*-----------------------------------------------*/

/*Получить цвет*/
function getColorProduct($PRODUCT_ID) {
    //Получаем ID Товара
    $intElementID = $PRODUCT_ID; // ID предложения
    $mxResult = CCatalogSku::GetProductInfo($intElementID);

    $arSelect = Array(
        'ID',
        'NAME',
        'IBLOCK_ID',
        'PROPERTY_TSVET',
    );

    $arFilter = Array("IBLOCK_ID" => StockMan\Config::CATALOG_ID, "=ID" => $mxResult["ID"]);

    $res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
    while($rs = $res->Fetch())
    {
        $list = $rs; //Список элементов

    }


    CModule::IncludeModule('highloadblock'); //модуль highload инфоблоков
    $rsData = \Bitrix\Highloadblock\HighloadBlockTable::getList(array('filter'=>array('ID'=>92)));
    if ( !($hldata = $rsData->fetch()) ){

    }
    else{
        $hlentity = \Bitrix\Highloadblock\HighloadBlockTable::compileEntity($hldata);
        $hlDataClass = $hldata['NAME'].'Table';
        $res = $hlDataClass::getList(array(
                'filter' => array(
                    'UF_XML_ID' => $list["PROPERTY_TSVET_VALUE"],
                ),
                'select' => array("*"),
                'order' => array(
                    'UF_NAME' => 'asc'
                ),
            )
        );
        if ($row = $res->fetch()) {
            $HLinfo =$row;
        }

    }

    return ($HLinfo["UF_NAME"]);
}
/*-------------*/