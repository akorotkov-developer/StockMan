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
$this->setFrameMode(true);?>

<div class="hide-for-small-only large-3 cell medium-3 text-center medium-text-left">
    <form class="search-top input-group" action="<?=$arResult["FORM_ACTION"]?>" method="get">
        <input class="search-top__input input-group-field" type="text" name="q" value="" placeholder="Поиск">
        <div class="input-group-button">
            <button class="search-top__button fa fa-search" name="s" type="submit"></button>
        </div>
    </form>
</div>