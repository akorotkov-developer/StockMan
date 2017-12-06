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
<div class="map text-center margin-bottom-10">
    <?foreach($arResult["ITEMS"] as $arItem):?>
        <?
        $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
        $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
        ?>

            <div class="map__slide"  id="<?=$this->GetEditAreaId($arItem['ID']);?>">
                <a class="dress dress_static" href="#">
                    <div class="margin-bottom-3"><img src="<?=$arItem["DETAIL_PICTURE"]["SRC"]?>"></div>
                    <div class="dress__title"><?=$arItem["BRAND_REF_NAME"]?></div>
                    <div class="text-secondary"><?=$arItem["NAME"]?></div>
                    <div class="text-size-large">49 765. - </div>
                </a>
            </div>

    <?endforeach;?>
</div>


