<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?if (!empty($arResult)):?>
<ul class="menu vertical">
    <?
    foreach($arResult as $arItem):
        if($arParams["MAX_LEVEL"] == 1 && $arItem["DEPTH_LEVEL"] > 1)
            continue;
    ?>
        <?

        if ( strpos($APPLICATION->GetCurPage(), "/orders") !=0 and $_GET["filter_history"] and $arItem["TEXT"]=="Текущие заказы") {
            ?>
            <li><a href="<?= $arItem["LINK"] ?>"><?= $arItem["TEXT"] ?></a></li>
            <?
        } else {
        ?>
            <?if($arItem["SELECTED"]):?>
                <li class="active"><a href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a></li>
            <?else:?>
                <?if ($arItem["ADDITIONAL_LINKS"]["SELECT_Y"] == "Y") {?>
                    <li  class="active"><a href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a></li>
                <?} else {?>
                    <li><a href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a></li>
                <?}?>
            <?endif?>
        <?
        }
        ?>

<?endforeach?>

</ul>
<?endif?>
