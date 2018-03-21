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
        <?
        if (!empty($arResult['ITEMS']))
        {
            ?>

            <div class="cell small-12 medium-8 xlarge-10 large-9">
                <div class="grid-x text-center grid-padding-x small-up-1 medium-up-2 xlarge-up-5 large-up-3 margin-bottom-8" data-equalizer data-equalize-by-row="true">

            <?
            $templateLibrary = array('popup');
            $currencyList = '';
            if (!empty($arResult['CURRENCIES']))
            {
                $templateLibrary[] = 'currency';
                $currencyList = CUtil::PhpToJSObject($arResult['CURRENCIES'], false, true, true);
            }
            $templateData = array(
                'TEMPLATE_THEME' => $this->GetFolder().'/themes/'.$arParams['TEMPLATE_THEME'].'/style.css',
                'TEMPLATE_CLASS' => 'bx_'.$arParams['TEMPLATE_THEME'],
                'TEMPLATE_LIBRARY' => $templateLibrary,
                'CURRENCIES' => $currencyList
            );
            unset($currencyList, $templateLibrary);

            $arSkuTemplate = array();
            if (!empty($arResult['SKU_PROPS']))
            {
                foreach ($arResult['SKU_PROPS'] as &$arProp)
                {
                    $templateRow = '';
                    if ('TEXT' == $arProp['SHOW_MODE'])
                    {
                        $templateRow .= '<input class="checkbox-group__item" type="radio" id="size1" name="size">';
                        $templateRow .= '<label class="checkbox-group__label" for="size1">'.htmlspecialcharsex($arProp['NAME']).'</label>';
                        foreach ($arProp['VALUES'] as $arOneValue)
                        {
                            $arOneValue['NAME'] = htmlspecialcharsbx($arOneValue['NAME']);
                        }
                    }
                    $arSkuTemplate[$arProp['CODE']] = $templateRow;
                }
                unset($templateRow, $arProp);
            }

            if ($arParams["DISPLAY_TOP_PAGER"])
            {
                ?><? echo $arResult["NAV_STRING"]; ?><?
            }

            $strElementEdit = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_EDIT");
            $strElementDelete = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_DELETE");
            $arElementDeleteParams = array("CONFIRM" => GetMessage('CT_BCS_TPL_ELEMENT_DELETE_CONFIRM'));
        ?>


        <!-- Товар -->
        <?
        foreach ($arResult['ITEMS'] as $key => $arItem)
        {
            $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], $strElementEdit);
            $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], $strElementDelete, $arElementDeleteParams);
            $strMainID = $this->GetEditAreaId($arItem['ID']);

            $arItemIDs = array(
                'ID' => $strMainID,
                'PICT' => $strMainID.'_pict',
                'SECOND_PICT' => $strMainID.'_secondpict',
                'STICKER_ID' => $strMainID.'_sticker',
                'SECOND_STICKER_ID' => $strMainID.'_secondsticker',
                'QUANTITY' => $strMainID.'_quantity',
                'QUANTITY_DOWN' => $strMainID.'_quant_down',
                'QUANTITY_UP' => $strMainID.'_quant_up',
                'QUANTITY_MEASURE' => $strMainID.'_quant_measure',
                'BUY_LINK' => $strMainID.'_buy_link',
                'BASKET_ACTIONS' => $strMainID.'_basket_actions',
                'NOT_AVAILABLE_MESS' => $strMainID.'_not_avail',
                'SUBSCRIBE_LINK' => $strMainID.'_subscribe',
                'COMPARE_LINK' => $strMainID.'_compare_link',

                'PRICE' => $strMainID.'_price',
                'DSC_PERC' => $strMainID.'_dsc_perc',
                'SECOND_DSC_PERC' => $strMainID.'_second_dsc_perc',
                'PROP_DIV' => $strMainID.'_sku_tree',
                'PROP' => $strMainID.'_prop_',
                'DISPLAY_PROP_DIV' => $strMainID.'_sku_prop',
                'BASKET_PROP_DIV' => $strMainID.'_basket_prop',
            );

            $strObName = 'ob'.preg_replace("/[^a-zA-Z0-9_]/", "x", $strMainID);

            $productTitle = (
                isset($arItem['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE'])&& $arItem['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE'] != ''
                ? $arItem['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE']
                : $arItem['NAME']
            );
            $imgTitle = (
                isset($arItem['IPROPERTY_VALUES']['ELEMENT_PREVIEW_PICTURE_FILE_TITLE']) && $arItem['IPROPERTY_VALUES']['ELEMENT_PREVIEW_PICTURE_FILE_TITLE'] != ''
                ? $arItem['IPROPERTY_VALUES']['ELEMENT_PREVIEW_PICTURE_FILE_TITLE']
                : $arItem['NAME']
            );

            $minPrice = false;
            ?>


            <?
            if (isset($arItem['MIN_PRICE']) || isset($arItem['RATIO_PRICE']))
                $minPrice = (isset($arItem['RATIO_PRICE']) ? $arItem['RATIO_PRICE'] : $arItem['MIN_PRICE']);
            ?>

            <div class="cell position-relative" id="<? echo $strMainID; ?>">
                <div class="dress <?if (count($arResult['ITEMS'])==1) {?>dress__inner<?}?>">
                    <div class="dress__img" data-equalizer-watch>
                        <a href="<? echo $arItem['DETAIL_PAGE_URL']; ?>">
                            <?
                            $imgsrc1 = "";
                            $imgsrc2 = "";
                            if ($arItem['PREVIEW_PICTURE']['SRC']) {
                                $imgsrc1 = $arItem['PREVIEW_PICTURE']['SRC'];
                            } elseif ($arItem['DETAIL_PICTURE']['SRC']) {
                                $imgsrc1 = $arItem['DETAIL_PICTURE']['SRC'];
                            }
                            if ($arItem["PRODUCT_PREVIEW_SECOND"]["SRC"]) {
                                $imgsrc2 = $arItem["PRODUCT_PREVIEW_SECOND"]["SRC"];
                            }
                            ?>
                            <img src="<?=$imgsrc1;?>" alt="">
                            <?if ($imgsrc2) {?>
                                <img src="<?=$imgsrc2;?>" alt="">
                            <?}?>
                        </a>
                    </div>
                    <div class="dress__title"><?=$arItem["PROPERTIES"]["MANUFACTURER"]["VALUE"]?></div>
                    <div class="text-secondary"><?=$productTitle;?></div>
                    <?
                        $price_product = 0;
                        if (!empty($minPrice))
                        {
                            if ('N' == $arParams['PRODUCT_DISPLAY_MODE'] && isset($arItem['OFFERS']) && !empty($arItem['OFFERS']))
                            {
                                $price_product = GetMessage(
                                    'CT_BCS_TPL_MESS_PRICE_SIMPLE_MODE',
                                    array(
                                        '#PRICE#' => $minPrice['PRINT_DISCOUNT_VALUE'],
                                        '#MEASURE#' => GetMessage(
                                            'CT_BCS_TPL_MESS_MEASURE_SIMPLE_MODE',
                                            array(
                                                '#VALUE#' => $minPrice['CATALOG_MEASURE_RATIO'],
                                                '#UNIT#' => $minPrice['CATALOG_MEASURE_NAME']
                                            )
                                        )
                                    )
                                );
                            }
                            else
                            {
                                $price_product = $minPrice['PRINT_DISCOUNT_VALUE'];
                            }
                            if ('Y' == $arParams['SHOW_OLD_PRICE'] && $minPrice['DISCOUNT_VALUE'] < $minPrice['VALUE'])
                            {
                                $price_product = $minPrice['PRINT_VALUE'];
                            }
                        }
                        unset($minPrice);
                    ?>
                    <div class="text-size-large margin-bottom-4"><?=$price_product?></div>
                    <?
                    if ('Y' == $arParams['PRODUCT_DISPLAY_MODE'])
                    {
                        if (!empty($arItem['OFFERS_PROP']))
                        {
                            $arSkuProps = array();
                            ?>
                            <div class="dress__size"  id="<? echo $arItemIDs['PROP_DIV']; ?>">
                                    <?
                                    foreach ($arSkuTemplate as $code => $strTemplate)
                                    {
                                        if (!isset($arItem['OFFERS_PROP'][$code]))
                                            continue;
                                        ?>
                                        <?
                                        echo '<span class="margin-right-4">'.$arResult['SKU_PROPS'][$code]['NAME'].'</span>';
                                    }
                                ?>
                                <div class="checkbox-group">
                                <?
                                    foreach ($arResult['SKU_PROPS'] as $arOneProp)
                                    {
                                        if (!isset($arItem['OFFERS_PROP'][$arOneProp['CODE']]))
                                            continue;
                                        foreach ($arOneProp["VALUES"] as $propvalue) {
                                            ?>
                                            <input class="checkbox-group__item" type="radio" name="size">
                                            <label class="checkbox-group__label" for="size1"><?=$propvalue["NAME"]?></label>
                                            <?
                                        }
                                    }
                                    foreach ($arItem['JS_OFFERS'] as &$arOneJs)
                                    {
                                        if (0 < $arOneJs['PRICE']['DISCOUNT_DIFF_PERCENT'])
                                        {
                                            $arOneJs['PRICE']['DISCOUNT_DIFF_PERCENT'] = '-'.$arOneJs['PRICE']['DISCOUNT_DIFF_PERCENT'].'%';
                                            $arOneJs['BASIS_PRICE']['DISCOUNT_DIFF_PERCENT'] = '-'.$arOneJs['BASIS_PRICE']['DISCOUNT_DIFF_PERCENT'].'%';
                                        }
                                    }
                                    unset($arOneJs);
                                    ?>
                                </div>

                                <a class="skirt__link" href="#">RU</a>
                            </div>
                            <?
                            if ($arItem['OFFERS_PROPS_DISPLAY'])
                            {
                                foreach ($arItem['JS_OFFERS'] as $keyOffer => $arJSOffer)
                                {
                                    $strProps = '';
                                    if (!empty($arJSOffer['DISPLAY_PROPERTIES']))
                                    {
                                        foreach ($arJSOffer['DISPLAY_PROPERTIES'] as $arOneProp)
                                        {
                                            $strProps .= '<br>'.$arOneProp['NAME'].' <strong>'.(
                                                is_array($arOneProp['VALUE'])
                                                    ? implode(' / ', $arOneProp['VALUE'])
                                                    : $arOneProp['VALUE']
                                                ).'</strong>';
                                        }
                                    }
                                    $arItem['JS_OFFERS'][$keyOffer]['DISPLAY_PROPERTIES'] = $strProps;
                                }
                            }
                        }
                    }
                    ?>

                </div>
            </div>
        <?
        }
        ?>
    </div>
</div>

<?
	if ($arParams["DISPLAY_BOTTOM_PAGER"])
	{
		?><? echo $arResult["NAV_STRING"]; ?><?
	}
}
if ($arResult['NAV_RESULT']->NavRecordCount > 0) {
    $start = ($arResult['NAV_RESULT']->NavPageNomer == 1 ? '1' : ($arResult['NAV_RESULT']->NavPageNomer - 1) * $arResult['NAV_RESULT']->NavPageSize + 1);
    $end = $arResult['NAV_RESULT']->NavPageNomer * $arResult['NAV_RESULT']->NavPageSize;
    if ($end > $arResult['NAV_RESULT']->NavRecordCount) {
        $end =  $arResult['NAV_RESULT']->NavRecordCount;
    }
    $this->SetViewTarget('catalog_search_info');?>
    <div class="text-secondary margin-bottom-13">Результаты поиска <?=$start?>-<?=$end?> из <?=$arResult['NAV_RESULT']->NavRecordCount?></div>
    <?$this->EndViewTarget();

    $this->SetViewTarget('catalog_section_count');?>
    <div class="text-secondary margin-bottom-1"><?=$arResult['NAV_RESULT']->NavRecordCount?> <?=inclination($arResult['NAV_RESULT']->NavRecordCount,array('товар','товара','товаров'))?></div>
    <?$this->EndViewTarget();
} else {
    $this->SetViewTarget('catalog_search_info');?>
    <div class="text-secondary margin-bottom-13"> Сожалеем, но ничего не найдено.</div>
    <?$this->EndViewTarget();
}
