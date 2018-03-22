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
	$wrapperId = rand(0, 10000);

	?>
	<div class="bx-sopc" id="bx-sopc<?=$wrapperId?>">
		<div class="container-fluid">
			<div class="row">
				<div class="sale-order-payment-change-pp row">
					<div class="row sale-order-payment-change-inner-row">
						<div class="sale-order-payment-change-inner-row-body">
							<div class="col-xs-12 sale-order-payment-change-payment">
								<div class="sale-order-payment-change-payment-title">
									<?
									$paymentSubTitle = Loc::getMessage('SOPC_TPL_BILL')." ".Loc::getMessage('SOPC_TPL_NUMBER_SIGN').$arResult['PAYMENT']['ACCOUNT_NUMBER'];
									if(isset($arResult['PAYMENT']['DATE_BILL']))
									{
										$paymentSubTitle .= " ".Loc::getMessage('SOPC_TPL_FROM_DATE')." ".$arResult['PAYMENT']['DATE_BILL']->format("d.m.Y");
									}
									$paymentSubTitle .=",";
									echo '<strong>'.$paymentSubTitle.'</strong>';
									?>
									<span class="sale-order-payment-change-payment-title-element"><?=htmlspecialcharsbx($arResult['PAYMENT']['PAY_SYSTEM_NAME'])?></span>
									<?
									if ($arResult['PAYMENT']['PAID'] === 'Y')
									{
										?>
										<span class="sale-order-payment-change-status-success"><?=Loc::getMessage('SOPC_TPL_PAID')?></span>
										<?
									}
									elseif ($arResult['IS_ALLOW_PAY'] == 'N')
									{
										?>
										<span class="sale-order-payment-change-status-restricted"><?=Loc::getMessage('SOPC_TPL_RESTRICTED_PAID')?></span>
										<?
									}
									else
									{
										?>
										<span class="sale-order-payment-change-status-alert"><?=Loc::getMessage('SOPC_TPL_NOTPAID')?></span>
										<?
									}
									?>
								</div>
								<div class="sale-order-payment-change-payment-price">
									<span class="sale-order-payment-change-payment-element"><?=Loc::getMessage('SOPC_TPL_SUM_TO_PAID')?>:</span>

									<span class="sale-order-payment-change-payment-number"><?=SaleFormatCurrency($arResult['PAYMENT']["SUM"], $arResult['PAYMENT']["CURRENCY"])?></span>
								</div>
							</div>
						</div>
					</div>
					<div class="sale-order-payment-change-pp-list callout">
                        <div class="grid-x grid-padding-x small-up-1 medium-up-2 large-up-4" data-equalizer data-equalize-by-row="true">
                        <?
						foreach ($arResult['PAYSYSTEMS_LIST'] as $key => $paySystem)
						{
							?>

							<div class="sale-order-payment-change-pp-company cell">
								<div class="check check_pay">
									<input type="hidden"
										class="sale-order-payment-change-pp-company-hidden"
										name="PAY_SYSTEM_ID"
										value="<?=$paySystem['ID']?>"
										<?= ($key == 0) ? "checked='checked'" :""?>
									>
									<?
									if (empty($paySystem['LOGOTIP']))
										$paySystem['LOGOTIP'] = '/bitrix/images/sale/nopaysystem.gif';

									?>

                                    <img class="payment-img" src="<?=htmlspecialcharsbx($paySystem['LOGOTIP'])?>">
									<div class="sale-order-payment-change-pp-company-image"
										style="">
									</div>
									<div class="sale-order-payment-change-pp-company-smalltitle">
										<?=CUtil::JSEscape(htmlspecialcharsbx($paySystem['NAME']))?>
									</div>
								</div>
							</div>
							<?
						}
						?>
                        </div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<?
	$javascriptParams = array(
		"url" => CUtil::JSEscape($this->__component->GetPath().'/ajax.php'),
		"templateFolder" => CUtil::JSEscape($templateFolder),
		"accountNumber" => $arParams['ACCOUNT_NUMBER'],
		"paymentNumber" => $arParams['PAYMENT_NUMBER'],
		"inner" => $arParams['ALLOW_INNER'],
		"onlyInnerFull" => $arParams['ONLY_INNER_FULL'],
		"refreshPrices" => $arParams['REFRESH_PRICES'],
		"pathToPayment" => $arParams['PATH_TO_PAYMENT'],
		"wrapperId" => $wrapperId
	);
	$javascriptParams = CUtil::PhpToJSObject($javascriptParams);
	?>
	<script>
		var sc = new BX.Sale.OrderPaymentChange(<?=$javascriptParams?>);
	</script>
	<?
}

