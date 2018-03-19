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

        <div style="display: none;">
            <?if (isset($arResult['RUBRICS'])):?>
                <br/>
                <?foreach($arResult['RUBRICS'] as $RID => $title):?>
                <input type="checkbox" name="asd_rub[]" id="rub<?= $RID?>" value="<?= $RID?>" />
                <label for="rub<?= $RID?>"><?= $title?></label><br/>
                <?endforeach;?>
            <?endif;?>
        </div>
    </form>
</div>
