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
<div class="grid-x grid-padding-x x-masonry">
<?
$count = count($arResult["ITEMS"]);
foreach($arResult["ITEMS"] as $key => $arItem){
    $l = 4;
    $m = 6;
    /*if (($key != 0) and ($key % 3 == 1)) {
        $l = 5;
        $m = 5;
    }
    if (($key != 0) and ($key % 3 == 2)) {
        $l = 4;
        $m = 4;
    }*/
    ?>
    <div class="cell large-<?=$l?> medium-<?=$m?> x-masonry-item">
        <a class="action" href="<?=$arItem["DETAIL_PAGE_URL"]?>">
            <?if (isset($arItem["IMG_SMALL"]["src"]{1})) {?>
                <img src="<?=$arItem["IMG_SMALL"]["src"]?>" alt="<?=$arItem["PREVIEW_PICTURE"]["ALT"]?>" title="<?=$arItem["PREVIEW_PICTURE"]["TITLE"]?>" />
            <?}?>
            <div class="text-left action__text_nolink margin-top-3">
                <div class="text-dark-gray"><?echo $arItem["DATE_ACTIVE_FROM"]?></div>
                <h6><?echo $arItem["NAME"]?></h6>
            </div>
        </a>
    </div>
<?}?>
</div>
<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
	<?=$arResult["NAV_STRING"]?>
<?endif;?>
