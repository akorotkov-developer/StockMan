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
    <div class="map text-center margin-bottom-10">
        <?
        foreach ($arResult['ITEMS'] as $key => $arItem)
        {
            $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], $strElementEdit);
            $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], $strElementDelete, $arElementDeleteParams);
            $strMainID = $this->GetEditAreaId($arItem['ID']);



            $productTitle = (
                isset($arItem['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE'])&& $arItem['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE'] != ''
                ? $arItem['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE']
                : $arItem['NAME']
            );

            $minPrice = false;
            if (isset($arItem['MIN_PRICE']) || isset($arItem['RATIO_PRICE']))
                $minPrice = (isset($arItem['RATIO_PRICE']) ? $arItem['RATIO_PRICE'] : $arItem['MIN_PRICE']);
            ?>
                <div class="map__slide" id="<? echo $strMainID; ?>">
                    <a class="dress dress_static" href="<?=$arItem["DETAIL_PAGE_URL"]?>">
                        <div class="margin-bottom-3">
                            <img src='<? echo (!empty($arItem['PREVIEW_PICTURE_SECOND']) ? $arItem['PREVIEW_PICTURE_SECOND']['SRC'] : $arItem['PREVIEW_PICTURE']['SRC']); ?>' alt="<? echo $imgTitle; ?>">
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