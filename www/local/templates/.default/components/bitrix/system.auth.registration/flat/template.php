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
 * @var array $arParams
 * @var array $arResult
 * @var CBitrixComponentTemplate $this
 */

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

//one css for all system.auth.* forms
$APPLICATION->SetAdditionalCSS("/bitrix/css/main/system.auth/flat/style.css");
?>



<div class="grid-x grid-padding-x">
    <div class="text-center cell small-12 medium-6 medium-offset-3 large-4 large-offset-4">

        <div class="bx-authform">
        <?
        if(!empty($arParams["~AUTH_RESULT"])):
            $text = str_replace(array("<br>", "<br />"), "\n", $arParams["~AUTH_RESULT"]["MESSAGE"]);
        ?>

        <?endif?>

        <?if($arResult["USE_EMAIL_CONFIRMATION"] === "Y" && is_array($arParams["AUTH_RESULT"]) &&  $arParams["AUTH_RESULT"]["TYPE"] === "OK"):?>

        <?else:?>

        <?if($arResult["USE_EMAIL_CONFIRMATION"] === "Y"):?>

        <?endif?>

        <noindex>
            <form method="post" action="<?=$arResult["AUTH_URL"]?>" name="bform" enctype="multipart/form-data">
        <?if($arResult["BACKURL"] <> ''):?>
                <input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
        <?endif?>
                <input type="hidden" name="AUTH_FORM" value="Y" />
                <input type="hidden" name="TYPE" value="REGISTRATION" />



                    <label>
                        <input required type="text" name="USER_NAME" maxlength="255" value="<?=$arResult["USER_NAME"]?>" placeholder="<?=GetMessage("AUTH_NAME")?>"/>
                    </label>



                    <label >
                        <input required type="text" name="USER_LAST_NAME" maxlength="255" value="<?=$arResult["USER_LAST_NAME"]?>" placeholder="<?=GetMessage("AUTH_LAST_NAME")?>" />
                    </label>



                    <label >
                        <input required type="text" name="USER_LOGIN" maxlength="255" value="<?=$arResult["USER_LOGIN"]?>" placeholder="<?=GetMessage("AUTH_LOGIN_MIN")?>"/>
                    </label>





        <?if($arResult["SECURE_AUTH"]):?>
                        <div class="bx-authform-psw-protected" id="bx_auth_secure" style="display:none"><div class="bx-authform-psw-protected-desc"><span></span><?echo GetMessage("AUTH_SECURE_NOTE")?></div></div>

        <script type="text/javascript">
        document.getElementById('bx_auth_secure').style.display = '';
        </script>
        <?endif?>
                <label>
                        <input required type="password" name="USER_PASSWORD" maxlength="255" value="<?=$arResult["USER_PASSWORD"]?>" autocomplete="off" placeholder="<?=GetMessage("AUTH_PASSWORD_REQ")?>"/>
                </label>





        <?if($arResult["SECURE_AUTH"]):?>
                        <div class="bx-authform-psw-protected" id="bx_auth_secure_conf" style="display:none"><div class="bx-authform-psw-protected-desc"><span></span><?echo GetMessage("AUTH_SECURE_NOTE")?></div></div>

        <script type="text/javascript">
        document.getElementById('bx_auth_secure_conf').style.display = '';
        </script>
        <?endif?>
            <label>
                  <input required type="password" name="USER_CONFIRM_PASSWORD" maxlength="255" value="<?=$arResult["USER_CONFIRM_PASSWORD"]?>" autocomplete="off" placeholder="<?=GetMessage("AUTH_CONFIRM")?>"/>
            </label>



                    <label>
                        <input required type="text" name="USER_EMAIL" maxlength="255" value="<?=$arResult["USER_EMAIL"]?>" placeholder="<?=GetMessage("AUTH_EMAIL")?>"/>
                    </label>


        <?if($arResult["USER_PROPERTIES"]["SHOW"] == "Y"):?>
            <?foreach ($arResult["USER_PROPERTIES"]["DATA"] as $FIELD_NAME => $arUserField):?>


<label>
    <?=$arUserField["EDIT_FORM_LABEL"]?>
        <?
        $APPLICATION->IncludeComponent(
            "bitrix:system.field.edit",
            $arUserField["USER_TYPE"]["USER_TYPE_ID"],
            array(
                "bVarsFromForm" => $arResult["bVarsFromForm"],
                "arUserField" => $arUserField,
                "form_name" => "bform"
            ),
            null,
            array("HIDE_ICONS"=>"Y")
        );
        ?>
</label>



            <?endforeach;?>
        <?endif;?>
        <?if ($arResult["USE_CAPTCHA"] == "Y"):?>
                <input type="hidden" name="captcha_sid" value="<?=$arResult["CAPTCHA_CODE"]?>" />


                    <div class="bx-captcha"><img src="/bitrix/tools/captcha.php?captcha_sid=<?=$arResult["CAPTCHA_CODE"]?>" width="180" height="40" alt="CAPTCHA" /></div>
                    <br>
                    <label>
                        <input type="text" name="captcha_word" maxlength="50" value="" autocomplete="off"/>
                    </label>


        <?endif?>
                <div class="bx-authform-formgroup-container">
                    <div class="bx-authform-label-container">
                    </div>
                    <div class="bx-authform-input-container">
                        <?$APPLICATION->IncludeComponent("bitrix:main.userconsent.request", "",
                            array(
                                "ID" => COption::getOptionString("main", "new_user_agreement", ""),
                                "IS_CHECKED" => "Y",
                                "AUTO_SAVE" => "N",
                                "IS_LOADED" => "Y",
                                "ORIGINATOR_ID" => $arResult["AGREEMENT_ORIGINATOR_ID"],
                                "ORIGIN_ID" => $arResult["AGREEMENT_ORIGIN_ID"],
                                "INPUT_NAME" => $arResult["AGREEMENT_INPUT_NAME"],
                                "REPLACE" => array(
                                    "button_caption" => GetMessage("AUTH_REGISTER"),
                                    "fields" => array(
                                        rtrim(GetMessage("AUTH_NAME"), ":"),
                                        rtrim(GetMessage("AUTH_LAST_NAME"), ":"),
                                        rtrim(GetMessage("AUTH_LOGIN_MIN"), ":"),
                                        rtrim(GetMessage("AUTH_PASSWORD_REQ"), ":"),
                                        rtrim(GetMessage("AUTH_EMAIL"), ":"),
                                    )
                                ),
                            )
                        );?>
                    </div>
                </div>

                    <input type="submit" class="button" name="Register" value="Зарегистрироваться" />


                <hr class="bxe-light">

                <div class="bx-authform-description-container">
                    <?echo $arResult["GROUP_POLICY"]["PASSWORD_REQUIREMENTS"];?>
                </div>

                <div class="bx-authform-description-container">
                    <span class="bx-authform-starrequired">*</span><?=GetMessage("AUTH_REQ")?>
                </div>

                <div class="bx-authform-link-container">
                    <a href="<?=$arResult["AUTH_AUTH_URL"]?>" rel="nofollow"><b><?=GetMessage("AUTH_AUTH")?></b></a>
                </div>

            </form>
        </noindex>

        <script type="text/javascript">
        document.bform.USER_NAME.focus();
        </script>

        <?endif?>

    </div>
</div>