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

<div class="cell show-for-small-only small-2 header__detective" data-responsive-toggle="search-menu" data-hide-for="medium">
    <img src="<?=StockMan\Config::STOCKMAN_TEMPLATE_PATH?>/images/search.svg" alt="" data-toggle="search-menu">
    <div class="detective" id="search-menu">
        <form class="search-top input-group" action="<?=$arResult["FORM_ACTION"]?>" method="get">
            <?if($arParams["USE_SUGGEST"] === "Y"){
                $APPLICATION->IncludeComponent(
                    "bitrix:search.suggest.input",
                    "",
                    array(
                        "NAME" => "q",
                        "VALUE" => "",
                        "INPUT_SIZE" => 15,
                        "DROPDOWN_SIZE" => 10,
                    ),
                    $component, array("HIDE_ICONS" => "Y")
                );
            } else {
                ?><input class="search-top__input input-group-field" type="text" name="q" value="" size="15" maxlength="50" placeholder="Поиск"/><?
            }?>
            <div class="input-group-button">
                <button class="search-top__button fa fa-search" type="submit"></button>
            </div>
        </form>
    </div>
</div>