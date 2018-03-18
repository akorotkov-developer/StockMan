<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="callout">
    <div class="sale-personal-account-wallet-container">
            <div class="sale-personal-account-wallet-title">
                <h4><?=Bitrix\Main\Localization\Loc::getMessage('SPA_BILL_AT')?>
                <span><?=$arResult["DATE"];?></span></h4>
            </div>

            <div class="sale-personal-account-wallet-list-container">
                <div class="sale-personal-account-wallet-list">
                    <?
                    foreach($arResult["ACCOUNT_LIST"] as $accountValue)
                    {
                        ?>
                        <div class="sale-personal-account-wallet-list-item">
                            <div class="sale-personal-account-wallet-sum"><?=$accountValue['SUM']?></div>
                        </div>
                        <?
                    }
                    ?>
                </div>
            </div>
        </div>
 </div>
