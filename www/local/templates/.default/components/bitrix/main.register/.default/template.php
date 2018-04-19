<?
/**
 * Bitrix Framework
 * @package bitrix
 * @subpackage main
 * @copyright 2001-2014 Bitrix
 */

/**
 * Bitrix vars
 * @global CMain $APPLICATION
 * @global CUser $USER
 * @param array $arParams
 * @param array $arResult
 * @param CBitrixComponentTemplate $this
 */

if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
	die();
?>
<?if(!$USER->IsAuthorized()){?>

    <div class="grid-x grid-padding-x" xmlns="http://www.w3.org/1999/html">

            <div class="cell text-center">
                <h2 class="reveal__title">Регистрация</h2>
            </div>

                <?if($USER->IsAuthorized()):?>

                    <p><?echo GetMessage("MAIN_REGISTER_AUTH")?></p>

                <?else:?>
                <?
                if ($_POST) {
                    if (count($arResult["ERRORS"]) > 0):
                        foreach ($arResult["ERRORS"] as $key => $error)
                            if (intval($key) == 0 && $key !== 0)
                                $arResult["ERRORS"][$key] = str_replace("#FIELD_NAME#", "&quot;".GetMessage("REGISTER_FIELD_".$key)."&quot;", $error);

                        ShowError(implode("<br />", $arResult["ERRORS"]));

                    elseif($arResult["USE_EMAIL_CONFIRMATION"] === "Y"):
                        $successregister = true;
                        ?>
                        <p><?echo GetMessage("REGISTER_EMAIL_WILL_BE_SENT")?></p>
                    <?endif?>
                <?}?>


            <?if (!$successregister) {?>
                <div class="cell">
                    <form method="post" action="<?=POST_FORM_ACTION_URI?>" name="regform" enctype="multipart/form-data">
                        <?
                        if($arResult["BACKURL"] <> ''):
                        ?>
                            <input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
                        <?
                        endif;
                        ?>

                        <label>
                            <input type="text" name="REGISTER[NAME]" value="<?=$arResult["VALUES"]['NAME']?>" placeholder="Имя*" required>
                        </label>
                        <label>
                            <input type="text" name="REGISTER[LAST_NAME]" value="<?=$arResult["VALUES"]['LAST_NAME']?>" placeholder="Фамилия">
                        </label>
                        <label>
                            <input type="text" name="REGISTER[SECOND_NAME]" value="<?=$arResult["VALUES"]['SECOND_NAME']?>" placeholder="Отчество">
                        </label>

                        <div class="check">
                            <input class="check__input" type="radio" name="REGISTER[PERSONAL_GENDER]" id="a11" checked="" value="M">
                            <label class="check__label" for="a11"><?=GetMessage("USER_MALE")?></label>
                        </div>
                        <div class="check">
                            <input class="check__input" type="radio" name="REGISTER[PERSONAL_GENDER]" id="a21" value="F">
                            <label class="check__label" for="a21"><?=GetMessage("USER_FEMALE")?></label>
                        </div>

                        <div class="grid-x grid-padding-x">
                            <div class="cell medium-9">
                                <label>
                                    <input type="tel"  name="REGISTER[LOGIN]" value="<?=$arResult["VALUES"]['LOGIN']?>" placeholder="Логин*" required>
                                </label>
                                <label>
                                    <input type="email"  name="REGISTER[EMAIL]" value="<?=$arResult["VALUES"]['EMAIL']?>" placeholder="e-mail*" required>
                                </label>
                                <label>
                                    <input type="tel"  class="x-mask-phone" name="REGISTER[PERSONAL_PHONE]" value="<?=$arResult["VALUES"]['PERSONAL_PHONE']?>" placeholder="Телефон*" required>
                                </label>
                                <label>
                                    <input type="text" name="REGISTER[PERSONAL_BIRTHDAY]" value="<?=$arResult["VALUES"]['PERSONAL_BIRTHDAY']?>" placeholder="Дата рождения">
                                </label>
                                <label>
                                    <input type="password" name="REGISTER[PASSWORD]" value="<?=$arResult["VALUES"]['PASSWORD']?>" placeholder="Пароль*" required>
                                </label>
                                <label>
                                    <input type="password" name="REGISTER[CONFIRM_PASSWORD]" value="<?=$arResult["VALUES"]['CONFIRM_PASSWORD']?>" placeholder="Повторите пароль*" required>
                                </label>
                                <p class="help-text">Пароль должен быть не менее 6 символов</p>
                                <p class="help-text">* - обязательные поля</p>

                                <?/* CAPTCHA */
                                if ($arResult["USE_CAPTCHA"] == "Y")
                                {
                                    ?>
                                    <label>
                                        <?=GetMessage("REGISTER_CAPTCHA_TITLE")?>
                                        <input type="hidden" name="captcha_sid" value="<?=$arResult["CAPTCHA_CODE"]?>" />
                                        <img src="/bitrix/tools/captcha.php?captcha_sid=<?=$arResult["CAPTCHA_CODE"]?>" width="180" height="40" alt="CAPTCHA" />
                                    </label>
                                    <label>
                                        <?=GetMessage("REGISTER_CAPTCHA_PROMT")?>:<span class="starrequired">*</span>
                                        <input type="text" name="captcha_word" maxlength="50" value="" required/>
                                    </label>
                                    <?
                                }
                                /* !CAPTCHA */
                                ?>
                            </div>

                            <div class="cell">
                                <div class="check">
                                    <input class="check__input" name="license" type="checkbox" id="y11">
                                    <label class="check__label" for="y11">Я ознакомлен и принимаю условия &nbsp;<a href="/soglasie/" target="_blank" title="">Соглашения об использовании сайта</a>, в том числе в части обработки и использования моих персональных данных</label>
                                </div>
                                <div class="check">
                                    <input class="check__input" type="checkbox" name="REGISTER[UF_SUBSCRIBE]" checked id="y21">
                                    <label class="check__label" for="y21">Я хочу получать информацию об акция и скидках</label>
                                </div>
                            </div>
                        </div>

                        <div class="grid-x align-center">
                            <div class="cell large-7">
                                <button class="button expanded" type="submit" disabled name="register_submit_button" value="<?=GetMessage("AUTH_REGISTER")?>" />
                                <?=GetMessage("AUTH_REGISTER")?>
                                <i class="fa fa-sign-in fa-lg"></i></button>
                                </button>
                            </div>
                        </div>

                    </form>
                </div>
            <?}?>
            <?endif?>
        </div>
        <button class="close-button" data-close aria-label="Закрыть"><span aria-hidden="true">&times;</span></button>


    <script type="text/javascript">
        $('[name="license"]').click(function(){
            if ($(this).is(':checked')){
                $('[name="register_submit_button"]').prop('disabled', false);
            } else {
                $('[name="register_submit_button"]').prop('disabled', true);
            }
        });
    </script>

<?}?>