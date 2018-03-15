<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
$arIDCommets = array();
$arID = array();
$width = 1200;
$height = 600;
if ($arResult["DETAIL_PICTURE"]) {
    if ($arResult["DETAIL_PICTURE"]["WIDTH"] <= $width) {
        $width = $arResult["DETAIL_PICTURE"]["WIDTH"]-1;
    }
    if ($arResult["DETAIL_PICTURE"]["HEIGHT"] <= $height) {
        $height = $arResult["DETAIL_PICTURE"]["HEIGHT"]-1;
    }
    $arResult["IMG_SMALL"] = CFile::ResizeImageGet(
        $arResult["DETAIL_PICTURE"],
        array("width" => $width, "height" => $height),
        BX_RESIZE_IMAGE_PROPORTIONAL_ALT,
        true,
        false,
        false,
        75
    );
    $this->__component->SetResultCacheKeys(array("IMG_SMALL"));
}