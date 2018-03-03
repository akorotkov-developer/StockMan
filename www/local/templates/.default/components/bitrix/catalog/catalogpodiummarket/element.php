<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
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
use Bitrix\Main\Loader;
use Bitrix\Main\ModuleManager;

$this->setFrameMode(true);
?>
<?
$this->SetViewTarget('catalog_element');
echo "padding-top-5";
$this->EndViewTarget();
?>

<?$APPLICATION->IncludeComponent("bitrix:breadcrumb","",Array(
        "START_FROM" => "0",
        "PATH" => "",
        "SITE_ID" => StockMan\Config::SITE_ID
    )
);?>

<?
if (isset($arParams['USE_COMMON_SETTINGS_BASKET_POPUP']) && $arParams['USE_COMMON_SETTINGS_BASKET_POPUP'] == 'Y')
{
	$basketAction = (isset($arParams['COMMON_ADD_TO_BASKET_ACTION']) ? array($arParams['COMMON_ADD_TO_BASKET_ACTION']) : array());
}
else
{
	$basketAction = (isset($arParams['DETAIL_ADD_TO_BASKET_ACTION']) ? $arParams['DETAIL_ADD_TO_BASKET_ACTION'] : array());
}
?><?$ElementID = $APPLICATION->IncludeComponent(
	"bitrix:catalog.element",
	"podiummarket_element",
	array(
		"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
		"IBLOCK_ID" => $arParams["IBLOCK_ID"],
		"PROPERTY_CODE" => $arParams["DETAIL_PROPERTY_CODE"],
		"META_KEYWORDS" => $arParams["DETAIL_META_KEYWORDS"],
		"META_DESCRIPTION" => $arParams["DETAIL_META_DESCRIPTION"],
		"BROWSER_TITLE" => $arParams["DETAIL_BROWSER_TITLE"],
		"SET_CANONICAL_URL" => $arParams["DETAIL_SET_CANONICAL_URL"],
		"BASKET_URL" => $arParams["BASKET_URL"],
		"ACTION_VARIABLE" => $arParams["ACTION_VARIABLE"],
		"PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
		"SECTION_ID_VARIABLE" => $arParams["SECTION_ID_VARIABLE"],
		"CHECK_SECTION_ID_VARIABLE" => (isset($arParams["DETAIL_CHECK_SECTION_ID_VARIABLE"]) ? $arParams["DETAIL_CHECK_SECTION_ID_VARIABLE"] : ''),
		"PRODUCT_QUANTITY_VARIABLE" => $arParams["PRODUCT_QUANTITY_VARIABLE"],
		"PRODUCT_PROPS_VARIABLE" => $arParams["PRODUCT_PROPS_VARIABLE"],
		"CACHE_TYPE" => $arParams["CACHE_TYPE"],
		"CACHE_TIME" => $arParams["CACHE_TIME"],
		"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
		"SET_TITLE" => $arParams["SET_TITLE"],
		"SET_LAST_MODIFIED" => $arParams["SET_LAST_MODIFIED"],
		"MESSAGE_404" => $arParams["MESSAGE_404"],
		"SET_STATUS_404" => $arParams["SET_STATUS_404"],
		"SHOW_404" => $arParams["SHOW_404"],
		"FILE_404" => $arParams["FILE_404"],
		"PRICE_CODE" => $arParams["PRICE_CODE"],
		"USE_PRICE_COUNT" => $arParams["USE_PRICE_COUNT"],
		"SHOW_PRICE_COUNT" => $arParams["SHOW_PRICE_COUNT"],
		"PRICE_VAT_INCLUDE" => $arParams["PRICE_VAT_INCLUDE"],
		"PRICE_VAT_SHOW_VALUE" => $arParams["PRICE_VAT_SHOW_VALUE"],
		"USE_PRODUCT_QUANTITY" => $arParams['USE_PRODUCT_QUANTITY'],
		"PRODUCT_PROPERTIES" => $arParams["PRODUCT_PROPERTIES"],
		"ADD_PROPERTIES_TO_BASKET" => (isset($arParams["ADD_PROPERTIES_TO_BASKET"]) ? $arParams["ADD_PROPERTIES_TO_BASKET"] : ''),
		"PARTIAL_PRODUCT_PROPERTIES" => (isset($arParams["PARTIAL_PRODUCT_PROPERTIES"]) ? $arParams["PARTIAL_PRODUCT_PROPERTIES"] : ''),
		"LINK_IBLOCK_TYPE" => $arParams["LINK_IBLOCK_TYPE"],
		"LINK_IBLOCK_ID" => $arParams["LINK_IBLOCK_ID"],
		"LINK_PROPERTY_SID" => $arParams["LINK_PROPERTY_SID"],
		"LINK_ELEMENTS_URL" => $arParams["LINK_ELEMENTS_URL"],

		"OFFERS_CART_PROPERTIES" => $arParams["OFFERS_CART_PROPERTIES"],
		"OFFERS_FIELD_CODE" => $arParams["DETAIL_OFFERS_FIELD_CODE"],
		"OFFERS_PROPERTY_CODE" => $arParams["DETAIL_OFFERS_PROPERTY_CODE"],
		"OFFERS_SORT_FIELD" => $arParams["OFFERS_SORT_FIELD"],
		"OFFERS_SORT_ORDER" => $arParams["OFFERS_SORT_ORDER"],
		"OFFERS_SORT_FIELD2" => $arParams["OFFERS_SORT_FIELD2"],
		"OFFERS_SORT_ORDER2" => $arParams["OFFERS_SORT_ORDER2"],

		"ELEMENT_ID" => $arResult["VARIABLES"]["ELEMENT_ID"],
		"ELEMENT_CODE" => $arResult["VARIABLES"]["ELEMENT_CODE"],
		"SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"],
		"SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
		"SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
		"DETAIL_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["element"],
		'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
		'CURRENCY_ID' => $arParams['CURRENCY_ID'],
		'HIDE_NOT_AVAILABLE' => $arParams["HIDE_NOT_AVAILABLE"],
		'USE_ELEMENT_COUNTER' => $arParams['USE_ELEMENT_COUNTER'],
		'SHOW_DEACTIVATED' => $arParams['SHOW_DEACTIVATED'],
		"USE_MAIN_ELEMENT_SECTION" => $arParams["USE_MAIN_ELEMENT_SECTION"],

		'ADD_PICT_PROP' => $arParams['ADD_PICT_PROP'],
		'LABEL_PROP' => $arParams['LABEL_PROP'],
		'OFFER_ADD_PICT_PROP' => $arParams['OFFER_ADD_PICT_PROP'],
		'OFFER_TREE_PROPS' => $arParams['OFFER_TREE_PROPS'],
		'PRODUCT_SUBSCRIPTION' => $arParams['PRODUCT_SUBSCRIPTION'],
		'SHOW_DISCOUNT_PERCENT' => $arParams['SHOW_DISCOUNT_PERCENT'],
		'SHOW_OLD_PRICE' => $arParams['SHOW_OLD_PRICE'],
		'SHOW_MAX_QUANTITY' => $arParams['DETAIL_SHOW_MAX_QUANTITY'],
		'MESS_BTN_BUY' => $arParams['MESS_BTN_BUY'],
		'MESS_BTN_ADD_TO_BASKET' => $arParams['MESS_BTN_ADD_TO_BASKET'],
		'MESS_BTN_SUBSCRIBE' => $arParams['MESS_BTN_SUBSCRIBE'],
		'MESS_BTN_COMPARE' => $arParams['MESS_BTN_COMPARE'],
		'MESS_NOT_AVAILABLE' => $arParams['MESS_NOT_AVAILABLE'],
		'USE_VOTE_RATING' => $arParams['DETAIL_USE_VOTE_RATING'],
		'VOTE_DISPLAY_AS_RATING' => (isset($arParams['DETAIL_VOTE_DISPLAY_AS_RATING']) ? $arParams['DETAIL_VOTE_DISPLAY_AS_RATING'] : ''),
		'USE_COMMENTS' => $arParams['DETAIL_USE_COMMENTS'],
		'BLOG_USE' => (isset($arParams['DETAIL_BLOG_USE']) ? $arParams['DETAIL_BLOG_USE'] : ''),
		'BLOG_URL' => (isset($arParams['DETAIL_BLOG_URL']) ? $arParams['DETAIL_BLOG_URL'] : ''),
		'BLOG_EMAIL_NOTIFY' => (isset($arParams['DETAIL_BLOG_EMAIL_NOTIFY']) ? $arParams['DETAIL_BLOG_EMAIL_NOTIFY'] : ''),
		'VK_USE' => (isset($arParams['DETAIL_VK_USE']) ? $arParams['DETAIL_VK_USE'] : ''),
		'VK_API_ID' => (isset($arParams['DETAIL_VK_API_ID']) ? $arParams['DETAIL_VK_API_ID'] : 'API_ID'),
		'FB_USE' => (isset($arParams['DETAIL_FB_USE']) ? $arParams['DETAIL_FB_USE'] : ''),
		'FB_APP_ID' => (isset($arParams['DETAIL_FB_APP_ID']) ? $arParams['DETAIL_FB_APP_ID'] : ''),
		'BRAND_USE' => (isset($arParams['DETAIL_BRAND_USE']) ? $arParams['DETAIL_BRAND_USE'] : 'N'),
		'BRAND_PROP_CODE' => (isset($arParams['DETAIL_BRAND_PROP_CODE']) ? $arParams['DETAIL_BRAND_PROP_CODE'] : ''),
		'DISPLAY_NAME' => (isset($arParams['DETAIL_DISPLAY_NAME']) ? $arParams['DETAIL_DISPLAY_NAME'] : ''),
		'ADD_DETAIL_TO_SLIDER' => (isset($arParams['DETAIL_ADD_DETAIL_TO_SLIDER']) ? $arParams['DETAIL_ADD_DETAIL_TO_SLIDER'] : ''),
		'TEMPLATE_THEME' => (isset($arParams['TEMPLATE_THEME']) ? $arParams['TEMPLATE_THEME'] : ''),
		"ADD_SECTIONS_CHAIN" => (isset($arParams["ADD_SECTIONS_CHAIN"]) ? $arParams["ADD_SECTIONS_CHAIN"] : ''),
		"ADD_ELEMENT_CHAIN" => (isset($arParams["ADD_ELEMENT_CHAIN"]) ? $arParams["ADD_ELEMENT_CHAIN"] : ''),
		"DISPLAY_PREVIEW_TEXT_MODE" => (isset($arParams['DETAIL_DISPLAY_PREVIEW_TEXT_MODE']) ? $arParams['DETAIL_DISPLAY_PREVIEW_TEXT_MODE'] : ''),
		"DETAIL_PICTURE_MODE" => (isset($arParams['DETAIL_DETAIL_PICTURE_MODE']) ? $arParams['DETAIL_DETAIL_PICTURE_MODE'] : ''),
		'ADD_TO_BASKET_ACTION' => $basketAction,
		'SHOW_CLOSE_POPUP' => isset($arParams['COMMON_SHOW_CLOSE_POPUP']) ? $arParams['COMMON_SHOW_CLOSE_POPUP'] : '',
		'DISPLAY_COMPARE' => (isset($arParams['USE_COMPARE']) ? $arParams['USE_COMPARE'] : ''),
		'COMPARE_PATH' => $arResult['FOLDER'].$arResult['URL_TEMPLATES']['compare'],
		'SHOW_BASIS_PRICE' => (isset($arParams['DETAIL_SHOW_BASIS_PRICE']) ? $arParams['DETAIL_SHOW_BASIS_PRICE'] : 'Y')
	),
	$component
);?><?
$GLOBALS["CATALOG_CURRENT_ELEMENT_ID"] = $ElementID;
unset($basketAction);
if ($ElementID > 0)
{
	if($arParams["USE_STORE"] == "Y" && ModuleManager::isModuleInstalled("catalog"))
	{
		?><?$APPLICATION->IncludeComponent("bitrix:catalog.store.amount", ".default", array(
			"ELEMENT_ID" => $ElementID,
			"STORE_PATH" => $arParams['STORE_PATH'],
			"CACHE_TYPE" => "A",
			"CACHE_TIME" => "36000",
			"MAIN_TITLE" => $arParams['MAIN_TITLE'],
			"USE_MIN_AMOUNT" =>  $arParams['USE_MIN_AMOUNT'],
			"MIN_AMOUNT" => $arParams['MIN_AMOUNT'],
			"STORES" => $arParams['STORES'],
			"SHOW_EMPTY_STORE" => $arParams['SHOW_EMPTY_STORE'],
			"SHOW_GENERAL_STORE_INFORMATION" => $arParams['SHOW_GENERAL_STORE_INFORMATION'],
			"USER_FIELDS" => $arParams['USER_FIELDS'],
			"FIELDS" => $arParams['FIELDS']
		),
		$component,
		array("HIDE_ICONS" => "Y")
	);?><?
	}

	$arRecomData = array();
	$recomCacheID = array('IBLOCK_ID' => $arParams['IBLOCK_ID']);
	$obCache = new CPHPCache();
	if ($obCache->InitCache(36000, serialize($recomCacheID), "/catalog/recommended"))
	{
		$arRecomData = $obCache->GetVars();
	}
	elseif ($obCache->StartDataCache())
	{
		if (Loader::includeModule("catalog"))
		{
			$arSKU = CCatalogSKU::GetInfoByProductIBlock($arParams['IBLOCK_ID']);
			$arRecomData['OFFER_IBLOCK_ID'] = (!empty($arSKU) ? $arSKU['IBLOCK_ID'] : 0);
			$arRecomData['IBLOCK_LINK'] = '';
			$arRecomData['ALL_LINK'] = '';
			$rsProps = CIBlockProperty::GetList(
				array('SORT' => 'ASC', 'ID' => 'ASC'),
				array('IBLOCK_ID' => $arParams['IBLOCK_ID'], 'PROPERTY_TYPE' => 'E', 'ACTIVE' => 'Y')
			);
			$found = false;
			while ($arProp = $rsProps->Fetch())
			{
				if ($found)
				{
					break;
				}
				if ($arProp['CODE'] == '')
				{
					$arProp['CODE'] = $arProp['ID'];
				}
				$arProp['LINK_IBLOCK_ID'] = intval($arProp['LINK_IBLOCK_ID']);
				if ($arProp['LINK_IBLOCK_ID'] != 0 && $arProp['LINK_IBLOCK_ID'] != $arParams['IBLOCK_ID'])
				{
					continue;
				}
				if ($arProp['LINK_IBLOCK_ID'] > 0)
				{
					if ($arRecomData['IBLOCK_LINK'] == '')
					{
						$arRecomData['IBLOCK_LINK'] = $arProp['CODE'];
						$found = true;
					}
				}
				else
				{
					if ($arRecomData['ALL_LINK'] == '')
					{
						$arRecomData['ALL_LINK'] = $arProp['CODE'];
					}
				}
			}
			if ($found)
			{
				if(defined("BX_COMP_MANAGED_CACHE"))
				{
					global $CACHE_MANAGER;
					$CACHE_MANAGER->StartTagCache("/catalog/recommended");
					$CACHE_MANAGER->RegisterTag("iblock_id_".$arParams["IBLOCK_ID"]);
					$CACHE_MANAGER->EndTagCache();
				}
			}
		}
		$obCache->EndDataCache($arRecomData);
	}
	?>







    <div class="grid-container margin-bottom-20">
        <div class="grid-x grid-padding-x">
            <div class="cell">
                <ul class="accordion" data-accordion="" data-allow-all-closed="true">
                    <?/*<li class="accordion-item look is-active" data-accordion-item=""><a class="text-center accordion-title" href="#">На модели</a>
                        <div class="accordion-content" data-tab-content="">
                            <div class="text-center"><a class="button invisible" href="#">Купить весь Look</a></div>
                            <div class="grid-x text-center grid-padding-x small-up-1 medium-up-2 large-up-4 margin-bottom-8" data-equalizer data-equalize-by-row="true">
                                <div class="cell position-relative">
                                    <div class="dress">
                                        <div class="dress__img" data-equalizer-watch><a href="#"> <img src="./i/d2.png" alt=""><img src="./i/d1-1.png" alt=""></a></div>
                                        <div class="dress__title">ASHLEY WILLIAMS</div>
                                        <div class="text-secondary">Полосатое платье-рубашка</div>
                                        <div class="text-size-large margin-bottom-4">49 765. -  </div>
                                        <div class="dress__size"><span class="margin-right-4">Размер</span>
                                            <div class="checkbox-group">
                                                <input class="checkbox-group__item" type="radio" id="size1" name="size">
                                                <label class="checkbox-group__label" for="size1">44</label>
                                                <input class="checkbox-group__item" type="radio" id="size2" name="size">
                                                <label class="checkbox-group__label" for="size2">46</label>
                                                <input class="checkbox-group__item" type="radio" id="size3" name="size">
                                                <label class="checkbox-group__label" for="size3">48</label>
                                            </div><a class="skirt__link" href="#">RU</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="cell position-relative">
                                    <div class="dress">
                                        <div class="dress__img" data-equalizer-watch><a href="#"> <img src="./i/d1.png" alt=""><img src="./i/d1-1.png" alt=""></a></div>
                                        <div class="dress__title">Proenza schouler</div>
                                        <div class="text-secondary">Полосатое платье-рубашка</div>
                                        <div class="text-size-large margin-bottom-4">49 765. -  </div>
                                        <div class="dress__size"><span class="margin-right-4">Размер</span>
                                            <div class="checkbox-group">
                                                <input class="checkbox-group__item" type="radio" id="size1" name="size">
                                                <label class="checkbox-group__label" for="size1">44</label>
                                                <input class="checkbox-group__item" type="radio" id="size2" name="size">
                                                <label class="checkbox-group__label" for="size2">46</label>
                                                <input class="checkbox-group__item" type="radio" id="size3" name="size">
                                                <label class="checkbox-group__label" for="size3">48</label>
                                            </div><a class="skirt__link" href="#">RU</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="cell position-relative">
                                    <div class="dress">
                                        <div class="dress__img" data-equalizer-watch><a href="#"> <img src="./i/d1.png" alt=""><img src="./i/d1-1.png" alt=""></a></div>
                                        <div class="dress__title">ASHLEY WILLIAMS</div>
                                        <div class="text-secondary">Полосатое платье-рубашка</div>
                                        <div class="text-size-large margin-bottom-4">49 765. -  </div>
                                        <div class="dress__size"><span class="margin-right-4">Размер</span>
                                            <div class="checkbox-group">
                                                <input class="checkbox-group__item" type="radio" id="size1" name="size">
                                                <label class="checkbox-group__label" for="size1">44</label>
                                                <input class="checkbox-group__item" type="radio" id="size2" name="size">
                                                <label class="checkbox-group__label" for="size2">46</label>
                                                <input class="checkbox-group__item" type="radio" id="size3" name="size">
                                                <label class="checkbox-group__label" for="size3">48</label>
                                            </div><a class="skirt__link" href="#">RU</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="cell position-relative">
                                    <div class="dress">
                                        <div class="dress__img" data-equalizer-watch><a href="#"> <img src="./i/d2.png" alt=""><img src="./i/d1-1.png" alt=""></a></div>
                                        <div class="dress__title">Proenza schouler</div>
                                        <div class="text-secondary">Полосатое платье-рубашка</div>
                                        <div class="text-size-large margin-bottom-4">49 765. -  </div>
                                        <div class="dress__size"><span class="margin-right-4">Размер</span>
                                            <div class="checkbox-group">
                                                <input class="checkbox-group__item" type="radio" id="size1" name="size">
                                                <label class="checkbox-group__label" for="size1">44</label>
                                                <input class="checkbox-group__item" type="radio" id="size2" name="size">
                                                <label class="checkbox-group__label" for="size2">46</label>
                                                <input class="checkbox-group__item" type="radio" id="size3" name="size">
                                                <label class="checkbox-group__label" for="size3">48</label>
                                            </div><a class="skirt__link" href="#">RU</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>*/?>
                    <li class="accordion-item look is-active" data-accordion-item=""><a class="text-center accordion-title" href="#">Вам также может понравиться</a>
                        <div class="accordion-content" data-tab-content="">
                            <div class="grid-x text-center grid-padding-x small-up-1 medium-up-2 large-up-4 margin-bottom-8" data-equalizer data-equalize-by-row="true">
                                <div class="cell position-relative">
                                    <div class="dress">
                                        <div class="dress__img" data-equalizer-watch><a href="#"> <img src="./i/d3.png" alt=""><img src="./i/d1-1.png" alt=""></a></div>
                                        <div class="dress__title">ASHLEY WILLIAMS</div>
                                        <div class="text-secondary">Полосатое платье-рубашка</div>
                                        <div class="text-size-large margin-bottom-4">49 765. -  </div>
                                        <div class="dress__size"><span class="margin-right-4">Размер</span>
                                            <div class="checkbox-group">
                                                <input class="checkbox-group__item" type="radio" id="size1" name="size">
                                                <label class="checkbox-group__label" for="size1">44</label>
                                                <input class="checkbox-group__item" type="radio" id="size2" name="size">
                                                <label class="checkbox-group__label" for="size2">46</label>
                                                <input class="checkbox-group__item" type="radio" id="size3" name="size">
                                                <label class="checkbox-group__label" for="size3">48</label>
                                            </div><a class="skirt__link" href="#">RU</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="cell position-relative">
                                    <div class="dress">
                                        <div class="dress__img" data-equalizer-watch><a href="#"> <img src="./i/d2.png" alt=""><img src="./i/d1-1.png" alt=""></a></div>
                                        <div class="dress__title">Proenza schouler</div>
                                        <div class="text-secondary">Полосатое платье-рубашка</div>
                                        <div class="text-size-large margin-bottom-4">49 765. -  </div>
                                        <div class="dress__size"><span class="margin-right-4">Размер</span>
                                            <div class="checkbox-group">
                                                <input class="checkbox-group__item" type="radio" id="size1" name="size">
                                                <label class="checkbox-group__label" for="size1">44</label>
                                                <input class="checkbox-group__item" type="radio" id="size2" name="size">
                                                <label class="checkbox-group__label" for="size2">46</label>
                                                <input class="checkbox-group__item" type="radio" id="size3" name="size">
                                                <label class="checkbox-group__label" for="size3">48</label>
                                            </div><a class="skirt__link" href="#">RU</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="cell position-relative">
                                    <div class="dress">
                                        <div class="dress__img" data-equalizer-watch><a href="#"> <img src="./i/d3.png" alt=""><img src="./i/d1-1.png" alt=""></a></div>
                                        <div class="dress__title">ASHLEY WILLIAMS</div>
                                        <div class="text-secondary">Полосатое платье-рубашка</div>
                                        <div class="text-size-large margin-bottom-4">49 765. -  </div>
                                        <div class="dress__size"><span class="margin-right-4">Размер</span>
                                            <div class="checkbox-group">
                                                <input class="checkbox-group__item" type="radio" id="size1" name="size">
                                                <label class="checkbox-group__label" for="size1">44</label>
                                                <input class="checkbox-group__item" type="radio" id="size2" name="size">
                                                <label class="checkbox-group__label" for="size2">46</label>
                                                <input class="checkbox-group__item" type="radio" id="size3" name="size">
                                                <label class="checkbox-group__label" for="size3">48</label>
                                            </div><a class="skirt__link" href="#">RU</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="cell position-relative">
                                    <div class="dress">
                                        <div class="dress__img" data-equalizer-watch><a href="#"> <img src="./i/d1.png" alt=""><img src="./i/d1-1.png" alt=""></a></div>
                                        <div class="dress__title">Proenza schouler</div>
                                        <div class="text-secondary">Полосатое платье-рубашка</div>
                                        <div class="text-size-large margin-bottom-4">49 765. -  </div>
                                        <div class="dress__size"><span class="margin-right-4">Размер</span>
                                            <div class="checkbox-group">
                                                <input class="checkbox-group__item" type="radio" id="size1" name="size">
                                                <label class="checkbox-group__label" for="size1">44</label>
                                                <input class="checkbox-group__item" type="radio" id="size2" name="size">
                                                <label class="checkbox-group__label" for="size2">46</label>
                                                <input class="checkbox-group__item" type="radio" id="size3" name="size">
                                                <label class="checkbox-group__label" for="size3">48</label>
                                            </div><a class="skirt__link" href="#">RU</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <?
                    if (!empty($arRecomData))
                    {
                        if (ModuleManager::isModuleInstalled("sale") && (!isset($arParams['USE_BIG_DATA']) || $arParams['USE_BIG_DATA'] != 'N'))
                        {
                            ?>
                            <?$APPLICATION->IncludeComponent("bitrix:catalog.bigdata.products", "", array(
                            "LINE_ELEMENT_COUNT" => 5,
                            "TEMPLATE_THEME" => (isset($arParams['TEMPLATE_THEME']) ? $arParams['TEMPLATE_THEME'] : ''),
                            "DETAIL_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["element"],
                            "BASKET_URL" => $arParams["BASKET_URL"],
                            "ACTION_VARIABLE" => (!empty($arParams["ACTION_VARIABLE"]) ? $arParams["ACTION_VARIABLE"] : "action")."_cbdp",
                            "PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
                            "PRODUCT_QUANTITY_VARIABLE" => $arParams["PRODUCT_QUANTITY_VARIABLE"],
                            "ADD_PROPERTIES_TO_BASKET" => (isset($arParams["ADD_PROPERTIES_TO_BASKET"]) ? $arParams["ADD_PROPERTIES_TO_BASKET"] : ''),
                            "PRODUCT_PROPS_VARIABLE" => $arParams["PRODUCT_PROPS_VARIABLE"],
                            "PARTIAL_PRODUCT_PROPERTIES" => (isset($arParams["PARTIAL_PRODUCT_PROPERTIES"]) ? $arParams["PARTIAL_PRODUCT_PROPERTIES"] : ''),
                            "SHOW_OLD_PRICE" => $arParams['SHOW_OLD_PRICE'],
                            "SHOW_DISCOUNT_PERCENT" => $arParams['SHOW_DISCOUNT_PERCENT'],
                            "PRICE_CODE" => $arParams["PRICE_CODE"],
                            "SHOW_PRICE_COUNT" => $arParams["SHOW_PRICE_COUNT"],
                            "PRODUCT_SUBSCRIPTION" => $arParams['PRODUCT_SUBSCRIPTION'],
                            "PRICE_VAT_INCLUDE" => $arParams["PRICE_VAT_INCLUDE"],
                            "USE_PRODUCT_QUANTITY" => $arParams['USE_PRODUCT_QUANTITY'],
                            "SHOW_NAME" => "Y",
                            "SHOW_IMAGE" => "Y",
                            "MESS_BTN_BUY" => $arParams['MESS_BTN_BUY'],
                            "MESS_BTN_DETAIL" => $arParams['MESS_BTN_DETAIL'],
                            "MESS_BTN_SUBSCRIBE" => $arParams['MESS_BTN_SUBSCRIBE'],
                            "MESS_NOT_AVAILABLE" => $arParams['MESS_NOT_AVAILABLE'],
                            "PAGE_ELEMENT_COUNT" => 5,
                            "SHOW_FROM_SECTION" => "N",
                            "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
                            "IBLOCK_ID" => $arParams["IBLOCK_ID"],
                            "DEPTH" => "2",
                            "CACHE_TYPE" => $arParams["CACHE_TYPE"],
                            "CACHE_TIME" => $arParams["CACHE_TIME"],
                            "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
                            "SHOW_PRODUCTS_".$arParams["IBLOCK_ID"] => "Y",
                            "HIDE_NOT_AVAILABLE" => $arParams["HIDE_NOT_AVAILABLE"],
                            "CONVERT_CURRENCY" => $arParams["CONVERT_CURRENCY"],
                            "CURRENCY_ID" => $arParams["CURRENCY_ID"],
                            "SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"],
                            "SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
                            "SECTION_ELEMENT_ID" => $arResult["VARIABLES"]["SECTION_ID"],
                            "SECTION_ELEMENT_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
                            "ID" => $ElementID,
                            "LABEL_PROP_".$arParams["IBLOCK_ID"] => $arParams['LABEL_PROP'],
                            "PROPERTY_CODE_".$arParams["IBLOCK_ID"] => $arParams["LIST_PROPERTY_CODE"],
                            "PROPERTY_CODE_".$arRecomData['OFFER_IBLOCK_ID'] => $arParams["LIST_OFFERS_PROPERTY_CODE"],
                            "CART_PROPERTIES_".$arParams["IBLOCK_ID"] => $arParams["PRODUCT_PROPERTIES"],
                            "CART_PROPERTIES_".$arRecomData['OFFER_IBLOCK_ID'] => $arParams["OFFERS_CART_PROPERTIES"],
                            "ADDITIONAL_PICT_PROP_".$arParams["IBLOCK_ID"] => $arParams['ADD_PICT_PROP'],
                            "ADDITIONAL_PICT_PROP_".$arRecomData['OFFER_IBLOCK_ID'] => $arParams['OFFER_ADD_PICT_PROP'],
                            "OFFER_TREE_PROPS_".$arRecomData['OFFER_IBLOCK_ID'] => $arParams["OFFER_TREE_PROPS"],
                            "RCM_TYPE" => (isset($arParams['BIG_DATA_RCM_TYPE']) ? $arParams['BIG_DATA_RCM_TYPE'] : '')
                        ),
                            $component,
                            array("HIDE_ICONS" => "Y")
                        );
                        }
                        if (($arRecomData['IBLOCK_LINK'] != '' || $arRecomData['ALL_LINK'] != ''))
                        {
                            ?>

                            <?
                            $APPLICATION->IncludeComponent(
                                "bitrix:catalog.recommended.products",
                                "",
                                array(
                                    "LINE_ELEMENT_COUNT" => $arParams["ALSO_BUY_ELEMENT_COUNT"],
                                    "TEMPLATE_THEME" => (isset($arParams['TEMPLATE_THEME']) ? $arParams['TEMPLATE_THEME'] : ''),
                                    "ID" => $ElementID,
                                    "PROPERTY_LINK" => ($arRecomData['IBLOCK_LINK'] != '' ? $arRecomData['IBLOCK_LINK'] : $arRecomData['ALL_LINK']),
                                    "CACHE_TYPE" => $arParams["CACHE_TYPE"],
                                    "CACHE_TIME" => $arParams["CACHE_TIME"],
                                    "BASKET_URL" => $arParams["BASKET_URL"],
                                    "ACTION_VARIABLE" => $arParams["ACTION_VARIABLE"],
                                    "PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
                                    "PRODUCT_QUANTITY_VARIABLE" => $arParams["PRODUCT_QUANTITY_VARIABLE"],
                                    "ADD_PROPERTIES_TO_BASKET" => (isset($arParams["ADD_PROPERTIES_TO_BASKET"]) ? $arParams["ADD_PROPERTIES_TO_BASKET"] : ''),
                                    "PRODUCT_PROPS_VARIABLE" => $arParams["PRODUCT_PROPS_VARIABLE"],
                                    "PARTIAL_PRODUCT_PROPERTIES" => (isset($arParams["PARTIAL_PRODUCT_PROPERTIES"]) ? $arParams["PARTIAL_PRODUCT_PROPERTIES"] : ''),
                                    "PAGE_ELEMENT_COUNT" => $arParams["ALSO_BUY_ELEMENT_COUNT"],
                                    "SHOW_OLD_PRICE" => $arParams['SHOW_OLD_PRICE'],
                                    "SHOW_DISCOUNT_PERCENT" => $arParams['SHOW_DISCOUNT_PERCENT'],
                                    "PRICE_CODE" => $arParams["PRICE_CODE"],
                                    "SHOW_PRICE_COUNT" => $arParams["SHOW_PRICE_COUNT"],
                                    "PRODUCT_SUBSCRIPTION" => 'N',
                                    "PRICE_VAT_INCLUDE" => $arParams["PRICE_VAT_INCLUDE"],
                                    "USE_PRODUCT_QUANTITY" => $arParams['USE_PRODUCT_QUANTITY'],
                                    "SHOW_NAME" => "Y",
                                    "SHOW_IMAGE" => "Y",
                                    "MESS_BTN_BUY" => $arParams['MESS_BTN_BUY'],
                                    "MESS_BTN_DETAIL" => $arParams["MESS_BTN_DETAIL"],
                                    "MESS_NOT_AVAILABLE" => $arParams['MESS_NOT_AVAILABLE'],
                                    "MESS_BTN_SUBSCRIBE" => $arParams['MESS_BTN_SUBSCRIBE'],
                                    "SHOW_PRODUCTS_".$arParams["IBLOCK_ID"] => "Y",
                                    "HIDE_NOT_AVAILABLE" => $arParams["HIDE_NOT_AVAILABLE"],
                                    "OFFER_TREE_PROPS_".$arRecomData['OFFER_IBLOCK_ID'] => $arParams["OFFER_TREE_PROPS"],
                                    "OFFER_TREE_PROPS_".$arRecomData['OFFER_IBLOCK_ID'] => $arParams["OFFER_TREE_PROPS"],
                                    "ADDITIONAL_PICT_PROP_".$arParams['IBLOCK_ID'] => $arParams['ADD_PICT_PROP'],
                                    "ADDITIONAL_PICT_PROP_".$arRecomData['OFFER_IBLOCK_ID'] => $arParams['OFFER_ADD_PICT_PROP'],
                                    "PROPERTY_CODE_".$arRecomData['OFFER_IBLOCK_ID'] => array(),
                                    "CONVERT_CURRENCY" => $arParams["CONVERT_CURRENCY"],
                                    "CURRENCY_ID" => $arParams["CURRENCY_ID"]
                                ),
                                $component,
                                array("HIDE_ICONS" => "Y")
                            );
                            ?>

                            <?
                        }
                    }
                    ?>
                    <?/*<li class="accordion-item look is-active" data-accordion-item=""><a class="text-center accordion-title" href="#">Вам также может понравиться</a>
                        <div class="accordion-content" data-tab-content="">
                            <div class="grid-x text-center grid-padding-x small-up-1 medium-up-2 large-up-4 margin-bottom-8" data-equalizer data-equalize-by-row="true">
                                <div class="cell position-relative">
                                    <div class="dress">
                                        <div class="dress__img" data-equalizer-watch><a href="#"> <img src="./i/d1.png" alt=""><img src="./i/d1-1.png" alt=""></a></div>
                                        <div class="dress__title">ASHLEY WILLIAMS</div>
                                        <div class="text-secondary">Полосатое платье-рубашка</div>
                                        <div class="text-size-large margin-bottom-4">49 765. -  </div>
                                        <div class="dress__size"><span class="margin-right-4">Размер</span>
                                            <div class="checkbox-group">
                                                <input class="checkbox-group__item" type="radio" id="size1" name="size">
                                                <label class="checkbox-group__label" for="size1">44</label>
                                                <input class="checkbox-group__item" type="radio" id="size2" name="size">
                                                <label class="checkbox-group__label" for="size2">46</label>
                                                <input class="checkbox-group__item" type="radio" id="size3" name="size">
                                                <label class="checkbox-group__label" for="size3">48</label>
                                            </div><a class="skirt__link" href="#">RU</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="cell position-relative">
                                    <div class="dress">
                                        <div class="dress__img" data-equalizer-watch><a href="#"> <img src="./i/d2.png" alt=""><img src="./i/d1-1.png" alt=""></a></div>
                                        <div class="dress__title">Proenza schouler</div>
                                        <div class="text-secondary">Полосатое платье-рубашка</div>
                                        <div class="text-size-large margin-bottom-4">49 765. -  </div>
                                        <div class="dress__size"><span class="margin-right-4">Размер</span>
                                            <div class="checkbox-group">
                                                <input class="checkbox-group__item" type="radio" id="size1" name="size">
                                                <label class="checkbox-group__label" for="size1">44</label>
                                                <input class="checkbox-group__item" type="radio" id="size2" name="size">
                                                <label class="checkbox-group__label" for="size2">46</label>
                                                <input class="checkbox-group__item" type="radio" id="size3" name="size">
                                                <label class="checkbox-group__label" for="size3">48</label>
                                            </div><a class="skirt__link" href="#">RU</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="cell position-relative">
                                    <div class="dress">
                                        <div class="dress__img" data-equalizer-watch><a href="#"> <img src="./i/d3.png" alt=""><img src="./i/d1-1.png" alt=""></a></div>
                                        <div class="dress__title">ASHLEY WILLIAMS</div>
                                        <div class="text-secondary">Полосатое платье-рубашка</div>
                                        <div class="text-size-large margin-bottom-4">49 765. -  </div>
                                        <div class="dress__size"><span class="margin-right-4">Размер</span>
                                            <div class="checkbox-group">
                                                <input class="checkbox-group__item" type="radio" id="size1" name="size">
                                                <label class="checkbox-group__label" for="size1">44</label>
                                                <input class="checkbox-group__item" type="radio" id="size2" name="size">
                                                <label class="checkbox-group__label" for="size2">46</label>
                                                <input class="checkbox-group__item" type="radio" id="size3" name="size">
                                                <label class="checkbox-group__label" for="size3">48</label>
                                            </div><a class="skirt__link" href="#">RU</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="cell position-relative">
                                    <div class="dress">
                                        <div class="dress__img" data-equalizer-watch><a href="#"> <img src="./i/d3.png" alt=""><img src="./i/d1-1.png" alt=""></a></div>
                                        <div class="dress__title">Proenza schouler</div>
                                        <div class="text-secondary">Полосатое платье-рубашка</div>
                                        <div class="text-size-large margin-bottom-4">49 765. -  </div>
                                        <div class="dress__size"><span class="margin-right-4">Размер</span>
                                            <div class="checkbox-group">
                                                <input class="checkbox-group__item" type="radio" id="size1" name="size">
                                                <label class="checkbox-group__label" for="size1">44</label>
                                                <input class="checkbox-group__item" type="radio" id="size2" name="size">
                                                <label class="checkbox-group__label" for="size2">46</label>
                                                <input class="checkbox-group__item" type="radio" id="size3" name="size">
                                                <label class="checkbox-group__label" for="size3">48</label>
                                            </div><a class="skirt__link" href="#">RU</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>*/?>
                </ul>
            </div>
        </div>


        <div class="grid-x grid-padding-x align-center text-center">
            <div class="cell">
                <h2 class="text-transform-none">Подпишись на нашу рассылку, получи скидку 300&#160;р.    </h2>
            </div>
            <div class="cell large-6">
                <?$APPLICATION->IncludeComponent(
                    "asd:subscribe.quick.form",
                    "catalog_element",
                    array(
                        "AJAX_MODE" => "N",
                        "SHOW_HIDDEN" => "Y",
                        "ALLOW_ANONYMOUS" => "Y",
                        "SHOW_AUTH_LINKS" => "Y",
                        "CACHE_TYPE" => "A",
                        "CACHE_TIME" => "3600",
                        "SET_TITLE" => "Y",
                        "AJAX_OPTION_JUMP" => "N",
                        "AJAX_OPTION_STYLE" => "Y",
                        "AJAX_OPTION_HISTORY" => "N",
                        "COMPONENT_TEMPLATE" => ".default",
                        "RUBRICS" => array(
                            0 => "1",
                        ),
                        "SHOW_RUBRICS" => "N",
                        "INC_JQUERY" => "N",
                        "NOT_CONFIRM" => "N",
                        "FORMAT" => "text"
                    ),
                    false
                );?>
            </div>
        </div>
    </div>







	<?
	if($arParams["USE_ALSO_BUY"] == "Y" && ModuleManager::isModuleInstalled("sale") && !empty($arRecomData))
	{
		?><?$APPLICATION->IncludeComponent("bitrix:sale.recommended.products", ".default", array(
			"ID" => $ElementID,
			"TEMPLATE_THEME" => (isset($arParams['TEMPLATE_THEME']) ? $arParams['TEMPLATE_THEME'] : ''),
			"MIN_BUYES" => $arParams["ALSO_BUY_MIN_BUYES"],
			"ELEMENT_COUNT" => $arParams["ALSO_BUY_ELEMENT_COUNT"],
			"LINE_ELEMENT_COUNT" => $arParams["ALSO_BUY_ELEMENT_COUNT"],
			"DETAIL_URL" => $arParams["DETAIL_URL"],
			"BASKET_URL" => $arParams["BASKET_URL"],
			"ACTION_VARIABLE" => $arParams["ACTION_VARIABLE"],
			"PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
			"SECTION_ID_VARIABLE" => $arParams["SECTION_ID_VARIABLE"],
			"PAGE_ELEMENT_COUNT" => $arParams["ALSO_BUY_ELEMENT_COUNT"],
			"CACHE_TYPE" => $arParams["CACHE_TYPE"],
			"CACHE_TIME" => $arParams["CACHE_TIME"],
			"PRICE_CODE" => $arParams["PRICE_CODE"],
			"USE_PRICE_COUNT" => $arParams["USE_PRICE_COUNT"],
			"SHOW_PRICE_COUNT" => $arParams["SHOW_PRICE_COUNT"],
			"PRICE_VAT_INCLUDE" => $arParams["PRICE_VAT_INCLUDE"],
			'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
			'CURRENCY_ID' => $arParams['CURRENCY_ID'],
			'HIDE_NOT_AVAILABLE' => $arParams["HIDE_NOT_AVAILABLE"],
			"SHOW_PRODUCTS_".$arParams["IBLOCK_ID"] => "Y",
			"PROPERTY_CODE_".$arRecomData['OFFER_IBLOCK_ID'] => array(    ),
			"OFFER_TREE_PROPS_".$arRecomData['OFFER_IBLOCK_ID'] => $arParams["OFFER_TREE_PROPS"],
			"OFFER_TREE_PROPS_".$arRecomData['OFFER_IBLOCK_ID'] => $arParams["OFFER_TREE_PROPS"],
			"ADDITIONAL_PICT_PROP_".$arParams['IBLOCK_ID'] => $arParams['ADD_PICT_PROP'],
			"ADDITIONAL_PICT_PROP_".$arRecomData['OFFER_IBLOCK_ID'] => $arParams['OFFER_ADD_PICT_PROP']
		),
		$component,
		array("HIDE_ICONS" => "Y")
	);
		?><?
	}
}
?>