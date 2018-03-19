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
$arOffersIdProduct = array();
$arProductIdOffers = array();
foreach ($arResult["GRID"]["ROWS"] as $k => $arItem) {
    //if ($arItem['IBLOCK_ID'] != StockMan\Config::CATALOG_ID) {
        $id = $arItem["PRODUCT_ID"];
        $mxResult = CCatalogSku::GetProductInfo(
            $id
        );
        if (intval($mxResult["ID"]) > 0) {
            $id = $mxResult["ID"];
        }

        $arProductsId[] = $id;
        $arProductIdOffers[$id] = $arItem["PRODUCT_ID"];
        $arOffersIdProduct[$arItem["PRODUCT_ID"]] = $id;
    //}
}

$arProducts = getDetailInfoProduct($arProductsId, $arProductIdOffers);

$arRes = array();
foreach ($arOffersIdProduct as $k => $arItem) {
    $arRes[$k] = $arProducts[$arProductIdOffers[$arItem]];
}
$arProducts = $arRes;
$arResult["PROD_OFFERS"] = $arProducts;
$this->__component->SetResultCacheKeys(array(
    "PROD_OFFERS"
));

foreach ($arResult["GRID"]["ROWS"] as $k => $arItem) {
    if (!isset($arItem['DETAIL_PAGE_URL']{1})) {
        $arResult["GRID"]["ROWS"][$k]['DETAIL_PAGE_URL'] = $arProducts[$arItem['PRODUCT_ID']]['url'];
    }
}