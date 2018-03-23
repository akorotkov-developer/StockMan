<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

use Bitrix\Main\Localization\Loc;

if (!empty($arResult["errorMessage"]))
{
	if (!is_array($arResult["errorMessage"]))
	{
		ShowError($arResult["errorMessage"]);
	}
	else
	{
		foreach ($arResult["errorMessage"] as $errorMessage)
		{
			ShowError($errorMessage);
		}
	}
}
else
{
	if ($arParams['REFRESHED_COMPONENT_MODE'] === 'Y')
	{
		$wrapperId = str_shuffle(substr($arResult['SIGNED_PARAMS'],0,10));
		?>

		<div class="bx-sap" id="bx-sap<?=$wrapperId?>">
			<div class="container-fluid callout">
				<?
				if ($arParams['SELL_VALUES_FROM_VAR'] != 'Y')
				{
					if ($arParams['SELL_SHOW_FIXED_VALUES'] === 'Y')
					{
						?>
						<div class="row">
							<div class="col-xs-12 sale-acountpay-block">
								<h3 class="sale-acountpay-title"><?= Loc::getMessage("SAP_FIXED_PAYMENT") ?></h3>
								<div class="sale-acountpay-fixedpay-container">
									<div class="sale-acountpay-fixedpay-list">
										<?
										foreach ($arParams["SELL_TOTAL"] as $valueChanging)
										{
											?>
											<div class="sale-acountpay-fixedpay-item">
												<?=CUtil::JSEscape(htmlspecialcharsbx($valueChanging))?>
											</div>
											<?
										}
										?>
									</div>
								</div>
							</div>
						</div>
						<?
					}
					?>
					<div class="row">
						<div class="col-xs-12 sale-acountpay-block form-horizontal">
							<div class="" style="max-width: 200px;">
								<div class="form-group" style="margin-bottom: 0; float: left">
									<?
									$inputElement = "
										<div class='col-sm-9'>
										    <label><strong>Сумма</strong>
											<input type='text'	placeholder='0.00' 
											class='form-control input-lg sale-acountpay-input' value='0.00' "
											."name=".CUtil::JSEscape(htmlspecialcharsbx($arParams["VAR"]))." "
											.($arParams['SELL_USER_INPUT'] === 'N' ? "disabled" :"").
											"></label>
										</div>";
                                    $tempCurrencyRow = trim(str_replace("#", "", $arResult['FORMATED_CURRENCY']));
                                    $currencyRow = str_replace($tempCurrencyRow, $labelWrapper, $arResult['FORMATED_CURRENCY']);
                                    $currencyRow = str_replace("#", $inputElement, $currencyRow);
                                    echo $currencyRow;
									?>
								</div>
							</div>
                            <div style="position: relative; top: 38px; left: 30px;">
                                <?
                                echo $labelWrapper = "<label class='control-label input-lg input-lg col-sm-3'>".$tempCurrencyRow."</label>";
                                ?>
                            </div>
                            <div style="clear: both"></div>
						</div>
					</div>
				<?
				}
				else
				{
					if ($arParams['SELL_SHOW_RESULT_SUM'] === 'Y')
					{
						?>
						<div class="row">
							<div class="col-xs-12 sale-acountpay-block form-horizontal">
								<h3 class="sale-acountpay-title"><?=Loc::getMessage("SAP_SUM")?></h3>
								<h2><?=SaleFormatCurrency($arResult["SELL_VAR_PRICE_VALUE"], $arParams['SELL_CURRENCY'])?></h2>
							</div>
						</div>
						<?
					}
					?>
					<div class="row">
						<input type="hidden" name="<?=CUtil::JSEscape(htmlspecialcharsbx($arParams["VAR"]))?>"
							class="form-control input-lg sale-acountpay-input"
							value="<?=CUtil::JSEscape(htmlspecialcharsbx($arResult["SELL_VAR_PRICE_VALUE"]))?>">
					</div>
					<?
				}
				?>
				<div class="row">
					<div class="col-xs-12 sale-acountpay-block">
						<h3 class="sale-acountpay-title"><?=Loc::getMessage("SAP_TYPE_PAYMENT_TITLE")?></h3>
						<div>
							<div class="sale-acountpay-pp row">
								<div class="col-md-7 col-sm-8 col-xs-12 grid-x grid-padding-x small-up-1 medium-up-2 large-up-4" data-equalizer data-equalize-by-row="true">
									<?
                                    $idpay = 0;
									foreach ($arResult['PAYSYSTEMS_LIST'] as $key => $paySystem)
									{
                                        $idpay++;
										?>

										<div class="cell sale-acountpay-pp-company cell <?= ($key == 0) ? 'bx-selected' :""?>">
											<div class="sale-acountpay-pp-company-graf-container check check_pay">
                                                <input class="check__input sale-acountpay-pp-company-checkbox" type="radio" name="delivery" id="y<?=$idpay?>" name="PAY_SYSTEM_ID"
                                                       value="<?=$paySystem['ID']?>"
                                                    <?= ($key == 0) ? "checked='checked'" :""?>
                                                >

                                                <?
                                                if (isset($paySystem['LOGOTIP']))
                                                {
                                                ?>
                                                    <label class="check__label check__label_callout" for="y<?=$idpay?>" data-equalizer-watch>
                                                        <img src="<?=$paySystem['LOGOTIP']?>">
                                                        <?=CUtil::JSEscape(htmlspecialcharsbx($paySystem['NAME']))?>
                                                    </label>
                                                <?}?>


											</div>
										</div>

										<?
									}
									?>
                                    <script type="text/javascript">
                                        $('.check__label_callout').on('click', function() {
                                            $(".sale-acountpay-pp-company").parent(this).trigger('click');
                                            console.log($(".sale-acountpay-pp-company").parents(this).html());
                                        });
                                    </script>
								</div>
							</div>
						</div>



					</div>
				</div>
				<div class="row">
					<div class="col-xs-12">
						<a href="" class="btn btn-default btn-lg sale-account-pay-button button"><?=Loc::getMessage("SAP_BUTTON")?></a>
					</div>
				</div>
			</div>
		</div>
		<?
		$javascriptParams = array(
			"alertMessages" => array("wrongInput" => Loc::getMessage('SAP_ERROR_INPUT')),
			"url" => CUtil::JSEscape($this->__component->GetPath().'/ajax.php'),
			"templateFolder" => CUtil::JSEscape($templateFolder),
			"signedParams" => $arResult['SIGNED_PARAMS'],
			"wrapperId" => $wrapperId
		);
		$javascriptParams = CUtil::PhpToJSObject($javascriptParams);
		?>
		<script>
			var sc = new BX.saleAccountPay(<?=$javascriptParams?>);
		</script>
	<?
	}
	else
	{
		?>
		<h3><?=Loc::getMessage("SAP_BUY_MONEY")?></h3>
		<form method="post" name="buyMoney" action="">
			<?
			foreach($arResult["AMOUNT_TO_SHOW"] as $value)
			{
				?>
				<input type="radio" name="<?=CUtil::JSEscape(htmlspecialcharsbx($arParams["VAR"]))?>"
					value="<?=$value["ID"]?>" id="<?=CUtil::JSEscape(htmlspecialcharsbx($arParams["VAR"])).$value["ID"]?>">
				<label for="<?=CUtil::JSEscape(htmlspecialcharsbx($arParams["VAR"])).$value["ID"]?>"><?=$value["NAME"]?></label>
				<br />
				<?
			}
			?>
			<input type="submit" name="button" class="button" value="<?=GetMessage("SAP_BUTTON")?>">
		</form>
		<?
	}
}
?>

