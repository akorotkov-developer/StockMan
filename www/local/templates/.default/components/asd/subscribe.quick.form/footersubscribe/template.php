<?php if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true)die();

if (method_exists($this, 'setFrameMode')) {
	$this->setFrameMode(true);
}

if ($arResult['ACTION']['status']=='error') {
	ShowError($arResult['ACTION']['message']);
} elseif ($arResult['ACTION']['status']=='ok') {
	ShowNote($arResult['ACTION']['message']);
}
?>




<div id="asd_subscribe_res" style="display: none;"></div>
<div class="small-12 medium-6 large-3 cell">
    <div class="margin-bottom-5 show-for-small-only"></div>
    <div class="subscribe">Подписаться на рассылку</div>
    <form action="<?= POST_FORM_ACTION_URI?>" method="post" id="asd_subscribe_form">
        <?= bitrix_sessid_post()?>
        <input type="hidden" name="asd_subscribe" value="Y" />
        <input type="hidden" name="charset" value="<?= SITE_CHARSET?>" />
        <input type="hidden" name="site_id" value="<?= SITE_ID?>" />
        <input type="hidden" name="asd_rubrics" value="<?= $arParams['RUBRICS_STR']?>" />
        <input type="hidden" name="asd_format" value="<?= $arParams['FORMAT']?>" />
        <input type="hidden" name="asd_show_rubrics" value="<?= $arParams['SHOW_RUBRICS']?>" />
        <input type="hidden" name="asd_not_confirm" value="<?= $arParams['NOT_CONFIRM']?>" />
        <input type="hidden" name="asd_key" value="<?= md5($arParams['JS_KEY'].$arParams['RUBRICS_STR'].$arParams['SHOW_RUBRICS'].$arParams['NOT_CONFIRM'])?>" />


        <div class="input-group footer__group">
            <input class="input-group-field" type="email" name="asd_email"  value="" placeholder="Ваш e-mail">
            <div class="input-group-button">
                <input class="button footer__button" name="asd_submit" id="asd_subscribe_submit" type="submit" value="Отправить">
            </div>
        </div>

        <?if (isset($arResult['RUBRICS'])){?>
            <div class="check">
                <input class="check__input check_men" type="checkbox" name="asd_rub[]" id="rub<?=StockMan\Config::SUB_MEN?>" value="<?=StockMan\Config::SUB_MEN?>" checked>
                <label class="check__label" for="rub<?=StockMan\Config::SUB_MEN?>">Мужчинам</label>
            </div>
            <div class="check" style="display:none">
                <input class="check__input check_men" type="checkbox" name="asd_rub[]" id="rub<?=StockMan\Config::SUB_MEN_ACTIONS?>" value="<?=StockMan\Config::SUB_MEN_ACTIONS?>" checked>
                <label class="check__label" for="rub<?=StockMan\Config::SUB_MEN_ACTIONS?>">Мужчинам Скидки</label>
            </div>
            <div class="check" style="display:none">
                <input class="check__input check_men" type="checkbox" name="asd_rub[]" id="rub<?=StockMan\Config::SUB_MEN_NEW?>" value="<?=StockMan\Config::SUB_MEN_NEW?>" checked>
                <label class="check__label" for="rub<?=StockMan\Config::SUB_MEN_NEW?>">Мужчинам Новинки</label>
            </div>


            <div class="check">
                <input class="check__input check_women" type="checkbox" name="asd_rub[]" id="rub<?=StockMan\Config::SUB_WOMEN?>" value="<?=StockMan\Config::SUB_WOMEN?>" >
                <label class="check__label" for="rub<?=StockMan\Config::SUB_WOMEN?>">Женщинам</label>
            </div>
            <div class="check" style="display:none">
                <input class="check__input check_women" type="checkbox" name="asd_rub[]" id="rub<?=StockMan\Config::SUB_WOMEN_ACTIONS?>" value="<?=StockMan\Config::SUB_WOMEN_ACTIONS?>" >
                <label class="check__label" for="rub<?=StockMan\Config::SUB_WOMEN_ACTIONS?>">Женщинам Скидки</label>
            </div>
            <div class="check" style="display:none">
                <input class="check__input check_women" type="checkbox" name="asd_rub[]" id="rub<?=StockMan\Config::SUB_WOMEN_NEW?>" value="<?=StockMan\Config::SUB_WOMEN_NEW?>" >
                <label class="check__label" for="rub<?=StockMan\Config::SUB_WOMEN_NEW?>">Женщинам Новинки</label>
            </div>


            <div class="check">
                <input class="check__input check_kids" type="checkbox" name="asd_rub[]" id="rub<?=StockMan\Config::SUB_KIDS?>" value="<?=StockMan\Config::SUB_KIDS?>" >
                <label class="check__label" for="rub<?=StockMan\Config::SUB_KIDS?>">Детям</label>
            </div>
            <div class="check" style="display:none">
                <input class="check__input check_kids" type="checkbox" name="asd_rub[]" id="rub<?=StockMan\Config::SUB_KIDS_NEW?>" value="<?=StockMan\Config::SUB_KIDS_NEW?>" >
                <label class="check__label" for="rub<?=StockMan\Config::SUB_KIDS_NEW?>">Детям Скидки</label>
            </div>
            <div class="check" style="display:none">
                <input class="check__input check_kids" type="checkbox" name="asd_rub[]" id="rub<?=StockMan\Config::SUB_KIDS_ACTIONS?>" value="<?=StockMan\Config::SUB_KIDS_ACTIONS?>" >
                <label class="check__label" for="rub<?=StockMan\Config::SUB_KIDS_ACTIONS?>">Детям Новинки</label>
            </div>

        <?}?>

    </form>
</div>

