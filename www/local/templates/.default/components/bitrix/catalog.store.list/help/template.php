<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
if(strlen($arResult["ERROR_MESSAGE"])>0)
	ShowError($arResult["ERROR_MESSAGE"]);
$arPlacemarks = array();
$gpsN = '';
$gpsS = '';

if(is_array($arResult["STORES"]) && !empty($arResult["STORES"])) {
    ?>
    <? foreach ($arResult["STORES"] as $pid => $arProperty) {
            if ($arProperty["GPS_S"] != 0 && $arProperty["GPS_N"] != 0) {
                $gpsN = substr(doubleval($arProperty["GPS_N"]), 0, 15);
                $gpsS = substr(doubleval($arProperty["GPS_S"]), 0, 15);
                $arPlacemarks[] = array("LON" => $gpsS, "LAT" => $gpsN, "TEXT" => $arProperty["TITLE"]);
            }
    }

    if ($arResult['VIEW_MAP']) {
        ?><div class="margin-bottom-6"><?
        if ($arResult["MAP"] == 0) {
            $APPLICATION->IncludeComponent("bitrix:map.yandex.view", ".default", array(
                "INIT_MAP_TYPE" => "MAP",
                "MAP_DATA" => serialize(array("yandex_lat" => $gpsN, "yandex_lon" => $gpsS, "yandex_scale" => 12, "PLACEMARKS" => $arPlacemarks)),
                "MAP_WIDTH" => "100%",
                "MAP_HEIGHT" => "500",
                "CONTROLS" => array(
                    0 => "ZOOM",
                ),
                "OPTIONS" => array(
                    0 => "ENABLE_SCROLL_ZOOM",
                    1 => "ENABLE_DBLCLICK_ZOOM",
                    2 => "ENABLE_DRAGGING",
                ),
                "MAP_ID" => ""
            ),
                $component,
                array("HIDE_ICONS" => "Y")
            );
        } else {
            $APPLICATION->IncludeComponent("bitrix:map.google.view", ".default", array(
                "INIT_MAP_TYPE" => "MAP",
                "MAP_DATA" => serialize(array("google_lat" => $gpsN, "google_lon" => $gpsS, "google_scale" => 10, "PLACEMARKS" => $arPlacemarks)),
                "MAP_WIDTH" => "720",
                "MAP_HEIGHT" => "500",
                "CONTROLS" => array(
                    0 => "ZOOM",
                ),
                "OPTIONS" => array(
                    0 => "ENABLE_SCROLL_ZOOM",
                    1 => "ENABLE_DBLCLICK_ZOOM",
                    2 => "ENABLE_DRAGGING",
                ),
                "MAP_ID" => ""
            ),
                $component,
                array("HIDE_ICONS" => "Y")
            );
        }
        ?></div><?
    }
    ?>
    <div class="grid-x grid-padding-x">
        <div class="cell text-center margin-bottom-10">
            <h3 class="margin-bottom-1">Адреса магазинов</h3>
        </div>
    </div>
    <div class="grid-x grid-padding-x"><?
        foreach($arResult["STORES"] as $pid=>$arProperty){?>
            <div class="cell medium-6">
                <div class="grid-x grid-padding-x">
                    <? if(isset($arProperty["DETAIL_IMG"]["SRC"])){?>
                        <div class="cell large-5 large-text-right text-center">
                            <p><img src="<?=$arProperty["DETAIL_IMG"]["SRC"]?>" alt="<?=$arProperty["TITLE"]?>"></p>
                        </div>
                    <?}?>
                    <div class="cell large-7">
                        <div class="margin-bottom-3"><?=$arProperty["TITLE"]?></div>
                        <? if(isset($arProperty["ADDRESS"])){?>
                            <div class="margin-bottom-3">Адрес:<br><?=$arProperty["ADDRESS"]?></div>
                        <?}?>
                        <? if(isset($arProperty["DESCRIPTION"])){?>
                            <div class="margin-bottom-3"><?=$arProperty["DESCRIPTION"]?></div>
                        <?}?>
                        <? if(isset($arProperty["SCHEDULE"])){?>
                            <div class="grid-x grid-padding-x">
                                <div class="cell medium-12"><?=GetMessage('S_SCHEDULE')?></div>
                                <div class="cell medium-12"><?=$arProperty["SCHEDULE"]?></div>
                            </div>
                        <?}?>
                        <? if(isset($arProperty["PHONE"])){?>
                            <div class="grid-x grid-padding-x">
                                <div class="cell medium-12"><?=GetMessage('S_PHONE')?></div>
                                <div class="cell medium-12"><?=$arProperty["PHONE"]?></div>
                            </div>
                        <?}?>
                    </div>
                </div>
            </div>
        <?}
    ?></div><?
}
?>