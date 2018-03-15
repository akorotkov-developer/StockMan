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
<ul class="accordion" data-accordion data-multi-expand="true" data-allow-all-closed="true">
    <?foreach($arResult["ITEMS"] as $arItem){?>
    <li class="accordion-item" data-accordion-item>
        <a class="accordion-title" href="#<?=$arItem["ID"]?>"><?=$arItem["PREVIEW_TEXT"]?></a>
        <div class="accordion-content" data-tab-content>
            <p><?=$arItem["DETAIL_TEXT"]?></p>
        </div>
    </li>
    <?}?>
</ul>