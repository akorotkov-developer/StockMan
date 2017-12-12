<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$frame = $this->createFrame()->begin("");
?>
    <div class="cell large-6 large-order-2 medium-order-1">
        <a class="coat" href="<?=$arResult["LINK_BANNER"]?>" style="background-image:url(<?=$arResult["IMG_BANNER"]?>);">
            <?=$arResult["BANNER_PROPERTIES"]["CODE"]?>
        </a>
    </div>
<?
$frame->end();

