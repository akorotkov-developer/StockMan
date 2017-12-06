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

<div class="sale margin-bottom-9">
    <?foreach($arResult["ITEMS"] as $arItem):?>
        <?
        $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
        $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
        ?>

        <?$arFile = CFile::GetFileArray($arItem["PROPERTIES"]["MOBILE_PICTURE"]["VALUE"]);?>

        <a id="<?=$this->GetEditAreaId($arItem['ID']);?>" class="sale__slide" href="<?=$arItem["PROPERTIES"]["URL"]["VALUE"]?>"  style="background-image:url(<?=$arItem["DETAIL_PICTURE"]["SRC"]?>);" >
            <div class="sale__mobile" style="background-image:url(<?=$arFile["SRC"]?>);"></div>
        </a>

    <?endforeach;?>
</div>


