<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** @var CBitrixComponentTemplate $this */
/** @var array $arParams */
/** @var array $arResult */
/** @global CDatabase $DB */
/** @global CMain $APPLICATION */

$frame = $this->createFrame()->begin("");

$templateData = array(
	'TEMPLATE_THEME' => $this->GetFolder().'/themes/'.$arParams['TEMPLATE_THEME'].'/style.css',
	'TEMPLATE_CLASS' => 'bx_'.$arParams['TEMPLATE_THEME']
);

$injectId = $arParams['UNIQ_COMPONENT_ID'];

if (isset($arResult['REQUEST_ITEMS']))
{
	// code to receive recommendations from the cloud
	CJSCore::Init(array('ajax'));

	// component parameters
	$signer = new \Bitrix\Main\Security\Sign\Signer;
	$signedParameters = $signer->sign(
		base64_encode(serialize($arResult['_ORIGINAL_PARAMS'])),
		'bx.bd.products.recommendation'
	);
	$signedTemplate = $signer->sign($arResult['RCM_TEMPLATE'], 'bx.bd.products.recommendation');

	?>

	<span id="<?=$injectId?>"></span>

	<script type="text/javascript">
		BX.ready(function(){
			bx_rcm_get_from_cloud(
				'<?=CUtil::JSEscape($injectId)?>',
				<?=CUtil::PhpToJSObject($arResult['RCM_PARAMS'])?>,
				{
					'parameters':'<?=CUtil::JSEscape($signedParameters)?>',
					'template': '<?=CUtil::JSEscape($signedTemplate)?>',
					'site_id': '<?=CUtil::JSEscape(SITE_ID)?>',
					'rcm': 'yes'
				}
			);
		});
	</script>
	<?
	$frame->end();
	return;

	// \ end of the code to receive recommendations from the cloud
}


// regular template then
// if customized template, for better js performance don't forget to frame content with <span id="{$injectId}_items">...</span> 

if (!empty($arResult['ITEMS']))
{
	?>

	<span id="<?=$injectId?>_items">

	<script type="text/javascript">
	BX.message({
		CBD_MESS_BTN_BUY: '<? echo ('' != $arParams['MESS_BTN_BUY'] ? CUtil::JSEscape($arParams['MESS_BTN_BUY']) : GetMessageJS('CVP_TPL_MESS_BTN_BUY')); ?>',
		CBD_MESS_BTN_ADD_TO_BASKET: '<? echo ('' != $arParams['MESS_BTN_ADD_TO_BASKET'] ? CUtil::JSEscape($arParams['MESS_BTN_ADD_TO_BASKET']) : GetMessageJS('CVP_TPL_MESS_BTN_ADD_TO_BASKET')); ?>',
		CBD_MESS_BTN_DETAIL: '<? echo ('' != $arParams['MESS_BTN_DETAIL'] ? CUtil::JSEscape($arParams['MESS_BTN_DETAIL']) : GetMessageJS('CVP_TPL_MESS_BTN_DETAIL')); ?>',
		CBD_MESS_NOT_AVAILABLE: '<? echo ('' != $arParams['MESS_BTN_DETAIL'] ? CUtil::JSEscape($arParams['MESS_BTN_DETAIL']) : GetMessageJS('CVP_TPL_MESS_BTN_DETAIL')); ?>',
		CBD_BTN_MESSAGE_BASKET_REDIRECT: '<? echo GetMessageJS('CVP_CATALOG_BTN_MESSAGE_BASKET_REDIRECT'); ?>',
		CBD_BASKET_URL: '<? echo $arParams["BASKET_URL"]; ?>',
		CBD_ADD_TO_BASKET_OK: '<? echo GetMessageJS('CVP_ADD_TO_BASKET_OK'); ?>',
		CBD_TITLE_ERROR: '<? echo GetMessageJS('CVP_CATALOG_TITLE_ERROR') ?>',
		CBD_TITLE_BASKET_PROPS: '<? echo GetMessageJS('CVP_CATALOG_TITLE_BASKET_PROPS') ?>',
		CBD_TITLE_SUCCESSFUL: '<? echo GetMessageJS('CVP_ADD_TO_BASKET_OK'); ?>',
		CBD_BASKET_UNKNOWN_ERROR: '<? echo GetMessageJS('CVP_CATALOG_BASKET_UNKNOWN_ERROR') ?>',
		CBD_BTN_MESSAGE_SEND_PROPS: '<? echo GetMessageJS('CVP_CATALOG_BTN_MESSAGE_SEND_PROPS'); ?>',
		CBD_BTN_MESSAGE_CLOSE: '<? echo GetMessageJS('CVP_CATALOG_BTN_MESSAGE_CLOSE') ?>'
	});
	</script>
	<?

	$skuTemplate = array();
	if(is_array($arResult['SKU_PROPS']))
	{
		foreach ($arResult['SKU_PROPS'] as $iblockId => $skuProps)
		{
			$skuTemplate[$iblockId] = array();
			foreach ($skuProps as $arProp)
			{
				$propId = $arProp['ID'];
				$skuTemplate[$iblockId][$propId] = array(
					'SCROLL' => array(
						'START' => '',
						'FINISH' => '',
					),
					'FULL' => array(
						'START' => '',
						'FINISH' => '',
					),
					'ITEMS' => array()
				);
				if ('TEXT' == $arProp['SHOW_MODE'])
				{
					$skuTemplate[$iblockId][$propId]['SCROLL']['START'] = '';
					$skuTemplate[$iblockId][$propId]['SCROLL']['FINISH'] = '';

					$skuTemplate[$iblockId][$propId]['FULL']['START'] = '';
					$skuTemplate[$iblockId][$propId]['FULL']['FINISH'] = '';
					foreach ($arProp['VALUES'] as $value)
					{
						$value['NAME'] = htmlspecialcharsbx($value['NAME']);
						$skuTemplate[$iblockId][$propId]['ITEMS'][$value['ID']] = $value['NAME'];
					}
					unset($value);
				}
				elseif ('PICT' == $arProp['SHOW_MODE'])
				{
					$skuTemplate[$iblockId][$propId]['SCROLL']['START'] = '';
					$skuTemplate[$iblockId][$propId]['SCROLL']['FINISH'] = '';

					$skuTemplate[$iblockId][$propId]['FULL']['START'] = '';
					$skuTemplate[$iblockId][$propId]['FULL']['FINISH'] = '';
					foreach ($arProp['VALUES'] as $value)
					{
						$value['NAME'] = htmlspecialcharsbx($value['NAME']);
						$skuTemplate[$iblockId][$propId]['ITEMS'][$value['ID']] = $value['NAME'];
					}
					unset($value);
				}
				unset($arProp);
			}
		}
	}

	?>


    <ul class="accordion" data-accordion="" data-allow-all-closed="true">

        <li class="accordion-item look is-active" data-accordion-item="">
            <a class="text-center accordion-title recommendet-items">Вам также может понравиться</a>
            <div class="accordion-content" data-tab-content="" style="display: block">
                <div class="grid-x text-center grid-padding-x small-up-1 medium-up-2 large-up-4 margin-bottom-8" data-equalizer data-equalize-by-row="true">

                    <?
               /*     echo "<pre>";
                    var_dump($arResult["SKU_PROPS"]);
                    echo "</pre>";*/



                    foreach ($arResult['ITEMS'] as $key => $arItem)
                    {?>
                        <div class="cell position-relative">
                            <div class="dress">
                                <div class="dress__img" data-equalizer-watch>
                                    <a href="<? echo $arItem['DETAIL_PAGE_URL']; ?>">
                                        <img src="<?=$arItem['PREVIEW_PICTURE']['SRC'];?>">
                                        <?if ($arItem['SECOND_PICT'])
                                        {?>
                                            <img src="<? echo(
                                            !empty($arItem['PREVIEW_PICTURE_SECOND'])
                                                ? $arItem['PREVIEW_PICTURE_SECOND']['SRC']
                                                : $arItem['PREVIEW_PICTURE']['SRC']
                                            ); ?>">
                                        <?}?>
                                    </a>
                                </div>
                                <?
                                $strTitle = (
                                isset($arItem["IPROPERTY_VALUES"]["ELEMENT_PREVIEW_PICTURE_FILE_TITLE"]) && '' != isset($arItem["IPROPERTY_VALUES"]["ELEMENT_PREVIEW_PICTURE_FILE_TITLE"])
                                    ? $arItem["IPROPERTY_VALUES"]["ELEMENT_PREVIEW_PICTURE_FILE_TITLE"]
                                    : $arItem['NAME']
                                );
                                $productTitle = (
                                isset($arItem['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE'])&& $arItem['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE'] != ''
                                    ? $arItem['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE']
                                    : $arItem['NAME']
                                );
                                ?>
                                <div class="dress__title"><?=$productTitle;?></div>

                                <div class="text-size-large margin-bottom-4">
                                    <?
                                    if (!empty($arItem['MIN_PRICE']))
                                    {
                                        if (isset($arItem['OFFERS']) && !empty($arItem['OFFERS']))
                                        {
                                            $price = GetMessage(
                                                'CVP_TPL_MESS_PRICE_SIMPLE_MODE',
                                                array(
                                                    '#PRICE#' => $arItem['MIN_PRICE']['PRINT_DISCOUNT_VALUE'],
                                                    '#MEASURE#' => GetMessage(
                                                        'CVP_TPL_MESS_MEASURE_SIMPLE_MODE',
                                                        array(
                                                            '#VALUE#' => $arItem['MIN_PRICE']['CATALOG_MEASURE_RATIO'],
                                                            '#UNIT#' => $arItem['MIN_PRICE']['CATALOG_MEASURE_NAME']
                                                        )
                                                    )
                                                )
                                            );
                                            $price = str_replace("за", "", $price);
                                            $price = str_replace("от", "", $price);
                                            echo $price;
                                        }
                                        else
                                        {
                                            echo $arItem['MIN_PRICE']['PRINT_DISCOUNT_VALUE'];
                                        }
                                        if ('Y' == $arParams['SHOW_OLD_PRICE'] && $arItem['MIN_PRICE']['DISCOUNT_VALUE'] < $arItem['MIN_PRICE']['VALUE'])
                                        {
                                            ?> <?
                                            echo $arItem['MIN_PRICE']['PRINT_VALUE'];
                                            ?><?
                                        }
                                    }
                                    ?>
                                </div>


    <?/*ВЫВОД РАЗМЕРА*/?>
	<?if (!empty($arItem['OFFERS']) && isset($skuTemplate[$arItem['IBLOCK_ID']]))
	{
	$arSkuProps = array();
	?>
        <div class="dress__size">
            <div class="grid-container margin-top-15">
                   <div class="grid-x grid-padding-x">
                        <div class="cell small-12 medium-4">
                            <span class="margin-right-4 size_title">Размер</span>
                        </div>

                        <div class="cell small-12 medium-8">
                             <div class="checkbox-group">
                                <?
                                foreach ($skuTemplate[$arItem['IBLOCK_ID']] as $propId => $propTemplate)
                                {
                                    if (!isset($arItem['SKU_TREE_VALUES'][$propId]))
                                        continue;
                                    $valueCount = count($arItem['SKU_TREE_VALUES'][$propId]);
                                    if ($valueCount > 5)
                                    {
                                        $fullWidth = ($valueCount*20).'%';
                                        $itemWidth = (100/$valueCount).'%';
                                        $rowTemplate = $propTemplate['SCROLL'];
                                    }
                                    else
                                    {
                                        $fullWidth = '100%';
                                        $itemWidth = '20%';
                                        $rowTemplate = $propTemplate['FULL'];
                                    }
                                    unset($valueCount);



                                    foreach ($propTemplate['ITEMS'] as $value => $valueItem)
                                    {
                                        if (!isset($arItem['SKU_TREE_VALUES'][$propId][$value]))
                                            continue;
                                        ?>



                                        <?
                                        echo ' <a href="/men/muzhskaya-obuv/botinki/polubotinki-30679-41193-41193-gioseppo-temno-siniy/?size_cloth=41" class="chose_size_link">
                                                        <div class="checkbox-group__item sizeblock ">';
                                        echo str_replace(array('#ITEM#_prop_', '#WIDTH#'), array($arItemIDs['PROP'], $itemWidth), $valueItem);
                                        echo str_replace('#ITEM#_prop_', $arItemIDs['PROP'], $rowTemplate['FINISH']), '</div>
                                                    </a>';
                                    }
                                    unset($value, $valueItem);
                                }
                                ?>
                             </div>
                        </div>

                   </div>
             </div>
        </div>

    <?}?>

 <!--                               <div class="dress__size"><span class="margin-right-4">Размер</span>
                                    <div class="checkbox-group">
                                        <input class="checkbox-group__item" type="radio" id="size1" name="size">
                                        <label class="checkbox-group__label" for="size1">44</label>
                                        <input class="checkbox-group__item" type="radio" id="size2" name="size">
                                        <label class="checkbox-group__label" for="size2">46</label>
                                        <input class="checkbox-group__item" type="radio" id="size3" name="size">
                                        <label class="checkbox-group__label" for="size3">48</label>
                                    </div><a class="skirt__link" href="#">RU</a>
                                </div>-->

                            </div>
                        </div>
                    <?}?>

                </div>
            </div>
        </li>
    </ul>
</span>
<?
}

$frame->end();