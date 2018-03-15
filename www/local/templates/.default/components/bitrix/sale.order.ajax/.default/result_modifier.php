<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

/**
 * @var array $arParams
 * @var array $arResult
 * @var SaleOrderAjax $component
 */

$component = $this->__component;
$component::scaleImages($arResult['JS_DATA'], $arParams['SERVICES_IMAGES_SCALING']);

foreach ($arResult["JS_DATA"]['GRID']['ROWS'] as $key=>$val) {
    $id = $val["data"]["PRODUCT_ID"];
    $tsvet = getTsvetProduct($id);

    if (isset($tsvet{1})) {
        $arTsvet = array(
            "CODE" => ImportStokMan::$CODE_PROPERTYY_TSVET,
            "VALUE" => $tsvet,
            "SORT" => 0,
            "NAME" => ImportStokMan::$NAME_PROPERTYY_TSVET
        );
        $arResult["JS_DATA"]['GRID']['ROWS'][$key]['data']['PROPS'][] = $arTsvet;
    }
}
