<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$WrokCatalog = new StockMan\Catalog\Workcatalog;
?>

<?if (!empty($arResult)):?>
    <?
    /*echo "<pre>";
    var_dump($arResult);
    echo "</pre>";*/

    /*$arMenu = array();
    $i=0;
    foreach ($arResult as $arItem) {
        $depthlevel = $arItem["DEPTH_LEVEL"];
        if ($arItem["IS_PARENT"]) {
            $depthlevel = $arItem["DEPTH_LEVEL"];
            $arMenu[] =
        }
    }*/
    ?>
    <div class="hide-for-small-only" id="menu-left">

        <ul class="cloth">
            <?
            $previousLevel = 0;
            foreach($arResult as $arItem):?>

                <?if ($previousLevel && $arItem["DEPTH_LEVEL"] < $previousLevel && !$selected){?>
                    <?=str_repeat("</li>", ($previousLevel - $arItem["DEPTH_LEVEL"]));?>
                <?} elseif ($previousLevel && $arItem["DEPTH_LEVEL"] < $previousLevel) {?>
                    <?=str_repeat("</ul></li>", ($previousLevel - $arItem["DEPTH_LEVEL"]));?>
                <?}?>

                <?if ($arItem["IS_PARENT"]):?>

                    <?if ($arItem["DEPTH_LEVEL"] == 1):?>
                        <li class="cloth__item" <?if (intval($WrokCatalog->GetElmentCountByName($arItem["TEXT"]))==0) {echo "style='display:none;'";}?>><a class="cloth__link <?if ($arItem["SELECTED"]) {?>cloth__link_more<?}?>" href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?><span class="cloth__num"><?=$WrokCatalog->GetElmentCountByName($arItem["TEXT"]);?></span></a>
                        <?if ($arItem["SELECTED"]) {?>
                            <?$selected = true;?>
                            <ul class="cloth">
                        <?} else {?>
                            <?$selected = false;?>
                        <?}?>
                    <?else:?>
                        <?if ($arItem["SELECTED"] || $selected) {?>
                            <li class="cloth__item" <?if (intval($WrokCatalog->GetElmentCountByName($arItem["TEXT"]))==0) {echo "style='display:none;'";}?>><a class="cloth__link <?if ($arItem["SELECTED"]) {?>cloth__link_more<?}?> cloth__link_inside" href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?><span class="cloth__num"><?=$WrokCatalog->GetElmentCountByName($arItem["TEXT"]);?></span></a>
                            <ul class="cloth">
                        <?}?>
                    <?endif?>

                <?else:?>

                    <?if ($arItem["PERMISSION"] > "D"):?>

                        <?if ($arItem["DEPTH_LEVEL"] == 1):?>
                            <li class="cloth__item" <?if (intval($WrokCatalog->GetElmentCountByName($arItem["TEXT"]))==0) {echo "style='display:none;'";}?>><a class="cloth__link <?if ($arItem["SELECTED"]) {?>cloth__link_more<?}?>" href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?><span class="cloth__num"><?=$WrokCatalog->GetElmentCountByName($arItem["TEXT"]);?></span></a></li>
                        <?else:?>
                            <?if ($selected) {?>
                                <li class="cloth__item" <?if (intval($WrokCatalog->GetElmentCountByName($arItem["TEXT"]))==0) {echo "style='display:none;'";}?>><a class="cloth__link cloth__link_inside <?if ($arItem["SELECTED"]) {?>cloth__link_more<?}?>" href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?><span class="cloth__num"><?=$WrokCatalog->GetElmentCountByName($arItem["TEXT"]);?></span></a></li>
                            <?}?>
                        <?endif?>

                    <?endif?>

                <?endif?>

                <?$previousLevel = $arItem["DEPTH_LEVEL"];?>

            <?endforeach?>

            <?if ($previousLevel > 1 && !$selected){//close last item tags?>
                <?=str_repeat("</li>", ($previousLevel-1) );?>
            <?} elseif ($previousLevel > 1){ ?>
                <?=str_repeat("</ul></li>", ($previousLevel-1) );?>
            <?}?>
        </ul>
    </div>


<?endif?>
