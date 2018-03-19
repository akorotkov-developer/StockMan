<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

if (0 < $arResult['SECTIONS_COUNT'])
{
    foreach ($arResult['SECTIONS'] as $key => $arSection)
    {
        if (false !== $arSection['PICTURE']) {
            $WIDTH = 400;
            $HEIGHT = 512;

            if ($arSection["PICTURE"]["WIDTH"] <= $WIDTH) {
                $WIDTH = $arSection["PICTURE"]["WIDTH"]-1;
            }
            if ($arSection["PICTURE"]["HEIGHT"] <= $HEIGHT) {
                $HEIGHT = $arSection["PICTURE"]["HEIGHT"]-1;
            }
            $arFileTmp = CFile::ResizeImageGet(
                $arSection["PICTURE"],
                array("width" => $WIDTH, "height" => $HEIGHT),
                BX_RESIZE_IMAGE_EXACT,
                true,
                false,
                false,
                70
            );
            $arResult['SECTIONS'][$key]["PICTURE"]["SRC"] = $arFileTmp["src"];
        }
    }
}