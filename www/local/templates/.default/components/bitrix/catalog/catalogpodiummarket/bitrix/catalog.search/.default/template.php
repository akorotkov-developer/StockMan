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
$this->setFrameMode(true);
?>
    <div class="grid-container">
        <div class="grid-x grid-padding-x">
            <div class="cell text-center">
                <h1 class="margin-bottom-0">Поиск</h1>
                <?$APPLICATION->ShowViewContent('catalog_search_info');?>
            </div>
        </div>
        <?$arElements = $APPLICATION->IncludeComponent(
            "bitrix:search.page",
            "search",
            Array(
                "RESTART" => $arParams["RESTART"],
                "NO_WORD_LOGIC" => $arParams["NO_WORD_LOGIC"],
                "USE_LANGUAGE_GUESS" => $arParams["USE_LANGUAGE_GUESS"],
                "CHECK_DATES" => $arParams["CHECK_DATES"],
                "arrFILTER" => array("iblock_".$arParams["IBLOCK_TYPE"]),
                "arrFILTER_iblock_".$arParams["IBLOCK_TYPE"] => array($arParams["IBLOCK_ID"]),
                "USE_TITLE_RANK" => "N",
                "DEFAULT_SORT" => "rank",
                "FILTER_NAME" => "",
                "SHOW_WHERE" => "N",
                "arrWHERE" => array(),
                "SHOW_WHEN" => "N",
                "PAGE_RESULT_COUNT" => $arParams["PAGE_RESULT_COUNT"],
                "DISPLAY_TOP_PAGER" => "N",
                "DISPLAY_BOTTOM_PAGER" => "N",
                "PAGER_TITLE" => "",
                "PAGER_SHOW_ALWAYS" => "N",
                "PAGER_TEMPLATE" => "N",
            ),
            false,
            array('HIDE_ICONS' => 'Y')
        );?>
    </div>
</div>
<div class="content">
    <div class="grid-x grid-padding-x">
        <div class="cell small-12 medium-4 large-3 xlarge-2 text-center medium-text-left">
            <?$APPLICATION->ShowViewContent('catalog_search_section');?>
        </div>
<?
if (!empty($arElements) && is_array($arElements))
{
    global $searchFilter;
    $searchFilter = array(
        "=ID" => $arElements,
        array (
            "LOGIC" => "OR",
            array("!DETAIL_PICTURE" => false),
            array("!PROPERTY_MORE_PHOTO" => false),
        )
    );
    $arSectionSearch = array();
    $arIdSectionSearch = array();
    //if (isset($_COOKIE["CATALOG_SECTION"])) {
        $arIdSectionSearch[] = GetHomeCtalogSection();
        $rsParentSection = CIBlockSection::GetByID(GetHomeCtalogSection());
        if ($arParentSection = $rsParentSection->GetNext())
        {
            $arFilter = array('IBLOCK_ID' => $arParentSection['IBLOCK_ID'],'>LEFT_MARGIN' => $arParentSection['LEFT_MARGIN'],'<RIGHT_MARGIN' => $arParentSection['RIGHT_MARGIN'],'>DEPTH_LEVEL' => $arParentSection['DEPTH_LEVEL']);
            $rsSect = CIBlockSection::GetList(array('left_margin' => 'asc'),$arFilter, false,  array("IBLOCK_ID", "ID"));
            while ($arSect = $rsSect->GetNext())
            {
                $arIdSectionSearch[] = $arSect["ID"];
            }
        }
        $arSectionSearch = array(
            "=SECTION_ID" => $arIdSectionSearch
        );
        $searchFilter = array_merge($searchFilter, $arSectionSearch);
    //}

    if (intval($_REQUEST["section_search_id"])>0) {
        $arSectionSearch = array(
            "=SECTION_ID" => intval($_REQUEST["section_search_id"])
        );
        $searchFilter = array_merge($searchFilter, $arSectionSearch);
    }

		$ar = $APPLICATION->IncludeComponent(
		"bitrix:catalog.section",
		"table_view",
		array(
			"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
			"IBLOCK_ID" => $arParams["IBLOCK_ID"],
			"ELEMENT_SORT_FIELD" => $arParams["ELEMENT_SORT_FIELD"],
			"ELEMENT_SORT_ORDER" => $arParams["ELEMENT_SORT_ORDER"],
			"ELEMENT_SORT_FIELD2" => $arParams["ELEMENT_SORT_FIELD2"],
			"ELEMENT_SORT_ORDER2" => $arParams["ELEMENT_SORT_ORDER2"],
			"PAGE_ELEMENT_COUNT" => $arParams["PAGE_ELEMENT_COUNT"],
			"LINE_ELEMENT_COUNT" => $arParams["LINE_ELEMENT_COUNT"],
			"PROPERTY_CODE" => $arParams["PROPERTY_CODE"],
			"PROPERTY_CODE_MOBILE" => $arParams["PROPERTY_CODE_MOBILE"],
			"OFFERS_CART_PROPERTIES" => $arParams["OFFERS_CART_PROPERTIES"],
			"OFFERS_FIELD_CODE" => $arParams["OFFERS_FIELD_CODE"],
			"OFFERS_PROPERTY_CODE" => $arParams["OFFERS_PROPERTY_CODE"],
			"OFFERS_SORT_FIELD" => $arParams["OFFERS_SORT_FIELD"],
			"OFFERS_SORT_ORDER" => $arParams["OFFERS_SORT_ORDER"],
			"OFFERS_SORT_FIELD2" => $arParams["OFFERS_SORT_FIELD2"],
			"OFFERS_SORT_ORDER2" => $arParams["OFFERS_SORT_ORDER2"],
			"OFFERS_LIMIT" => $arParams["OFFERS_LIMIT"],
			"SECTION_URL" => $arParams["SECTION_URL"],
			"DETAIL_URL" => $arParams["DETAIL_URL"],
			"BASKET_URL" => $arParams["BASKET_URL"],
			"ACTION_VARIABLE" => $arParams["ACTION_VARIABLE"],
			"PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
			"PRODUCT_QUANTITY_VARIABLE" => $arParams["PRODUCT_QUANTITY_VARIABLE"],
			"PRODUCT_PROPS_VARIABLE" => $arParams["PRODUCT_PROPS_VARIABLE"],
			"SECTION_ID_VARIABLE" => $arParams["SECTION_ID_VARIABLE"],
			"CACHE_TYPE" => $arParams["CACHE_TYPE"],
			"CACHE_TIME" => $arParams["CACHE_TIME"],
			"DISPLAY_COMPARE" => $arParams["DISPLAY_COMPARE"],
			"PRICE_CODE" => $arParams["PRICE_CODE"],
			"USE_PRICE_COUNT" => $arParams["USE_PRICE_COUNT"],
			"SHOW_PRICE_COUNT" => $arParams["SHOW_PRICE_COUNT"],
			"PRICE_VAT_INCLUDE" => $arParams["PRICE_VAT_INCLUDE"],
			"PRODUCT_PROPERTIES" => $arParams["PRODUCT_PROPERTIES"],
			"USE_PRODUCT_QUANTITY" => $arParams["USE_PRODUCT_QUANTITY"],
			"ADD_PROPERTIES_TO_BASKET" => (isset($arParams["ADD_PROPERTIES_TO_BASKET"]) ? $arParams["ADD_PROPERTIES_TO_BASKET"] : ''),
			"PARTIAL_PRODUCT_PROPERTIES" => (isset($arParams["PARTIAL_PRODUCT_PROPERTIES"]) ? $arParams["PARTIAL_PRODUCT_PROPERTIES"] : ''),
			"CONVERT_CURRENCY" => $arParams["CONVERT_CURRENCY"],
			"CURRENCY_ID" => $arParams["CURRENCY_ID"],
			"HIDE_NOT_AVAILABLE" => $arParams["HIDE_NOT_AVAILABLE"],
			'HIDE_NOT_AVAILABLE_OFFERS' => $arParams["HIDE_NOT_AVAILABLE_OFFERS"],
			"DISPLAY_TOP_PAGER" => $arParams["DISPLAY_TOP_PAGER"],
			"DISPLAY_BOTTOM_PAGER" => $arParams["DISPLAY_BOTTOM_PAGER"],
			"PAGER_TITLE" => $arParams["PAGER_TITLE"],
			"PAGER_SHOW_ALWAYS" => $arParams["PAGER_SHOW_ALWAYS"],
			"PAGER_TEMPLATE" => $arParams["PAGER_TEMPLATE"],
			"PAGER_DESC_NUMBERING" => $arParams["PAGER_DESC_NUMBERING"],
			"PAGER_DESC_NUMBERING_CACHE_TIME" => $arParams["PAGER_DESC_NUMBERING_CACHE_TIME"],
			"PAGER_SHOW_ALL" => $arParams["PAGER_SHOW_ALL"],
			"LAZY_LOAD" => $arParams["LAZY_LOAD"],
			"MESS_BTN_LAZY_LOAD" => $arParams["~MESS_BTN_LAZY_LOAD"],
			"LOAD_ON_SCROLL" => $arParams["LOAD_ON_SCROLL"],
			"FILTER_NAME" => "searchFilter",
			"SECTION_ID" => "",
			"SECTION_CODE" => "",
			"SECTION_USER_FIELDS" => array(),
			"INCLUDE_SUBSECTIONS" => "Y",
			"SHOW_ALL_WO_SECTION" => "Y",
			"META_KEYWORDS" => "",
			"META_DESCRIPTION" => "",
			"BROWSER_TITLE" => "",
			"ADD_SECTIONS_CHAIN" => "N",
			"SET_TITLE" => "N",
			"SET_STATUS_404" => "N",
			"CACHE_FILTER" => "N",
			"CACHE_GROUPS" => "N",

			'LABEL_PROP' => $arParams['LABEL_PROP'],
			'LABEL_PROP_MOBILE' => $arParams['LABEL_PROP_MOBILE'],
			'LABEL_PROP_POSITION' => $arParams['LABEL_PROP_POSITION'],
			'ADD_PICT_PROP' => $arParams['ADD_PICT_PROP'],
			'PRODUCT_DISPLAY_MODE' => $arParams['PRODUCT_DISPLAY_MODE'],
			'PRODUCT_BLOCKS_ORDER' => $arParams['PRODUCT_BLOCKS_ORDER'],
			'PRODUCT_ROW_VARIANTS' => $arParams['PRODUCT_ROW_VARIANTS'],
			'ENLARGE_PRODUCT' => $arParams['ENLARGE_PRODUCT'],
			'ENLARGE_PROP' => $arParams['ENLARGE_PROP'],
			'SHOW_SLIDER' => $arParams['SHOW_SLIDER'],
			'SLIDER_INTERVAL' => $arParams['SLIDER_INTERVAL'],
			'SLIDER_PROGRESS' => $arParams['SLIDER_PROGRESS'],

			'OFFER_ADD_PICT_PROP' => $arParams['OFFER_ADD_PICT_PROP'],
			'OFFER_TREE_PROPS' => $arParams['OFFER_TREE_PROPS'],
			'PRODUCT_SUBSCRIPTION' => $arParams['PRODUCT_SUBSCRIPTION'],
			'SHOW_DISCOUNT_PERCENT' => $arParams['SHOW_DISCOUNT_PERCENT'],
			'SHOW_OLD_PRICE' => $arParams['SHOW_OLD_PRICE'],
			'SHOW_MAX_QUANTITY' => $arParams['SHOW_MAX_QUANTITY'],
			'MESS_SHOW_MAX_QUANTITY' => $arParams['~MESS_SHOW_MAX_QUANTITY'],
			'RELATIVE_QUANTITY_FACTOR' => $arParams['RELATIVE_QUANTITY_FACTOR'],
			'MESS_RELATIVE_QUANTITY_MANY' => $arParams['~MESS_RELATIVE_QUANTITY_MANY'],
			'MESS_RELATIVE_QUANTITY_FEW' => $arParams['~MESS_RELATIVE_QUANTITY_FEW'],
			'MESS_BTN_BUY' => $arParams['~MESS_BTN_BUY'],
			'MESS_BTN_ADD_TO_BASKET' => $arParams['~MESS_BTN_ADD_TO_BASKET'],
			'MESS_BTN_SUBSCRIBE' => $arParams['~MESS_BTN_SUBSCRIBE'],
			'MESS_BTN_DETAIL' => $arParams['~MESS_BTN_DETAIL'],
			'MESS_NOT_AVAILABLE' => $arParams['~MESS_NOT_AVAILABLE'],
			'MESS_BTN_COMPARE' => $arParams['~MESS_BTN_COMPARE'],

			'USE_ENHANCED_ECOMMERCE' => $arParams['USE_ENHANCED_ECOMMERCE'],
			'DATA_LAYER_NAME' => $arParams['DATA_LAYER_NAME'],
			'BRAND_PROPERTY' => $arParams['BRAND_PROPERTY'],

			'TEMPLATE_THEME' => $arParams['TEMPLATE_THEME'],
			'ADD_TO_BASKET_ACTION' => (isset($arParams['ADD_TO_BASKET_ACTION']) ? $arParams['ADD_TO_BASKET_ACTION'] : ''),
			'SHOW_CLOSE_POPUP' => (isset($arParams['SHOW_CLOSE_POPUP']) ? $arParams['SHOW_CLOSE_POPUP'] : ''),
			'COMPARE_PATH' => $arParams['COMPARE_PATH'],
			'COMPARE_NAME' => $arParams['COMPARE_NAME']
		),
		$arResult["THEME_COMPONENT"],
		array('HIDE_ICONS' => 'Y')
	);


    /*if ($ar == 0 ){
        $this->SetViewTarget('catalog_search_section');
        $this->EndViewTarget();
        ?><div class="cell small-12 medium-8 xlarge-10 large-9">Сожалеем, но ничего не найдено.</div><?
    } else {*/
        $arIdSection = array();
        $arSelect = Array("ID", "SECTION_ID");
        $arFilter = Array(
            "ID"=>$arElements,
            array (
                "LOGIC" => "OR",
                array("!DETAIL_PICTURE" => false),
                array("!PROPERTY_MORE_PHOTO" => false),
            ));
        $res = CIBlockElement::GetList(Array(), $searchFilter, array("IBLOCK_SECTION_ID"), false, $arSelect);
        while($ar_fields = $res->GetNext())
        {
            $arIdSection[] = $ar_fields["IBLOCK_SECTION_ID"];
        }

        $this->SetViewTarget('catalog_search_section');
        if (count($arIdSection) > 0) {
            $section_search_id = intval($_REQUEST['section_search_id']);
            ?><ul class="cloth"><?
            $arFilter = Array($arParams["IBLOCK_ID"], "ID" => $arIdSection);
            $db_list = CIBlockSection::GetList(Array("ID"=>"ASC"), $arFilter, true);
            while($ar_result = $db_list->GetNext())
            {
                ?><li class="cloth__item">
                <a class="cloth__link <?if ($section_search_id == $ar_result['ID']) {?>cloth__link_more<?}?>" href="<?=$APPLICATION->GetCurPageParam("section_search_id=" . $ar_result['ID'], array("section_search_id"))?>"><?=$ar_result['NAME']?></a>
                </li><?
            }
            ?></ul><?
        }
        $this->EndViewTarget();
    //}


    ?></div><?
}
elseif (is_array($arElements))
{
    ?>
    <div class="cell small-12 medium-8 xlarge-10 large-9"><?echo GetMessage("CT_BCSE_NOT_FOUND");?></div>
    </div>
<?
    $this->SetViewTarget('catalog_search_info');?>
    <div class="text-secondary margin-bottom-13"><?echo GetMessage("CT_BCSE_NOT_FOUND")?></div>
    <?$this->EndViewTarget();
}
?>
