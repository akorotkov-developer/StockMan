<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
/**
 * @global array $arParams
 * @global CUser $USER
 * @global CMain $APPLICATION
 * @global string $cartId
 */
$compositeStub = (isset($arResult['COMPOSITE_STUB']) && $arResult['COMPOSITE_STUB'] == 'Y');
?>

	<?
        if (!$compositeStub) {
            if ($arParams['SHOW_NUM_PRODUCTS'] == 'Y' && ($arResult['NUM_PRODUCTS'] > 0 || $arParams['SHOW_EMPTY_VALUES'] == 'Y')) {?>
                <div id="<?=$cartId?>">
                    <a class="header__enter header__enter_right text-center" href="<?= $arParams['PATH_TO_BASKET'] ?>"><?echo $arResult['NUM_PRODUCTS']?></a>
                </div>
    <?      }
        }
    ?>

