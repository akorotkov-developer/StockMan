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
        <form method="post" action="<?=$arResult["AUTH_FORM"]?>" name="bform">
            <?if (strlen($arResult["BACKURL"]) > 0): ?>
                <input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
            <? endif ?>
            <input type="hidden" name="AUTH_FORM" value="Y">
            <input type="hidden" name="TYPE" value="CHANGE_PWD">

            <label><?=GetMessage("AUTH_LOGIN")?>
                <input type="text" name="USER_LOGIN" maxlength="255" value="<?=$arResult["LAST_LOGIN"]?>" />
            </label>

            <label><?=GetMessage("AUTH_CHECKWORD")?>
                <input type="text" name="USER_CHECKWORD" maxlength="255" value="<?=$arResult["USER_CHECKWORD"]?>" />
            </label>

            <label><?=GetMessage("AUTH_NEW_PASSWORD_REQ")?>
                <?if($arResult["SECURE_AUTH"]):?>
                    <div class="bx-authform-psw-protected" id="bx_auth_secure" style="display:none"><div class="bx-authform-psw-protected-desc"><span></span><?echo GetMessage("AUTH_SECURE_NOTE")?></div></div>

                    <script type="text/javascript">
                        document.getElementById('bx_auth_secure').style.display = '';
                    </script>
                <?endif?>
                <input type="password" name="USER_PASSWORD" maxlength="255" value="<?=$arResult["USER_PASSWORD"]?>" autocomplete="off" />
            </label>

            <label><?=GetMessage("AUTH_NEW_PASSWORD_CONFIRM")?>
                <?if($arResult["SECURE_AUTH"]):?>
                    <div class="bx-authform-psw-protected" id="bx_auth_secure_conf" style="display:none"><div class="bx-authform-psw-protected-desc"><span></span><?echo GetMessage("AUTH_SECURE_NOTE")?></div></div>

                    <script type="text/javascript">
                        document.getElementById('bx_auth_secure_conf').style.display = '';
                    </script>
                <?endif?>
                <input type="password" name="USER_CONFIRM_PASSWORD" maxlength="255" value="<?=$arResult["USER_CONFIRM_PASSWORD"]?>" autocomplete="off" />
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


            <button class="button small-expanded"><?=GetMessage("AUTH_CHANGE")?> &nbsp;<i class="fa fa-envelope-o fa-lg"></i></button>

            <div class="bx-authform-description-container">
                <?echo $arResult["GROUP_POLICY"]["PASSWORD_REQUIREMENTS"];?>
            </div>

            <div class="bx-authform-link-container">
                <a href="<?=$arResult["AUTH_AUTH_URL"]?>"><?=GetMessage("AUTH_AUTH")?></a>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript">
document.bform.USER_LOGIN.focus();
</script>
