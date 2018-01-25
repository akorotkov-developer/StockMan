<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$WrokCatalog = new StockMan\Catalog\Workcatalog;
?>

<?if (!empty($arResult)):?>
<div class="cell small-12 medium-4 large-3 xlarge-2 text-center medium-text-left">
    <div class="hide-for-small-only" id="menu-left">
        <div class="margin-bottom-2"><a class="text-uppercase text-decoration-none" href="#">Вся одежда</a></div>
        <ul class="cloth">
            <?
            $previousLevel = 0;
            foreach($arResult as $arItem):?>

                <?if ($previousLevel && $arItem["DEPTH_LEVEL"] < $previousLevel):?>
                    <?=str_repeat("</ul></li>", ($previousLevel - $arItem["DEPTH_LEVEL"]));?>
                <?endif?>

                <?if ($arItem["IS_PARENT"]):?>

                    <?if ($arItem["DEPTH_LEVEL"] == 1):?>
                        <li class="cloth__item"><a class="cloth__link cloth__link_more" href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?><span class="cloth__num"><?=$WrokCatalog->GetElmentCountByName($arItem["TEXT"]);?></span></a>
                        <ul class="cloth">
                    <?else:?>
                        <li class="cloth__item"><a class="cloth__link cloth__link_more" href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?><span class="cloth__num"><?=$WrokCatalog->GetElmentCountByName($arItem["TEXT"]);?></span></a>
                        <ul class="cloth">
                    <?endif?>

                <?else:?>

                    <?if ($arItem["PERMISSION"] > "D"):?>

                        <?if ($arItem["DEPTH_LEVEL"] == 1):?>
                            <li class="cloth__item"><a class="cloth__link" href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?><span class="cloth__num"><?=$WrokCatalog->GetElmentCountByName($arItem["TEXT"]);?></span></a></li>
                        <?else:?>
                            <li class="cloth__item"><a class="cloth__link" href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?><span class="cloth__num"><?=$WrokCatalog->GetElmentCountByName($arItem["TEXT"]);?></span></a></li>
                        <?endif?>

                    <?else:?>

                        <?if ($arItem["DEPTH_LEVEL"] == 1):?>
                            <li class="cloth__item"><a class="cloth__link" href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?><span class="cloth__num"><?=$WrokCatalog->GetElmentCountByName($arItem["TEXT"]);?></span></a></li>
                        <?else:?>
                            <li class="cloth__item"><a class="cloth__link" href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?><span class="cloth__num"><?=$WrokCatalog->GetElmentCountByName($arItem["TEXT"]);?></span></a></li>
                        <?endif?>

                    <?endif?>

                <?endif?>

                <?$previousLevel = $arItem["DEPTH_LEVEL"];?>

            <?endforeach?>

            <?if ($previousLevel > 1)://close last item tags?>
                <?=str_repeat("</ul></li>", ($previousLevel-1) );?>
            <?endif?>
        </ul>
    </div>
</div>

<?endif?>
