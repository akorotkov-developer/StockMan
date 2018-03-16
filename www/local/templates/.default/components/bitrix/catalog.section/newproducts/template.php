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
{?>
    <div class="grid-x grid-padding-x text-center">
        <div class="cell margin-bottom-20">
            <div class="cat text-center">
                <h2 class="cat__head"><?=GetMessage("CT_BCS_CATALOG_TITLE")?></h2>
            </div>
        </div>
    </div>
    <div class="map text-center margin-bottom-10">
        <?
        foreach ($arResult['ITEMS'] as $key => $arItem)
        {
            $productTitle = (
                isset($arItem['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE'])&& $arItem['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE'] != ''
                ? $arItem['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE']
                : $arItem['NAME']
            );

            $minPrice = false;
            if (isset($arItem['MIN_PRICE']) || isset($arItem['RATIO_PRICE']))
                $minPrice = (isset($arItem['RATIO_PRICE']) ? $arItem['RATIO_PRICE'] : $arItem['MIN_PRICE']);
            ?>
                <div class="map__slide">
                    <a class="dress dress_static" href="<?=$arItem["DETAIL_PAGE_URL"]?>">
                        <div class="margin-bottom-3">
                            <img src='<? echo $arItem['P_PICTURE']['SRC']; ?>' alt="<? echo $imgTitle; ?>">
                        </div>
                        <div class="dress__title"><?=$arItem["DISPLAY_PROPERTIES"][StockMan\Config::BREND]["DISPLAY_VALUE"];?></div>
                        <div class="text-secondary"><?=$productTitle;?></div>
                        <div class="text-size-large"><?=$minPrice["PRINT_DISCOUNT_VALUE"]?> - </div>
                    </a>
                </div>
            <?

        }
        ?>
    </div>
<?
}