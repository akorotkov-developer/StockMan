<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?><?

ShowMessage($arParams["~AUTH_RESULT"]);
?>
<div class="grid-x grid-padding-x">
    <div class="cell text-center">
        <h2 class="reveal__title">Забыли пароль</h2>
    </div>
    <div class="cell">
        <form name="bform" method="post" target="_top" action="<?=$arResult["AUTH_URL"]?>">
        <?
        if (strlen($arResult["BACKURL"]) > 0)
        {
        ?>
            <input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
        <?
        }
        ?>
            <input type="hidden" name="AUTH_FORM" value="Y">
            <input type="hidden" name="TYPE" value="SEND_PWD">

            <div>Если вы забыли пароль, введите логин или E-Mail.</div>
            <input type="text" name="USER_LOGIN" maxlength="50" value="<?=$arResult["LAST_LOGIN"]?>" placeholder="<?=GetMessage("AUTH_LOGIN")?>"/>&nbsp;
            <input type="email" name="USER_EMAIL" maxlength="255" placeholder="<?=GetMessage("AUTH_EMAIL")?>"/>
            <p>
                Контрольная строка для смены пароля, а также ваши регистрационные данные, будут высланы вам по E-Mail.</p>

            <div class="grid-x align-center">
                <div class="cell large-7">
                    <input class="button expanded" type="submit" name="send_account_info" value="<?=GetMessage("AUTH_SEND")?>" />
                </div>
            </div>
        </form>
        <p class="text-center"><a  data-open="enter-popup">Войти</a></p>
    </div>
</div>

<button class="close-button" data-close aria-label="Закрыть"><span aria-hidden="true">&times;</span></button>

<script type="text/javascript">
document.bform.USER_LOGIN.focus();
</script>
