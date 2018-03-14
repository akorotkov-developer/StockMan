<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?if (!empty($arResult)){?>
    <div class="cell large-4 medium-4 text-center medium-text-left header__gender">
        <div class="sort">
            <?
            $flag = false;
            foreach($arResult as $arItem){
                if($arParams["MAX_LEVEL"] == 1 && $arItem["DEPTH_LEVEL"] > 1)
                    continue;
                ?>
                <?if($arItem["SELECTED"]){
                    $flag = true;?>
                    <div class="sort__main"><?=$arItem["TEXT"]?></div>
                <?}?>
            <?}
            if (!$flag) {
                ?><div class="sort__main">Каталог</div><?
            }
            ?>
            <div class="sort__other">
                <div class="sort__over">
                    <?
                    foreach($arResult as $arItem){
                        if($arParams["MAX_LEVEL"] == 1 && $arItem["DEPTH_LEVEL"] > 1)
                            continue;
                        ?>
                        <?if($arItem["SELECTED"]){

                        } else {?>
                            <div> <a href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a></div>
                        <?}?>
                    <?}?>
                </div>
            </div>
        </div>
    </div>
<?}?>
