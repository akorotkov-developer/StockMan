<?php
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