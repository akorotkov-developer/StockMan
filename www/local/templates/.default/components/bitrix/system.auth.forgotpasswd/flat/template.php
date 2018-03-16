<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
{
    die();
}

/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 */

?>
<div class="grid-x grid-padding-x align-center">
    <div class="cell small-12 medium-8 large-6">
        <?
        if(!empty($arParams["~AUTH_RESULT"])):
            $text = str_replace(array("<br>", "<br />"), "\n", $arParams["~AUTH_RESULT"]["MESSAGE"]);
            ?>
            <div class="callout <?=($arParams["~AUTH_RESULT"]["TYPE"] == "OK"? "success":"alert")?>"><?=nl2br(htmlspecialcharsbx($text))?></div>
        <?endif?>

        <?echo GetMessage("AUTH_FORGOT_PASSWORD_1")?>
        <form name="bform" method="post" target="_top" action="<?=$arResult["AUTH_URL"]?>">
            <?if($arResult["BACKURL"] <> ''):?>
                <input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
            <?endif?>
            <input type="hidden" name="AUTH_FORM" value="Y">
            <input type="hidden" name="TYPE" value="SEND_PWD">

            <label><?echo GetMessage("AUTH_LOGIN_EMAIL")?>
                <input type="text" name="USER_LOGIN" maxlength="255" value="<?=$arResult["LAST_LOGIN"]?>" />
            </label>
            <label><?echo GetMessage("AUTH_EMAIL")?>
                <input type="text" name="USER_EMAIL" maxlength="255" value="" />
            </label>

            <?if ($arResult["USE_CAPTCHA"]):?>
                <input type="hidden" name="captcha_sid" value="<?=$arResult["CAPTCHA_CODE"]?>" />

                <div class="bx-authform-formgroup-container">
                    <div class="bx-authform-label-container"><?echo GetMessage("system_auth_captcha")?></div>
                    <div class="bx-captcha"><img src="/bitrix/tools/captcha.php?captcha_sid=<?=$arResult["CAPTCHA_CODE"]?>" width="180" height="40" alt="CAPTCHA" /></div>
                    <div class="bx-authform-input-container">
                        <input type="text" name="captcha_word" maxlength="50" value="" autocomplete="off"/>
                    </div>
                </div>

            <?endif?>

            <button class="button small-expanded"><?=GetMessage("AUTH_GET_CHECK_STRING")?> &nbsp;<i class="fa fa-envelope-o fa-lg"></i></button>
        </form>
        <p><a href="<?=$arResult["AUTH_AUTH_URL"]?>"><?=GetMessage("AUTH_AUTH")?></a></p>
    </div>
</div>

<script type="text/javascript">
    document.bform.onsubmit = function(){document.bform.USER_EMAIL.value = document.bform.USER_LOGIN.value;};
    document.bform.USER_LOGIN.focus();
</script>
