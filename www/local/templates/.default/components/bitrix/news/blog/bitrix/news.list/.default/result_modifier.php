<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
$arIDCommets = array();
foreach ($arResult["ITEMS"] as $key => $val) {
    $width = 500;
    $height = 650;
    if ($val["PREVIEW_PICTURE"]) {
        if ($val["PREVIEW_PICTURE"]["WIDTH"] <= $width) {
            $width = $val["PREVIEW_PICTURE"]["WIDTH"]-1;
        }
        if ($val["PREVIEW_PICTURE"]["HEIGHT"] <= $height) {
            $height = $val["PREVIEW_PICTURE"]["HEIGHT"]-1;
        }

        $arResult["ITEMS"][$key]["IMG_SMALL"] = CFile::ResizeImageGet(
            $val["PREVIEW_PICTURE"],
            array("width" => $width, "height" => $height),
            BX_RESIZE_IMAGE_PROPORTIONAL_ALT,
            true,
            false,
            false,
            75
        );
    }
    elseif ($val["DETAIL_PICTURE"]) {
        if ($val["DETAIL_PICTURE"]["WIDTH"] <= $width) {
            $width = $val["DETAIL_PICTURE"]["WIDTH"]-1;
        }
        if ($val["DETAIL_PICTURE"]["HEIGHT"] <= $height) {
            $height = $val["DETAIL_PICTURE"]["HEIGHT"]-1;
        }

        $arResult["ITEMS"][$key]["IMG_SMALL"] = CFile::ResizeImageGet(
            $val["DETAIL_PICTURE"],
            array("width" => $width, "height" => $height),
            BX_RESIZE_IMAGE_PROPORTIONAL_ALT,
            true,
            false,
            false,
            75
        );
    }

    $arResult["ITEMS"][$key]["DATE_ACTIVE_FROM"] =  ConvertDateTime($val["DATE_ACTIVE_FROM"], "DD", "ru") . " " . StockMan\Config::$monthsRus[intVal(ConvertDateTime($val["DATE_ACTIVE_FROM"], "MM", "ru"))];
}