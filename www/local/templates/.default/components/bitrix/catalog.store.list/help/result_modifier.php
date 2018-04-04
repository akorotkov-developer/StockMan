<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

$arStores = array();
foreach($arResult["STORES"] as $arStore) {
    if (in_array($arStore["ID"],StockMan\Config::$arIdStore)) {
        $arPic = $arStore["DETAIL_IMG"];
        $width = 250;
        $height = 250;
        if ($arPic) {
            if ($arPic["WIDTH"] <= $width) {
                $width = $arPic["WIDTH"] - 1;
            }
            if ($arPic["HEIGHT"] <= $height) {
                $height = $arPic["HEIGHT"] - 1;
            }

            $arPicRes = CFile::ResizeImageGet(
                $arPic,
                array("width" => $width, "height" => $height),
                BX_RESIZE_IMAGE_PROPORTIONAL ,
                true,
                false,
                false,
                75
            );
            $arStore["DETAIL_IMG"]["SRC"] = $arPicRes["src"];
        }

        $arStores[] = $arStore;
    }
}
$arResult["STORES"] = $arStores;