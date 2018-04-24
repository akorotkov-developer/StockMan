<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>
<?if($arParams[NOINDEX_WIDGET]=="Y"){?><!--googleoff: all--><!--noindex--><?}?>
<?foreach($arResult[ERRORS] as $errorItem){
    echo "<div class=\"zaiv-instagram-gallery-error\">$errorItem</div>";
}?>
<?if(!$arResult[ERRORS]){?>
    <div class="girl text-center">
        <?foreach($arResult[ITEMS] as $arItem){?>
            <div class="girl__slide">
                <a href="<?=$arItem[LINK]?>" target="_blank">
                    <img src="<?=$arItem[IMAGE_PREVIEW]?>" alt="<?=$arItem[DESCRIPTION]?>">
                </a>
            </div>
        <?}?>
    </div>
<?}?>