<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
/** @var CBitrixComponentTemplate $this */
/** @var array $arParams */
/** @var array $arResult */
use Bitrix\Main;

$defaultParams = array(
	'TEMPLATE_THEME' => 'blue'
);
$arParams = array_merge($defaultParams, $arParams);
unset($defaultParams);

$arParams['TEMPLATE_THEME'] = (string)($arParams['TEMPLATE_THEME']);
if ('' != $arParams['TEMPLATE_THEME'])
{
	$arParams['TEMPLATE_THEME'] = preg_replace('/[^a-zA-Z0-9_\-\(\)\!]/', '', $arParams['TEMPLATE_THEME']);
	if ('site' == $arParams['TEMPLATE_THEME'])
	{
		$templateId = (string)Main\Config\Option::get('main', 'wizard_template_id', 'eshop_bootstrap', SITE_ID);
		$templateId = (preg_match("/^eshop_adapt/", $templateId)) ? 'eshop_adapt' : $templateId;
		$arParams['TEMPLATE_THEME'] = (string)Main\Config\Option::get('main', 'wizard_'.$templateId.'_theme_id', 'blue', SITE_ID);
	}
	if ('' != $arParams['TEMPLATE_THEME'])
	{
		if (!is_file($_SERVER['DOCUMENT_ROOT'].$this->GetFolder().'/themes/'.$arParams['TEMPLATE_THEME'].'/style.css'))
			$arParams['TEMPLATE_THEME'] = '';
	}
}
if ('' == $arParams['TEMPLATE_THEME'])
	$arParams['TEMPLATE_THEME'] = 'blue';

$arProductsId = array();
$arProductIdOffers = array();
$idIBLOCKOFFERS = 0;
foreach ($arResult["GRID"]["ROWS"] as $k => $arItem) {
    if ($arItem['IBLOCK_ID'] != StockMan\Config::CATALOG_ID) {
        $idIBLOCKOFFERS = $arItem['IBLOCK_ID'];
        $mxResult = CCatalogSku::GetProductInfo(
            $arItem["PRODUCT_ID"]
        );

        $arProductsId[$arItem["PRODUCT_ID"]] = $mxResult["ID"];
        $arProductIdOffers[$mxResult["ID"]] = $arItem["PRODUCT_ID"];
    }
}

$arProducts = array();
if ($idIBLOCKOFFERS > 0 ){
    $arFilter = Array(
        "IBLOCK_ID" => StockMan\Config::CATALOG_ID,
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
        $resP = CIBlockElement::GetProperty(StockMan\Config::CATALOG_ID, $ar_fields["ID"], "sort", "asc", array("CODE" => "TSVET"));
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
$arResult["PROD_OFFERS"] = $arProducts;
$this->__component->SetResultCacheKeys(array(
    "PROD_OFFERS"
));


foreach ($arResult["GRID"]["ROWS"] as $k => $arItem) {
    if (!isset($arItem['DETAIL_PAGE_URL']{1})) {
        $arResult["GRID"]["ROWS"][$k]['DETAIL_PAGE_URL'] = $arProducts[$arItem['PRODUCT_ID']]['url'];
    }
}