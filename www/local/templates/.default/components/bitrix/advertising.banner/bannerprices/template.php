<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$frame = $this->createFrame()->begin("");
?>
    <div class="cell large-3 medium-6 medium-order-3">
        <a class="coat" href="<?=$arResult["LINK_BANNER"]?>" style="background-image:url(<?=$arResult["IMG_BANNER"]?>);">
            <?=$arResult["BANNER_PROPERTIES"]["CODE"]?>
        </a>
    </div>
<?
$frame->end();

