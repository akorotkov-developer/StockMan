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
?>


<div  class="cell large-6" id="subscribe-form">
<?
$frame = $this->createFrame("subscribe-form", false)->begin();
?>
    <form action="<?=$arResult["FORM_ACTION"]?>">
        <div class="input-group footer__group">
            <input class="mail text-center" type="email" name="sf_EMAIL" value="<?=$arResult["EMAIL"]?>" placeholder="укажите свой адрес электронной почты">
            <input class="button footer__button" type="submit" name="OK" value="<?=GetMessage("subscr_form_button")?>" style="display:none"/>
        </div>
        <?foreach($arResult["RUBRICS"] as $itemID => $itemValue):?>
            <div class="check" style="display: none;">
                <input class="check__input" type="radio" name="sf_RUB_ID[]" id="sf_RUB_ID_<?=$itemValue["ID"]?>" value="<?=$itemValue["ID"]?>" <?if($itemValue["CHECKED"]) echo " checked"?> />
                <label class="check__label" for="sf_RUB_ID_<?=$itemValue["ID"]?>"><?=$itemValue["NAME"]?></label>
            </div>
        <?endforeach;?>
    </form>
<?
$frame->beginStub();
?>
    <form action="<?=$arResult["FORM_ACTION"]?>">
        <div class="input-group footer__group">
            <input class="mail text-center" type="email" name="sf_EMAIL" value="<?=$arResult["EMAIL"]?>" placeholder="укажите свой адрес электронной почты">
            <input class="button footer__button" type="submit" name="OK" value="<?=GetMessage("subscr_form_button")?>" style="display:none"/>
        </div>
        <?foreach($arResult["RUBRICS"] as $itemID => $itemValue):?>
            <div class="check" style="display: none;">
                <input class="check__input" type="radio" name="sf_RUB_ID[]" id="sf_RUB_ID_<?=$itemValue["ID"]?>" value="<?=$itemValue["ID"]?>" <?if($itemValue["CHECKED"]) echo " checked"?> />
                <label class="check__label" for="sf_RUB_ID_<?=$itemValue["ID"]?>"><?=$itemValue["NAME"]?></label>
            </div>
        <?endforeach;?>
    </form>
<?
$frame->end();
?>
</div>
