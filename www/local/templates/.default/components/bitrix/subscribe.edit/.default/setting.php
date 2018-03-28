<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
//***********************************
//setting section
//***********************************
?>
<form action="<?=$arResult["FORM_ACTION"]?>" method="post">
<?echo bitrix_sessid_post();?>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="data-table">
<thead><tr><td colspan="2"><?echo GetMessage("subscr_title_settings")?></td></tr></thead>
<tr valign="top">
	<td width="40%">
		<p><?echo GetMessage("subscr_email")?><span class="starrequired">*</span><br />
		<input type="text" name="EMAIL" value="<?=$arResult["SUBSCRIPTION"]["EMAIL"]!=""?$arResult["SUBSCRIPTION"]["EMAIL"]:$arResult["REQUEST"]["EMAIL"];?>" size="30" maxlength="255" /></p>
		<p><?echo GetMessage("subscr_rub")?><span class="starrequired">*</span><br />
            <?$i = 0;?>
		<?foreach($arResult["RUBRICS"] as $itemID => $itemValue):?>
            <div class="check">
                <input class="check__input" name="RUB_ID[]" type="checkbox" id="zz<?=$i?>" value="<?=$itemValue["ID"]?>"<?if($itemValue["CHECKED"]) echo " checked"?>>
                <label class="check__label" for="zz<?=$i?>"><?=$itemValue["NAME"]?></label>
            </div><br>
		    <?$i++;?>
        <?endforeach;?></p>
		<p><?echo GetMessage("subscr_fmt")?><br />

        <div class="check" style="display: none">
            <input class="check__input" name="FORMAT" type="radio" id="r1" value="text"<?if($arResult["SUBSCRIPTION"]["FORMAT"] == "text") echo " checked"?>>
            <label class="check__label" for="r1"><?echo GetMessage("subscr_text")?></label>
        </div>
        <div class="check" style="display: none">
            <input class="check__input" name="FORMAT" type="radio" id="r2" value="html"<?if($arResult["SUBSCRIPTION"]["FORMAT"] == "html") echo " checked"?> >
            <label class="check__label" for="r2">HTML</label>
        </div>

	</td>
	<td width="60%">
		<p><?echo GetMessage("subscr_settings_note1")?></p>
		<p><?echo GetMessage("subscr_settings_note2")?></p>
	</td>
</tr>
<tfoot><tr><td colspan="2">
	<input type="submit" class="button" name="Save" value="<?echo ($arResult["ID"] > 0? GetMessage("subscr_upd"):GetMessage("subscr_add"))?>" />
	<input type="reset" class="button" value="<?echo GetMessage("subscr_reset")?>" name="reset" />
</td></tr></tfoot>
</table>
<input type="hidden" name="PostAction" value="<?echo ($arResult["ID"]>0? "Update":"Add")?>" />
<input type="hidden" name="ID" value="<?echo $arResult["SUBSCRIPTION"]["ID"];?>" />
<?if($_REQUEST["register"] == "YES"):?>
	<input type="hidden" name="register" value="YES" />
<?endif;?>
<?if($_REQUEST["authorize"]=="YES"):?>
	<input type="hidden" name="authorize" value="YES" />
<?endif;?>
</form>
<br />
