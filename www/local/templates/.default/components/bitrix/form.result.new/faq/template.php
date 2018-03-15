<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
?>

<?=$arResult["FORM_NOTE"]?>


<?if ($arResult["isFormNote"] != "Y")
{
?>
    <?=$arResult["FORM_HEADER"]?>

        <?
        if ($arResult["isFormDescription"] == "Y" || $arResult["isFormTitle"] == "Y" || $arResult["isFormImage"] == "Y")
        {
            ?>
            <div class="grid-container">
                <div class="grid-x grid-padding-x">
                    <div class="cell">
                        <h2 class="text-center">Нет нужного ответа?<br>Задайте свой вопрос</h2>
                    </div>
                </div>
            </div>
            <?
        }
        ?>
    <?if ($arResult["isFormErrors"] == "Y"):?>
        <div class="grid-container">
            <div class="grid-x grid-padding-x">
                <div class="cell text-center"><?=$arResult["FORM_ERRORS_TEXT"];?></div>
            </div>
        </div>
    <?endif;?>
    <div class="grid-container">
        <div class="grid-x grid-padding-x align-center">
            <div class="small-12 medium-9 large-7 cell">
                <div class="callout">
                        <?
                        foreach ($arResult["QUESTIONS"] as $FIELD_SID => $arQuestion)
                        {
                            if ($arQuestion['STRUCTURE'][0]['FIELD_TYPE'] == 'hidden')
                            {
                                echo $arQuestion["HTML_CODE"];
                            }
                            else
                            {
                                ?>
                                <?if (is_array($arResult["FORM_ERRORS"]) && array_key_exists($FIELD_SID, $arResult['FORM_ERRORS'])):?>
                                <span class="error-fld" title="<?=htmlspecialcharsbx($arResult["FORM_ERRORS"][$FIELD_SID])?>"></span>
                            <?endif;?>
                                <label><?=$arQuestion["CAPTION"]?><?if ($arQuestion["REQUIRED"] == "Y"){?><?=$arResult["REQUIRED_SIGN"];?><?}?><?
                                    if ($arQuestion["STRUCTURE"][0]["FIELD_TYPE"] == 'email') {
                                        ?><span class="text-dark-gray">&nbsp; для ответа вам на вопрос</span><?
                                    }
                                    ?></label>
                                <?
                                if ($arQuestion["REQUIRED"] == "Y"){
                                    $arQuestion["HTML_CODE"] = str_replace("name=","required name=", $arQuestion["HTML_CODE"]);
                                }
                                ?>
                                <?=$arQuestion["HTML_CODE"]?>
                                <?
                            }
                        } //endwhile
                        ?>
                    <?
                    if($arResult["isUseCaptcha"] == "Y")
                    {
                        ?>
                        <table>
                        <tr>
                            <th colspan="2"><b><?=GetMessage("FORM_CAPTCHA_TABLE_TITLE")?></b></th>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td><input type="hidden" name="captcha_sid" value="<?=htmlspecialcharsbx($arResult["CAPTCHACode"]);?>" /><img src="/bitrix/tools/captcha.php?captcha_sid=<?=htmlspecialcharsbx($arResult["CAPTCHACode"]);?>" width="180" height="40" /></td>
                        </tr>
                        <tr>
                            <td><?=GetMessage("FORM_CAPTCHA_FIELD_TITLE")?><?=$arResult["REQUIRED_SIGN"];?></td>
                            <td><input type="text" name="captcha_word" size="30" maxlength="50" value="" class="inputtext" /></td>
                        </tr>
                        </table>
                        <?
                    } // isUseCaptcha
                    ?>
                    <input class="button small-expanded" <?=(intval($arResult["F_RIGHT"]) < 10 ? "disabled=\"disabled\"" : "");?> type="submit" name="web_form_submit" value="<?=htmlspecialcharsbx(strlen(trim($arResult["arForm"]["BUTTON"])) <= 0 ? GetMessage("FORM_ADD") : $arResult["arForm"]["BUTTON"]);?>" />
                </div>
            </div>
        </div>
    </div>
    <?=$arResult["FORM_FOOTER"]?>
<?
}
?>