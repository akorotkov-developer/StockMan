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
<?if($arParams["DISPLAY_PICTURE"]!="N" && is_array($arResult["DETAIL_PICTURE"])){?>
    <div class="margin-bottom-20">
        <img src="<?=$arResult["IMG_SMALL"]["src"]?>" alt="<?=$arResult["DETAIL_PICTURE"]["ALT"]?>"title="<?=$arResult["DETAIL_PICTURE"]["TITLE"]?>" />
    </div>
<?}?>

<div class="text-left">
<?/*if($arParams["DISPLAY_DATE"]!="N" && $arResult["DISPLAY_ACTIVE_FROM"]):?>
    <span class="news-date-time"><?=$arResult["DISPLAY_ACTIVE_FROM"]?></span>
<?endif;*/?>
<?if($arResult["NAV_RESULT"]):?>
    <?if($arParams["DISPLAY_TOP_PAGER"]):?><?=$arResult["NAV_STRING"]?><br /><?endif;?>
    <?echo $arResult["NAV_TEXT"];?>
    <?if($arParams["DISPLAY_BOTTOM_PAGER"]):?><br /><?=$arResult["NAV_STRING"]?><?endif;?>
<?elseif(strlen($arResult["DETAIL_TEXT"])>0):?>
    <?echo $arResult["DETAIL_TEXT"];?>
<?else:?>
    <?echo $arResult["PREVIEW_TEXT"];?>
<?endif?>
</div>
