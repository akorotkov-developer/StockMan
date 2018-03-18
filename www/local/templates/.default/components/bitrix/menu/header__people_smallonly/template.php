<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?if (!empty($arResult)){?>
    <ul class="people show-for-small-only">
        <?
        foreach($arResult as $arItem){
            if($arParams["MAX_LEVEL"] == 1 && $arItem["DEPTH_LEVEL"] > 1)
                continue;
            ?>
            <?if($arItem["SELECTED"]){
                ?><li class="people__item"><a class="people__link people__link_active" href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a></li><?
            } else {?>
                <li class="people__item"><a class="people__link" href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a></li>
            <?}?>
        <?}?>
    </ul>
<?}?>

