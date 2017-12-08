<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?if (!empty($arResult)):?>

    <?foreach($arResult as $arItem){?>
        <li class="bag__item"><a class="bag__link" href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a></li>
    <?}?>

<?endif?>